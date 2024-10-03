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
$email = isset($_POST['email']) ? $_POST['email'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

// Sanitize the input to prevent SQL injection
$username = pg_escape_string($username);
$email = pg_escape_string($email);
$password = pg_escape_string($password);

// Hash the password
$hashed_password = password_hash($password, PASSWORD_BCRYPT);

// Check if user already exists
$check_query = "SELECT * FROM Members WHERE username='$username' OR email='$email'";
$check_result = pg_query($con, $check_query);

if (pg_num_rows($check_result) > 0) {
    // User already exists
    header('Location: already_exists.html');
    exit();
} else {
    // Insert new user
    $insert_query = "INSERT INTO Members (username, email, password) VALUES ('$username', '$email', '$hashed_password')";
    $insert_result = pg_query($con, $insert_query);

    if ($insert_result) {
        header('Location: success.html');
        exit();
    } else {
        echo "Error: " . pg_last_error($con);
    }
}

// Close the connection
pg_close($con);
?>
