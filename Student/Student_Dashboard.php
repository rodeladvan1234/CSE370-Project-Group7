<?php
session_start(); // Start the session

require_once('DBconnect.php');

// Check if the user is logged in
if (!isset($_SESSION['User_ID'])) {
    // Redirect to the login page if the user is not logged in
    header("Location: sign_up.html");
    exit();
}

// Get the User_ID from the session
$userID = $_SESSION['User_ID'];

// Check if a Student_ID was submitted
if (isset($_POST['Student_ID'])) {
    // Get the submitted Student_ID
    $studentID = $_POST['Student_ID'];

    // Validate the Student_ID
    if (is_numeric($studentID) && strlen($studentID) == 8) {
        // Query to retrieve user information from User_info table
        $userInfoQuery = "SELECT name, department, email FROM User_info WHERE User_ID = '$studentID'";
        $userInfoResult = mysqli_query($conn, $userInfoQuery);

        // Query to retrieve schedule information from Schedule table
        $scheduleQuery = "SELECT semester, course, type, section FROM Schedule WHERE User_ID = '$studentID'";
        $scheduleResult = mysqli_query($conn, $scheduleQuery);

        // Check if user information and schedule information are retrieved successfully
        if ($userInfoResult && $scheduleResult) {
            // Fetch user information
            $userInfo = mysqli_fetch_assoc($userInfoResult);

            // Display user information
            echo "<h2>Student Info</h2>";
            echo "<div class='profile-info'>";
            echo "<label>Name:</label>";
            echo "<p>" . $userInfo['name'] . "</p>";
            echo "</div>";

            echo "<div class='profile-info'>";
            echo "<label>Department:</label>";
            echo "<p>" . $userInfo['department'] . "</p>";
            echo "</div>";

            echo "<div class='profile-info'>";
            echo "<label>Email:</label>";
            echo "<p>" . $userInfo['email'] . "</p>";
            echo "</div>";

            // Fetch and display schedule information
            while ($schedule = mysqli_fetch_assoc($scheduleResult)) {
                echo "<div class='profile-info'>";
                echo "<label>Semester:</label>";
                echo "<p>" . $schedule['semester'] . "</p>";
                echo "</div>";

                echo "<div class='profile-info'>";
                echo "<label>Course:</label>";
                echo "<p>" . $schedule['course'] . "</p>";
                echo "</div>";

                echo "<div class='profile-info'>";
                echo "<label>Type:</label>";
                echo "<p>" . $schedule['type'] . "</p>";
                echo "</div>";

                echo "<div class='profile-info'>";
                echo "<label>Section:</label>";
                echo "<p>" . $schedule['section'] . "</p>";
                echo "</div>";
            }
        } else {
            // Display an error message if data retrieval fails
            echo "Error: Unable to retrieve data.";
        }
    } else {
        // Display an error message if the Student_ID is not valid
        echo "Error: Invalid Student_ID.";
    }
}
?>