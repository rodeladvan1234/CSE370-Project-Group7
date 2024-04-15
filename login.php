<?php
require_once('DBconnect.php');

session_start(); // Start the session.

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['user_id']) && isset($_POST['password'])) {
        $user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);

        // Query to check if user exists
        $sql = "SELECT * FROM user_info WHERE user_id = '$user_id' AND password = '$password'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) == 1) {
            $user = mysqli_fetch_assoc($result);

            // Store user info in session
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['user_type'] = substr($user['user_id'], 0, 2); // Assume user type is determined by the first two characters.

            // Redirect based on user type
            if ($_SESSION['user_type'] == '10') {
                header("Location: FacultyDashboard.html");
            } else if ($_SESSION['user_type'] == '20') {
                header("Location: StudentDashboard.html");
            } else {
                // Default redirection or error handling
                echo "Access Denied.";
            }
            exit();
        } else {
            echo "Invalid user ID or password.";
        }
        mysqli_close($conn);
    }
}
?>
