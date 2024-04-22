<?php
session_start();

require_once('DBconnect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['user_id']) && isset($_POST['name']) && isset($_POST['department']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['confirmPassword'])) {
        // Retrieve form data
        $_SESSION['user_id'] = $_POST['user_id'];
		$user_id = $_POST['user_id'];
		$name = $_POST['name'];
        $name = $_POST['name'];
        $department = $_POST['department'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirmPassword'];

        // Validate password length and format
        if (strlen($password) < 8 || !preg_match("/^(?=.*[a-zA-Z])(?=.*\d).{8,}$/", $password)) {
            echo "Password must be at least 8 characters long and contain both letters and numbers.";
        } elseif ($password != $confirmPassword) {
            echo "Passwords do not match.";
        } else {
            // Determine user type based on user ID
            $firstChar = substr($user_id, 0, 1);
            if ($firstChar == '1') {
                $user_type = 'Faculty';
            } elseif ($firstChar == '2') {
                $user_type = 'Student';
            } elseif ($firstChar == '3') {
                $user_type = 'Student Tutor';
            } else {
                $user_type = 'unknown'; // Default type for other cases
            }

            // Check if user_id already exists
            $checkUserIDQuery = "SELECT * FROM user_info WHERE user_id ='$user_id'";
            $checkUserIDResult = mysqli_query($conn, $checkUserIDQuery);
            if (mysqli_num_rows($checkUserIDResult) > 0) {
                echo " User ID already exists. Please choose a different one.";
            } else {
                // Insert user data into database
                $sql = "INSERT INTO user_info (user_id, user_type, name, department, email, password) VALUES ('$user_id', '$user_type', '$name', '$department', '$email', '$password')";
                if (mysqli_query($conn, $sql)) {
                    // Redirect to schedule page after successful signup
                    header("Location: insert_schedule.html");
                    exit();
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


