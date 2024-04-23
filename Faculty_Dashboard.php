<?php
session_start();
require_once('DBconnect.php');
// Check if user_id is set in the session and assign it to a variable
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Prepare the SQL query using a safe method to prevent SQL injection
    // This assumes both tables `user_info` and `faculty` share the `user_id` as a common key
    $stmt = $conn->prepare("SELECT ui.user_id, ui.name, f.initial 
                            FROM user_info ui 
                            LEFT JOIN faculty f ON ui.user_id = f.user_id 
                            WHERE ui.user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo "Welcome, " . $row['name'] . "<br>";
        echo "UserID: " . $row['user_id'] . "<br>";
        echo "Initial: " . $row['initial'];  // Display the initial from faculty table
    } else {
        echo "No faculty information found.";
    }

    $stmt->close();
} else {
    echo "User ID not set in session.";
    exit();
}



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
            $stmt->bind_param("ssss", $studentUserId, $assignedCourse, $assignedSection, $facultyName);
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
        body { padding-top: 20px; background-color: #black; }
        .dashboard { margin: auto; padding: 20px; max-width: 1000px; background-color: white; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .hidden { display: none; }
		.btn-danger {
			margin-top: 20px;
			float: right; /* Positions the logout button to the right */
		}

    </style>
</head>
<body>
    <div class="dashboard">
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
						<option value="">Select a section</option>
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3">3</option>
						<option value="4">4</option>
						<option value="4">5</option>
						<option value="4">6</option>
						<option value="4">7</option>
						<option value="4">8</option>
						<option value="4">9</option>
						<option value="4">10</option>
					</select>
                </div>
				<div class="form-group">
					<label for="assignedCourse">Assigned Course:</label>
					<select id="assignedCourse" name="assignedCourse" class="form-control mb-2" required>
						<option value="">Select a Course</option>
						<option value="CSE110">CSE110</option>
						<option value="CSE320">CSE111</option>
						<option value="CSE320">CSE220</option>
						<option value="CSE220">CSE221</option>
						<option value="CSE221">CSE221</option>
						<option value="CSE320">CSE250</option>
						<option value="CSE320">CSE251</option>
						<option value="CSE320">CSE250</option>
						<option value="CSE320">PHY111</option>
						<option value="CSE320">PHY112</option>
						<option value="CSE320">CSE330</option>
						<option value="CSE320">CSE331</option>
						<option value="CSE320">CSE341</option>
						<option value="CSE320">CSE350</option>
						<option value="CSE320">CSE360</option>
						<option value="CSE320">CSE370</option>
						<option value="CSE320">CSE420</option>
						<option value="CSE320">CSE422</option>
						<option value="CSE320">CSE423</option>
						<option value="CSE320">EEE101</option>
						<option value="CSE320">EEE201</option>
						<option value="CSE320">EEE203</option>
						<option value="CSE320">EEE205</option>
						<option value="CSE320">EEE221</option>
						
					</select>
				</div>

            </form>
        </div>
		



	<button onclick="location.href='consultation.php';">Go to Consultation Page</button>
	<form action="login.html" method="post">
		<button type="submit" class="btn btn-danger">Logout</button>
	</form>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
function toggleView() {
    var selector = document.getElementById('viewSelector');
    var value = selector.value;

    // This will redirect to the selected page
    window.location.href = "StudentTutor.php" ;
}
</script>


		
</body>
</html>
