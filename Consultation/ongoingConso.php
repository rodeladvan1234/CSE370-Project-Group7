<?php
require_once('DBconnect.php');

session_start();
if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
    echo "User ID: $user_id";

} else {
    echo "User ID not set in session.";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //form data
    $student_id = $_POST['user_id'];
    $course_code = $_POST['courseCode'];
    
    $sql = "INSERT INTO consultation (course_code, faculty_id, student_id) VALUES ('$course_code', '$user_id', '$student_id')";
    
    if ($conn->query($sql) === TRUE) {
        echo "Consultation information saved successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();
}
?>