<?php
require_once('DBconnect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['user_id']) && isset($_POST['name']) && isset($_POST['department']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['confirmPassword'])) {
        $user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $department = mysqli_real_escape_string($conn, $_POST['department']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        $confirmPassword = mysqli_real_escape_string($conn, $_POST['confirmPassword']);

        // Check if passwords match and meet the required format
        if ($password !== $confirmPassword) {
            echo "Passwords do not match.";
        } elseif (strlen($password) < 8 || !preg_match("/^(?=.*[a-zA-Z])(?=.*\d).{8,}$/", $password)) {
            echo "Password must be at least 8 characters long and include both letters and numbers.";
        } else {
            // Check for existing user_id
            $checkUserIDQuery = "SELECT user_id FROM user_info WHERE user_id = '$user_id'";
            $checkResult = mysqli_query($conn, $checkUserIDQuery);

            if (mysqli_num_rows($checkResult) > 0) {
                echo "User ID already exists. Please use a different ID.";
            } else {
                // Insert new user into database
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT); // Hash password
                $sql = "INSERT INTO user_info (user_id, name, department, email, password) VALUES ('$user_id', '$name', '$department', '$email', '$hashedPassword')";
                
                if (mysqli_query($conn, $sql)) {
                    echo "User registered successfully. Redirecting to login...";
                    echo "<meta http-equiv='refresh' content='3;url=login.html'>"; // Redirect after 3 seconds
                } else {
                    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                }
            }
        }
    } else {
        echo "All fields are required.";
    }

    mysqli_close($conn);
}
?>
