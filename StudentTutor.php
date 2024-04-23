<?php
session_start();

require_once('DBconnect.php');

// Redirect if not logged in
if (!isset($_SESSION['user'])) {
    header("Location: FacultyDashboard.php");
    exit();
}

// Query to fetch all details for student tutors
$stQuery = "SELECT st.user_id, s.student_id, ui.name as student_name, st.assigned_course, st.assigned_section, f.name as faculty_name
            FROM student_tutor st
            JOIN student s ON st.user_id = s.user_id
            JOIN user_info ui ON st.user_id = ui.user_id
            JOIN user_info f ON st.assigned_under = f.user_id";
$stResult = mysqli_query($conn, $stQuery);
if (!$stResult) {
    die('SQL Error: ' . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Tutor List</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body { padding-top: 20px; background-color: #f8f9fa; }
        .dashboard { margin: auto; padding: 20px; max-width: 1000px; background-color: white; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
    </style>
</head>
<body>
    <div class="container dashboard">
        <h1>Student Tutor List</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Student ID</th>
                    <th>Name</th>
                    <th>Assigned Course</th>
                    <th>Assigned Section</th>
                    <th>Assigned Under</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (mysqli_num_rows($stResult) > 0) {
                    while ($row = mysqli_fetch_assoc($stResult)) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['user_id']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['student_id']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['student_name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['assigned_course']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['assigned_section']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['faculty_name']) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No student tutors found</td></tr>";
                }
                ?>
            </tbody>
        </table>
		<button onclick="window.location.href='FacultyDashboard.php';" class="btn btn-primary">Return to Dashboard</button>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
