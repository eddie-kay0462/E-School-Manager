<?php
$host = 'localhost';
$dbname = 'webtech_fall2024_edward_mensah';
$username = 'edward.mensah';
$password = '';

$conn = mysqli_connect($host, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
// echo "Connected successfully!!!!!!";