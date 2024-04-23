<?php
session_start();

require_once('DBconnect.php');

// Query to fetch all details for student tutors
$stQuery = "SELECT user_id, assigned_course, assigned_section, assigned_under FROM consultation_system.student_tutor";
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
                        echo "<td>" . $row['user_id'] . "</td>";
                        echo "<td>" . $row['assigned_course'] . "</td>";
                        echo "<td>" . $row['assigned_section'] . "</td>";
                        echo "<td>" . $row['assigned_under'] . "</td>";
                        echo "</tr>";
                }
                } else {
                    echo "<tr><td colspan='4'>No student tutors found</td></tr>";
                    }
            ?>

        </table>
		<button onclick="window.location.href='Faculty_Dashboard.php';" class="btn btn-primary">Return to Dashboard</button>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
