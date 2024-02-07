<?php
function pay_with_bkash()
{
  $app_key = esc_attr(get_option('app_key_test'));
  $base_url = esc_attr(get_option('base_url_test'));

  $selected_payment_mode = esc_attr(get_option('bkash_payment_mode'));
  if($selected_payment_mode === 'live'){
    $base_url = esc_attr(get_option('base_url_live'));
    $app_key = esc_attr(get_option('app_key_live'));
  }

  $access_token = get_access_token();
  if ($access_token) {
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => $base_url.'/tokenized/checkout/create',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => json_encode(array(
        "mode" => "0011",
        "payerReference" => "payment-from-proshikkhon.com.bd",
        "callbackURL" => "https://proshikkhon.com.bd/payment-success/",
        "amount" => $_POST['amount'],
        "currency" => "BDT",
        "intent" => "sale",
        "merchantInvoiceNumber" => "Inv".generateUniqueSixDigitNumber()
      )),
      CURLOPT_HTTPHEADER => array(
        'x-app-key: '.$app_key,
        'Content-Type: application/json',
        'Authorization: Bearer '.$access_token
      ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    echo $response;
    die();
  }

}

function generateUniqueSixDigitNumber() {
  // Generate a unique 6-digit number using timestamp and random number
  $uniqueNumber = mt_rand(100000, 999999) . time() % 1000;
  return $uniqueNumber;
}
