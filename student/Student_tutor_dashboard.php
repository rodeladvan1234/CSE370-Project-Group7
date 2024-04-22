<?php
session_start();

if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
    echo "User ID: $user_id";
} else {
    echo "User ID not set in session.";
    exit(); // Exit after displaying the error message
}

// Fetch student information from the user_info table
// Replace 'DBconnect.php' with your database connection file
require_once('DBconnect.php');

$sql_student_info = "SELECT assigned_course, assigned_section, assigned_under FROM student_tutor WHERE user_id = '$user_id'";
$result_student_info = mysqli_query($conn, $sql_student_info);

if (mysqli_num_rows($result_student_info) > 0) {
    $row = mysqli_fetch_assoc($result_student_info);
    $course = $row['assigned_course'];
    $section= $row['assigned_section'];
    $under = $row['assigned_under'];
} else {
    echo "No student information found.";
    exit();
}

if (isset($_POST['st_id'])) {
    // Get the st ID from the form
    $studentID = $_POST['st_id'];

    // Insert student ID into the Student tutor table
    $sql_insert_student = "INSERT INTO Student_tutor St_id VALUES '$studentID'";
    if (mysqli_query($conn, $sql_insert_student)) {
        echo "Student tutor ID inserted successfully.";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    echo "Student ID not provided.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        h1, h2 {
            text-align: center;
            color: #333;
        }

        .student-info, .student-tutor-info {
            margin-bottom: 20px;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome to Student Tutor Dashboard</h1>

        <div class="student-info">
            <h2>Student Information</h2>
            <ul>
                <li><strong>Student Tutor ID:</strong> <input type="text" id="student-id" name="student_id" placeholder="Enter your Student ID" required></li>
				<li><strong>Assigned Course:</strong> <?php echo $course; ?></li>
                <li><strong>Assigned section:</strong> <?php echo $section; ?></li>
                <li><strong>Assigned under:</strong> <?php echo $under; ?></li>
            </ul>
        </div>
		 <ul>
			<a href="St_View_Student_Dashboard.php">Student View</a>
			<a href="previous.html">Previous Consultaion</a>
			<a href="login.html">Log Out</a>
		</ul>
    </div>
</body>
</html>
