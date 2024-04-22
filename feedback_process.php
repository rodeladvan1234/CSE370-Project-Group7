<?php
    session_start();
    require_once("DBconnect.php");
    $type = $_POST['feedback_type'];
    $initial = $_POST['initial'];
    $semester = $_POST["semester_name"];
    $course = $_POST["course_name"];
    $rating = $_POST["rating"];
    $comment = $_POST["comment"];
    $user_id=$_SESSION['user_id'];
    //$sql2="SELECT `student`.`student_id` FROM `student` WHERE `student`.`user_id` = $user_id";
    //$result2 = mysqli_query($conn, $sql2);
    //$row = mysqli_fetch_assoc($result2);
    //$student_id = $row['student_id'];

    $sql = "INSERT INTO `feedback` (`user_id`, `initial`, `semester`, `course_name`, `rating`, `comment`) VALUES ('$user_id', '$initial', '$semester', '$course', '$rating', '$comment')";
    $result = mysqli_query($conn, $sql);

    if($result) {
        echo "<script>alert('Feedback submitted successfully.');</script>";
        echo "<script>window.location.href = 'review_dashboard.php';</script>";
        exit(); // Exit to prevent further execution
        // echo "Feedback submitted successfully.";
    } else {
        echo "Error: " . mysqli_error($conn);
    }

?>
