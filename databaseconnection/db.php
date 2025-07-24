<?php
// assets/db.php
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'school_db';

// Create database connection
$con = new mysqli($host, $username, $password, $database);

// Check connection
if ($con->connect_error) {
    die('Connection failed: ' . $con->connect_error);
}
?>
