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

// Query to retrieve user information from User_info table
$userInfoQuery = "SELECT name, department, email FROM User_info WHERE User_ID = '$userID'";
$userInfoResult = mysqli_query($conn, $userInfoQuery);

// Query to retrieve student tutor information from Student_tutor table
$studentTutorQuery = "SELECT assigned_course, assigned_section, assigned_under FROM Student_tutor WHERE User_ID = '$userID'";
$studentTutorResult = mysqli_query($conn, $studentTutorQuery);

// Check if user information and student tutor information are retrieved successfully
if ($userInfoResult && $studentTutorResult) {
    // Fetch user information
    $userInfo = mysqli_fetch_assoc($userInfoResult);

    // Fetch student tutor information
    $studentTutorInfo = mysqli_fetch_assoc($studentTutorResult);

    // Display user information
    echo "<h2>Student Tutor Info</h2>";
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

    // Display student tutor information
    echo "<div class='profile-info'>";
    echo "<label>Assigned Course:</label>";
    echo "<p>" . $studentTutorInfo['assigned_course'] . "</p>";
    echo "</div>";

    echo "<div class='profile-info'>";
    echo "<label>Assigned Section:</label>";
    echo "<p>" . $studentTutorInfo['assigned_section'] . "</p>";
    echo "</div>";

    echo "<div class='profile-info'>";
    echo "<label>Assigned Under:</label>";
    echo "<p>" . $studentTutorInfo['assigned_under'] . "</p>";
    echo "</div>";
} else {
    // Display an error message if data retrieval fails
    echo "Error: Unable to retrieve data.";
}
?>