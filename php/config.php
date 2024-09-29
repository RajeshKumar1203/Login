<?php
session_start();
$hostname = 'localhost';
$username = 'root';
$password = ''; 
$db = 'task_db';

if (!$hostname || !$username || !$password === null || !$db) {
    die("Database configuration is incomplete.");
}

$con = mysqli_connect($hostname, $username, $password, $db);

if (!$con) {
    die("Failed to establish connection: " . mysqli_connect_error());
}


// mysqli_close($con);
?>
