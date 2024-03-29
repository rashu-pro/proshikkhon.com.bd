<?php
/**
 * * Generates access token
 * -- stores it into database
 * @return bool
 */
function grant_access_token(){
  $base_url = esc_attr(get_option('base_url_test'));

  $app_key = esc_attr(get_option('app_key_test'));
  $app_secret = esc_attr(get_option('secret_key_test'));

  $username = esc_attr(get_option('username_test'));
  $password = esc_attr(get_option('password_test'));

  $selected_payment_mode = esc_attr(get_option('bkash_payment_mode'));
  if($selected_payment_mode === 'live'){
    $base_url = esc_attr(get_option('base_url_live'));
    $app_key = esc_attr(get_option('app_key_live'));
    $app_secret = esc_attr(get_option('secret_key_live'));
  
    $username = esc_attr(get_option('username'));
    $password = esc_attr(get_option('password'));
  }

  $curl = curl_init();

  curl_setopt_array($curl, array(
    CURLOPT_URL => $base_url.'/tokenized/checkout/token/grant',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => json_encode(array(
      "app_key" => $app_key,
      "app_secret" => $app_secret
    )),
    CURLOPT_HTTPHEADER => array(
      'username: '.$username,
      'password: '.$password,
      'Content-Type: application/json'
    ),
  ));

  $response = curl_exec($curl);

  curl_close($curl);
  $response = json_decode($response);
  if($response->statusCode == '0000'){
    $inserted_id = insert_token($response);
    $new_token_row = get_row_from_table_by_column('tokens', 'id', $inserted_id);
    return $new_token_row->access_token;
  }
  return false;
}

function insert_token($response){
  $columns_array = array(
    'id INT NOT NULL AUTO_INCREMENT PRIMARY KEY',
    'access_token VARCHAR(255) DEFAULT NULL',
    'refresh_token VARCHAR(255) DEFAULT NULL',
    'expires_in INT DEFAULT NULL',
    'token_type VARCHAR(255) DEFAULT NULL',
    'token_mode VARCHAR(255) DEFAULT NULL',
    'notes VARCHAR(255) DEFAULT NULL',
    'is_active INT DEFAULT 0',
    'is_deleted INT DEFAULT 0',
    'created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
    'updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
  );
  create_table('tokens', $columns_array);
  $data = array(
    'access_token' => $response->id_token,
    'refresh_token' => $response->refresh_token,
    'expires_in' => time() + $response->expires_in,
    'token_type' => $response->token_type,
    'token_mode' => esc_attr(get_option('bkash_payment_mode')),
    'is_active' => 1
  );

  $inserted_id = insert_a_row('tokens', $data);

  if(!$inserted_id) return false;

  // Make all the token inactive except the inserted one
  $data_to_update = array(
    'is_active' => 0
  );
  // WHERE clause conditions
  $where_clause = array(
    'id NOT IN' => $inserted_id,
    'token_mode' => $data['token_mode']
  );
  update_a_row('tokens', $data_to_update, $where_clause);
  return $inserted_id;
}

function get_access_token(){
  global $wpdb;
  $selected_payment_mode = esc_attr(get_option('bkash_payment_mode'));
  $table_token = $wpdb->prefix . 'tokens';
  $sql = $wpdb->prepare("
  SELECT access_token, expires_in, refresh_token
  FROM $table_token
  WHERE token_mode = '".$selected_payment_mode."'
  AND is_active = 1 ORDER BY created_at DESC
  ");
  $token_row = $wpdb->get_row($sql);
  // return $token_row;
  if(!$token_row) return grant_access_token();

  if(time() < $token_row->expires_in) return $token_row->access_token;

  return refresh_access_token($token_row->refresh_token);
}

function refresh_access_token($refresh_token){
  $base_url = esc_attr(get_option('base_url_test'));

  $app_key = esc_attr(get_option('app_key_test'));
  $app_secret = esc_attr(get_option('secret_key_test'));

  $username = esc_attr(get_option('username_test'));
  $password = esc_attr(get_option('password_test'));

  $selected_payment_mode = esc_attr(get_option('bkash_payment_mode'));
  if($selected_payment_mode === 'live'){
    $base_url = esc_attr(get_option('base_url_live'));
    $app_key = esc_attr(get_option('app_key_live'));
    $app_secret = esc_attr(get_option('secret_key_live'));
  
    $username = esc_attr(get_option('username'));
    $password = esc_attr(get_option('password'));
  }


  $curl = curl_init();

  curl_setopt_array($curl, array(
    CURLOPT_URL => $base_url.'/tokenized/checkout/token/refresh',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS =>json_encode(array(
      "app_key" => $app_key,
      "app_secret" => $app_secret,
      "refresh_token" => $refresh_token
    )),
    CURLOPT_HTTPHEADER => array(
      'username: '.$username,
      'password: '.$password,
      'Content-Type: application/json'
    ),
  ));

  $response = curl_exec($curl);

  curl_close($curl);
  $response = json_decode($response);

  if($response->status_code == '0000'){
    $inserted_id = insert_token($response);

    $new_token_row = get_row_from_table_by_column('tokens', 'id', $inserted_id);
    return $new_token_row->access_token;
  }
  return false;
}
