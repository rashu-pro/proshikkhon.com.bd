<?php
/**
 * @param $table_name
 * @param $data
 * @return bool|int|mysqli_result|resource|null
 * Inserts a row into a table
 */
function insert_a_row($table_name, $data)
{
  global $wpdb;
  $table_name = $wpdb->prefix . $table_name;

  // Inserts a new row
  return $wpdb->insert(
    $table_name,
    $data
  );
}

/**
 * @param $table_name
 * @param $data_to_update
 * @param $where_column_name
 * @param $where_column_value
 * @return bool|int|mysqli_result|resource|null
 * Update a specific row for a specific table
 */
function update_a_row($table_name, $data_to_update, $where_clause)
{
  global $wpdb;
  // Define your table name
  $table_name = $wpdb->prefix . $table_name;

  // Perform the update
  return $wpdb->update($table_name, $data_to_update, $where_clause);
}
