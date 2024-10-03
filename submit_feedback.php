<?php
// Database connection details
$host = "localhost";
$port = "5432"; // Default PostgreSQL port; adjust if different
$dbname = "cgnethub";
$user = "postgres";
$password = "amazimeza12QW!@";

// Create a connection string
$conn_str = "host=$host port=$port dbname=$dbname user=$user password=$password";

// Create a connection to the database
$con = pg_connect($conn_str) or die("Could not connect to server\n");

// Handle form data
$name = isset($_POST['name']) ? $_POST['name'] : '';
$phone = isset($_POST['phone']) ? $_POST['phone'] : '';
$service = isset($_POST['service']) ? $_POST['service'] : '';
$message = isset($_POST['message']) ? $_POST['message'] : '';

// Sanitize the input to prevent SQL injection
$name = pg_escape_string($name);
$phone = pg_escape_string($phone);
$service = pg_escape_string($service);
$message = pg_escape_string($message);

// Prepare the INSERT query
$query = "INSERT INTO Feedback (Names, Phone, Service_Requi, Message) VALUES ('$name', '$phone', '$service', '$message')";
$result = pg_query($con, $query);

if ($result) {
    // Redirect to the thank you page
    header("Location: Thank_your.html");
    exit();
} else {
    echo "Error: " . pg_last_error($con);
}

// Close the connection
pg_close($con);
?>
