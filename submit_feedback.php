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

// Check the connection
if (!$con) {
    echo "Error: Unable to open database\n";
} else {
    // Get the form data
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $message = $_POST['message'];
    $date = $_POST['date'];

    // Sanitize the input to prevent SQL injection
    $name = pg_escape_string($name);
    $phone = pg_escape_string($phone);
    $message = pg_escape_string($message);
    $date = pg_escape_string($date);

    // Insert data into the feedback table
    $query = "INSERT INTO feedback (name, phone, message, date) VALUES ('$name', '$phone', '$message', '$date')";
    $result = pg_query($con, $query);

    if ($result) {
        // Redirect to a confirmation page or display a success message
        header("Location: thank_you.html"); // Make sure to create this page
        exit();
    } else {
        echo "Error: " . pg_last_error($con);
    }
}

// Close the connection
pg_close($con);
?>
