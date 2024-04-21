<?php
require_once('DBconnect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //form data
    $student_id = $_POST['user_id'];
    $course_code = $_POST['courseCode'];
    
    $sql = "INSERT INTO consultation (course_code, faculty_id, student_id) VALUES ('$course_code', '{$_GET['faculty_id']}', '$student_id')";
    
    if ($conn->query($sql) === TRUE) {
        echo "Consultation information saved successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();
}
?>