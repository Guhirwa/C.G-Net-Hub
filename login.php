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
$username = isset($_POST['username']) ? $_POST['username'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

// Sanitize the input to prevent SQL injection
$username = pg_escape_string($username);
$password = pg_escape_string($password);

// Check if user exists
$query = "SELECT * FROM Members WHERE username='$username'";
$result = pg_query($con, $query);

if (pg_num_rows($result) > 0) {
    $row = pg_fetch_assoc($result);
    // Verify password
    if (password_verify($password, $row['password'])) {
        // Successful login
        // Redirect to the personalized welcome page or updates page based on context
        header('Location: welcome.html'); // Change to 'updates.html' if you prefer
        exit();
    } else {
        // Invalid password
        echo "Invalid password. Please try again.";
    }
} else {
    // User does not exist, redirect to signup page
    header('Location: signup.html');
    exit();
}

// Close the connection
pg_close($con);
?>
