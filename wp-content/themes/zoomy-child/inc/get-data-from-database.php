<?php
/**
 * * Gets a  row by a column
 * @param $table_name
 * @param $column_name
 * @param $column_value
 * @return array|object|stdClass|void|null
 */
function get_row_from_table_by_column($table_name, $column_name, $column_value)
{
  global $wpdb;
  $table_name = $wpdb->prefix . $table_name;

  // Get the rows by the column
  $sql = $wpdb->prepare("SELECT * FROM $table_name WHERE $column_name = $column_value");
  return $wpdb->get_row($sql);
}
