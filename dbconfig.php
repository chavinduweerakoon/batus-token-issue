<?php
session_start();
// $host = "localhost";
// $user = "root";
// $password = "root";
// $dbname = "demoaccess";

// $con = mysqli_connect($host, $user, $password, $dbname);
// // Check connection
// if (!$con) {
//     die("Connection failed: " . mysqli_connect_error());
// }
$host = "localhost";
$port = 3306;
$socket = "";
$user = "root";
$password = "root";
$dbname = "demoaccess";

try {
    $pdo = new PDO("mysql:host={$host};port={$port};dbname={$dbname}", $user, $password);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
