<?php
$dbHost = 'localhost';
$dbUsername = 'root';
$dbPassword = 'root';
$dbName = 'Library';
//connect with the database
$db = new mysqli($dbHost,$dbUsername,$dbPassword,$dbName);
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

?>