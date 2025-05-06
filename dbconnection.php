<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$host = 'localhost';
$db   = 'test';
$user = 'postgres';
$pass = 'postgres';
$port = '5432';

$conn_string = "host=$host port=$port dbname=$db user=$user password=$pass";

$conn = pg_connect($conn_string);

if (!$conn) {
    die("Error: Unable to connect to database");
}
