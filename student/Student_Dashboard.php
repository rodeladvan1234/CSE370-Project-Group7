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

$sql_student_info = "SELECT name, email, department FROM user_info WHERE user_id = '$user_id'";
$result_student_info = mysqli_query($conn, $sql_student_info);

if (mysqli_num_rows($result_student_info) > 0) {
    $row = mysqli_fetch_assoc($result_student_info);
    $name = $row['name'];
    $email = $row['email'];
    $department = $row['department'];
} else {
    echo "No student information found.";
    exit();
}

// Fetch schedule information from the schedule table
$sql_schedule_info = "SELECT course, section, type FROM schedule WHERE user_id = '$user_id'";
$result_schedule_info = mysqli_query($conn, $sql_schedule_info);
$schedule_info = [];

if (mysqli_num_rows($result_schedule_info) > 0) {
    while ($row = mysqli_fetch_assoc($result_schedule_info)) {
        $schedule_info[] = $row;
    }
} else {
    echo "No schedule information found.";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['student_id'])) {
        // Get the student ID from the form
        $studentID = $_POST['student_id'];

        // Insert student ID into the Student table
        $sql_insert_student = "INSERT INTO Student (User_ID, Student_ID) VALUES ('$user_id', '$studentID')";
        if (mysqli_query($conn, $sql_insert_student)) {
            // Redirect to the same page after successful insertion
            header("Location: Student_Dashboard.php");
            exit();
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "Student ID not provided.";
    }
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

        .student-info, .schedule-info {
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
		.Con {
            background-color: #800080;
            color: #fff;
            border: none;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome to Student Dashboard</h1>

        <div class="student-info">
            <h2>Student Information</h2>
            <ul>
                <li><strong>Student ID:</strong> <?php echo isset($studentID) ? $studentID : "N/A"; ?></li>
                <li><strong>Name:</strong> <?php echo $name; ?></li>
                <li><strong>Email:</strong> <?php echo $email; ?></li>
                <li><strong>Department:</strong> <?php echo $department; ?></li>
            </ul>
        </div>

        <div class="schedule-info">
            <h2>Schedule Information</h2>
            <table>
                <tr>
                    <th>Course</th>
                    <th>Section</th>
                    <th>Type</th>
                </tr>
                <?php foreach ($schedule_info as $course_info): ?>
                    <tr>
                        <td><?php echo $course_info['course']; ?></td>
                        <td><?php echo $course_info['section']; ?></td>
                        <td><?php echo $course_info['type']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
		    <ul>
			   <a href="previous.html" class="Con">Previous Consultaion</a>
			   <a href="login.html" class="Con">Log Out</a>
		    </ul>

        <!-- Form to submit student ID -->
        <form method="post">
            <input type="text" name="student_id" placeholder="Enter Student ID" required>
            <button type="submit">Submit</button>
        </form>
    </div>
</body>
</html>
