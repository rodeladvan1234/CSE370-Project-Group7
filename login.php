<?php
require_once('DBconnect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['user_id']) && isset($_POST['password'])) {
        // Retrieve form data
        $user_id = $_POST['user_id'];
        $password = $_POST['password'];
        

    // Query to check if user exists
    $sql = "SELECT * FROM user_info WHERE user_id='$user_id' AND password='$password'";
    $result = mysqli_query($conn, $sql);

    // If user exists, set session and redirect to dashboard
    if (mysqli_num_rows($result) != 0) {
        // Redirect to schedule page after successful signup
        header("Location: Schedule.html");
        exit();
    } else {
        // Invalid credentials, display error message
        echo "Invalid email or password.";
    }

    mysqli_close($conn);
	}
}
?>
