<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Replace with your own database credentials
$host = "localhost";
$user = "root";
$password = "";
$database = "greatmove library";

// Create a new MySQLi object
$conn = new mysqli($host, $user, $password, $database);

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare the SQL statement
$sql = "INSERT INTO users (username, password, email, role) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

// Bind the parameters and set their values
$username = "testuser";
$password = "testpassword";
$email = "testemail@example.com";
$role = "testrole";
$stmt->bind_param("ssss", $username, $password, $email, $role);

// Execute the statement and check for errors
if ($stmt->execute() === FALSE) {
    die("Error: " . $sql . "<br>" . $conn->error);
}

echo "New user created successfully";

// Close the statement and connection
$stmt->close();
$conn->close();
?>

