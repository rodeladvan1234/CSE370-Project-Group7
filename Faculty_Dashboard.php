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

$sql_faculty_info = "SELECT user_id,name  FROM user_info WHERE user_id = '$user_id'";
$result_faculty_info = mysqli_query($conn, $sql_faculty_info);

if (mysqli_num_rows($result_faculty_info) > 0) {
    $row = mysqli_fetch_assoc($result_faculty_info);
    $name = $row['name'];
} else {
    echo "No faculty information found.";
    exit();
}


// Fetch user details from session
$user = $_SESSION['user'];
$facultyUserId = $user['user_id'];
$facultyName = $user['name'];

// Handle POST request for assigning students as tutors
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['assignButton'])) {
    $selectedStudents = $_POST['selectedStudents'];
    $assignedSection = mysqli_real_escape_string($conn, $_POST['assignedSection']);
    $assignedCourse = mysqli_real_escape_string($conn, $_POST['assignedCourse']);

    $stmt = $conn->prepare("INSERT INTO student_tutor (user_id, assigned_course, assigned_section, assigned_under) VALUES (?, ?, ?, ?)");

    foreach ($selectedStudents as $studentUserId) {
        $studentQuery = "SELECT student_id FROM student WHERE user_id = ?";
        $studentStmt = $conn->prepare($studentQuery);
        $studentStmt->bind_param("s", $studentUserId);
        $studentStmt->execute();
        $result = $studentStmt->get_result();
        if ($studentData = $result->fetch_assoc()) {
            $studentId = $studentData['student_id'];
            $stmt->bind_param("sssss", $studentUserId, $assignedCourse, $assignedSection, $facultyName);
            $stmt->execute();
        }
        $studentStmt->close();
    }
    $stmt->close();
}

// Query to fetch students whose user_id starts with "2"
$studentQuery = "SELECT ui.user_id, ui.name, ui.email, ui.department, s.student_id
                 FROM user_info ui
                 LEFT JOIN student s ON ui.user_id = s.user_id
                 WHERE ui.user_id LIKE '2%'";
$studentsResult = mysqli_query($conn, $studentQuery);
// Query to fetch data for the Student Tutor List
$stQuery = "SELECT st.user_id, s.student_id, st.assigned_course, st.assigned_section, st.assigned_under
            FROM student_tutor st
            JOIN student s ON st.user_id = s.user_id";
$stResult = mysqli_query($conn, $stQuery);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body { padding-top: 20px; background-color: #f8f9fa; }
        .dashboard { margin: auto; padding: 20px; max-width: 1000px; background-color: white; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .hidden { display: none; }
		.btn-danger {
			margin-top: 20px;
			float: right; /* Positions the logout button to the right */
		}

    </style>
</head>
<body>
    <div class="container dashboard">
        <h1>Faculty Dashboard</h1>
        <!--<p>Welcome <strong><?php echo htmlspecialchars($facultyName); ?> (User ID: <?php echo htmlspecialchars($facultyUserId); ?>)</strong></p>-->


			<!-- Rest of your dashboard HTML -->
		<select id="viewSelector" class="form-control mb-4" onchange="toggleView()">
			<option value="StudentList">Student List</option>
			<option value="StudentTutor.php">Student Tutor List</option>
		</select>

        <!-- Student List View -->
        <div id="studentListView">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <h2>Student List</h2>
                <button type="submit" name="assignButton" id="assignButton" class="btn btn-primary mb-2">Assign as Tutor</button>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Select</th>
                            <th>UserID</th>
                            <th>Student ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Dept</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (mysqli_num_rows($studentsResult) > 0) {
                            while ($student = mysqli_fetch_assoc($studentsResult)) {
                                echo "<tr>";
                                echo "<td><input type='checkbox' name='selectedStudents[]' value='" . htmlspecialchars($student['user_id']) . "'></td>";
                                echo "<td>" . htmlspecialchars($student['user_id']) . "</td>";
                                echo "<td>" . htmlspecialchars($student['student_id']) . "</td>";
                                echo "<td>" . htmlspecialchars($student['name']) . "</td>";
                                echo "<td>" . htmlspecialchars($student['email']) . "</td>";
                                echo "<td>" . htmlspecialchars($student['department']) . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6'>No students found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
                <div class="form-group">
                    <label for="assignedSection">Assigned Section:</label>
					<select id="assignedSection" name="assignedSection" class="form-control mb-2" required>
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3">3</option>
						<option value="4">4</option>
					</select>
                </div>
				<div class="form-group">
					<label for="assignedCourse">Assigned Course:</label>
					<select id="assignedCourse" name="assignedCourse" class="form-control mb-2" required>
						<option value="CSE110">CSE110</option>
						<option value="CSE220">CSE220</option>
						<option value="CSE221">CSE221</option>
						<option value="CSE320">CSE320</option>
					</select>
				</div>

            </form>
        </div
		

        <!-- Student Tutor List View (initially hidden) -->
<!-- Student Tutor List View -->
		<div id="stListView" class="hidden">
			<h2>Student Tutor List</h2>
			<table class="table">
				<thead>
					<tr>
						<th>UserID</th>
						<th>Student ID</th>
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
							echo "<td>" . htmlspecialchars($row['assigned_course']) . "</td>";
							echo "<td>" . htmlspecialchars($row['assigned_section']) . "</td>";
							echo "<td>" . htmlspecialchars($row['assigned_under']) . "</td>";
							echo "</tr>";
						}
					} else {
						echo "<tr><td colspan='5'>No student tutors found</td></tr>";
					}
					?>
				</tbody>
			</table>
		</div>

		<script>
			function toggleView() {
				var selector = document.getElementById('viewSelector');
				var value = selector.value;

				if (value === 'StudentList') {
					// Assuming the student list is on the same page or you can specify the exact path if it's a separate page
					window.location.href = 'FacultyDashboard.php'; 
				} else if (value === 'StudentTutor.php') {
					window.location.href = 'StudentTutor.php';
				}
			}
		</script>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<button onclick="location.href='consultation.html';">Go to Consultation Page</button>
<form action="login.html" method="post">
	<button type="submit" class="btn btn-danger">Logout</button>
</form>
		
</body>
</html>