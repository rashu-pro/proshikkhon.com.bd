<?php
/**
 * @param $table_name
 * @param $columns_array
 * @return array
 */
function create_table($table_name, $columns_array){
  $status = false;
  $message = '<p style="color:#E91E63;text-align: center">'.$table_name.'table hasn\'t been created, try again!</p>';
  $table_exists = false;

  global $wpdb;
  $table_name = $wpdb->prefix . $table_name;
  $charset_collate = $wpdb->get_charset_collate();

  if ($wpdb->get_var("SHOW TABLES LIKE %s", $table_name) == $table_name){
    $table_exists = true;
  }

  if ($wpdb->get_var("SHOW TABLES LIKE %s", $table_name) != $table_name) {
    $sql = "CREATE TABLE $table_name (" . implode(', ', $columns_array) . ") $charset_collate;";
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
    $status = true;
  }

  if ($wpdb->get_var("SHOW TABLES LIKE %s", $table_name) == $table_name && !$table_exists){
    $message = '<p style="color:#009688;text-align:center"><strong>'.$table_name.'</strong> table has been created.</p>';
  }

  if ($wpdb->get_var("SHOW TABLES LIKE %s", $table_name) == $table_name && $table_exists){
    $message = '<p style="color:#d28718;text-align:center"><strong>'.$table_name.'</strong> table exists.</p>';
  }

  return array(
    'status' => $status,
    'message' => $message
  );
}
