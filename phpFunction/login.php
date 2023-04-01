<?php

// Database configuration
$host = "localhost";
$username = "root";
$password = "";
$database = "greatmove library";

// Create a connection
$conn = mysqli_connect($host, $username, $password, $database);

// Check if the connection was successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Log in user
$username = $_POST["username"];
$password = $_POST["password"];

$sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // User has logged in successfully
    header("Location: ../Index.html");
} else {
    // Login failed
    echo "Invalid username or password.";
}