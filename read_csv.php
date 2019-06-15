<?php

include_once 'create_table.php';
include_once 'save_csv.php';

$content = $_POST['data']; // Get Content of CSV file

$arr = explode(".", $_POST['file_name'], 2); // Creating name of table from csv file name

$table_name = $arr[0]; // Table name

$table = new Table($table_name); // Create new object for creating table

$lines = explode("\n", $content); // Explode content of CSV file

$headers = explode(',', $lines[0]); // Get Headers of CSV file

$headers_sql = array();
foreach ($headers as $header) {
    $headers_sql[] = strtolower(str_replace(' ', '_', $header)); // Remove space add '_' and all strings to be lower character
}

session_start();

// Check Session and save headers to session if not exist

if (!isset($_SESSION['headers'])) {
    $_SESSION['headers'] = $headers_sql;
    echo 'New session created';
}

$is_table_exist = $table->is_table_exist(); // Check table that created is exist or not

if ($is_table_exist == FALSE || empty($is_table_exist)) {
    $create_table = $table->create_table($headers_sql); // Create table
}

$csv_row = array();

foreach ($lines as $key => $line) {
    if ($key > 0) {
        $csv_row[] =  str_getcsv($line);
    }
}

// Combine headers and csv rows to create new array

function replace_array_key()
{
    global $csv_row;
    if (isset($_SESSION['headers'])) {
        $headers = $_SESSION['headers'];
    }
    $result = array();
    foreach ($csv_row as $array) {
        $result[] = array_combine($headers, $array);
    }

    return $result;
}

save_csv_data();

function save_csv_data() // Save CSV data to database
{
    $csv = new CSV;
    global $table_name;
    $records = replace_array_key(); // Get array of CSV files
    foreach ($records as $record) {
        $result = $csv->insert($table_name, $record); // Insert records
    }
}
