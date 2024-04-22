<?php 
require_once('DBconnect.php');

// Function to sanitize input data
function sanitize($data) {
    global $conn;
    return mysqli_real_escape_string($conn, $data);
}

// Function to retrieve user information for the student tutor
function getStudentTutorInfo($userID) {
    global $conn;
    $userInfo = array();

    // Retrieve user information from User_info table
    $sqlUserInfo = "SELECT * FROM User_info WHERE User_ID = $userID";
    $resultUserInfo = $conn->query($sqlUserInfo);
    if ($resultUserInfo->num_rows > 0) {
        $userInfo = $resultUserInfo->fetch_assoc();

        // Retrieve additional information from Student_tutor table
        $sqlStudentTutor = "SELECT * FROM Student_tutor WHERE User_ID = $userID";
        $resultStudentTutor = $conn->query($sqlStudentTutor);
        if ($resultStudentTutor->num_rows > 0) {
            $studentTutorInfo = $resultStudentTutor->fetch_assoc();

            // Merge the additional information into the user info array
            $userInfo = array_merge($userInfo, $studentTutorInfo);
        }
    }

    return $userInfo;
}

// assuming it's stored in $userID
$userID = $_GET['UserID'];

// Retrieve user information for the student tutor
$userInfo = getStudentTutorInfo($userID);
?>
 