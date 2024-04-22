<?php 
require_once('DBconnect.php');

// Function to sanitize input data
function sanitize($data) {
    global $conn;
    return mysqli_real_escape_string($conn, $data);
}

// Function to insert data into Schedule table
function insertIntoSchedule($course, $section, $courseType) {
    global $conn;
    $sql = "INSERT INTO Schedule (course, section, type)
            VALUES ('$course', '$section', '$courseType')";
    if ($conn->query($sql) === TRUE) {
        echo "";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Retrieve user information
$userID = $_GET['UserID'];
$sqlUserInfo = "SELECT * FROM User_info WHERE User_ID = $userID";
$resultUserInfo = $conn->query($sqlUserInfo);
$userInfo = $resultUserInfo->fetch_assoc();

// Save data into Schedule table when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $course = sanitize($_POST["course"]);
    $section = sanitize($_POST["section"]);
    $courseType = sanitize($_POST["CourseType"]);
    

    insertIntoSchedule($course, $section, $courseType);
}
?>

