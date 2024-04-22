<?php
session_start();
if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
    echo "User ID: $user_id";
} else {
    echo "User ID not set in session.";
}

require_once('DBconnect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if semester data is provided
    if (isset($_POST['semester'])) {
        // Retrieve form data
        $semester = $_POST['semester'];

        // Retrieve courses data
        $courses = $_POST['courses'];

        // Iterate over each course
        foreach ($courses as $course) {
            $course_name = $course['course_name'];
            $section = $course['section'];
            $type = $course['type'];

            // Insert course data into database
            $sql = "INSERT INTO schedule (user_id, semester, course, type, section) VALUES ('$user_id', '$semester', '$course_name', '$type', '$section')";
            if (!mysqli_query($conn, $sql)) {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                exit(); // Stop execution if there's an error
            }
        }

        // Determine user type based on user ID
        $firstChar = substr($user_id, 0, 1);
        if ($firstChar === '1') {
            $dashboard_url = "Faculty_Dashboard.html?user_id=$user_id";
        } elseif ($firstChar === '2') {
            $dashboard_url = "Student_Dashboard.html?user_id=$user_id";
        } elseif ($firstChar === '3') {
            $dashboard_url = "ST_Dashboard.html?user_id=$user_id";
        } else {
            echo "Invalid user ID.";
            exit();
        }

        // Redirect to dashboard after successful schedule creation
        header("Location: $dashboard_url");
        exit();
    } else {
        echo "Semester data is missing.";
        exit();
    }
} else {
    echo "Invalid request method.";
    exit();
}

// Close the database connection
mysqli_close($conn);

?>




