<?php
session_start();

// Redirect to login if not logged in
if (!isset($_SESSION['user']) || substr($_SESSION['user']['user_id'], 0, 1) !== '1') {
    header("Location: login.html");
    exit();
}

require_once('DBconnect.php');

// Fetch faculty information
$faculty_id = $_SESSION['user']['user_id'];
$faculty_name = $_SESSION['user']['name'];

// Function to fetch student list
function getStudentList($conn) {
    $sql = "SELECT user_info.user_id, student.student_id, user_info.name, user_info.email, user_info.department
            FROM student
            INNER JOIN user_info ON student.user_id = user_info.user_id";
    $result = mysqli_query($conn, $sql);
    return $result;
}

// Function to fetch student tutor list
function getStudentTutorList($conn) {
    $sql = "SELECT * FROM student_tutor";
    $result = mysqli_query($conn, $sql);
    return $result;
}

// Function to assign student tutor
function assignStudentTutor($conn, $course, $section, $faculty_id) {
    $sql = "INSERT INTO student_tutor (user_id, assigned_course, assigned_section, assigned_under)
            VALUES ('$faculty_id', '$course', '$section', '$faculty_id')";
    $result = mysqli_query($conn, $sql);
    return $result;
}

// Handle form submission for assigning student tutor
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['assign_course'], $_POST['assign_section'])) {
        $course = $_POST['assign_course'];
        $section = $_POST['assign_section'];
        assignStudentTutor($conn, $course, $section, $faculty_id);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            color: #333;
        }
        header {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            text-align: center;
        }
        h1, h2 {
            margin: 10px 0;
        }
        table {
            width: 90%;
            margin: 20px auto;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        form {
            width: 90%;
            margin: 20px auto;
            background: white;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        label {
            margin-bottom: 10px;
            display: block;
            font-weight: bold;
        }
        input[type="text"], select {
            width: 100%;
            padding: 8px;
            margin: 10px 0;
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        button {
            width: 100%;
            background-color: #4CAF50;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        .container {
            width: 80%;
            margin: auto;
            overflow: hidden;
        }
    </style>
</head>
<body>
    <h1>Faculty Dashboard</h1>
    <p>Welcome, <?php echo $faculty_name; ?> (UserID: <?php echo $faculty_id; ?>)</p>

    <form action="FacultyDashboard.php" method="post">
        <label for="select_list">Select List:</label>
        <select name="select_list" id="select_list">
            <option value="student_list">Student List</option>
            <option value="student_tutor_list">Student Tutor List</option>
        </select>
        <button type="submit">Show</button>
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['select_list'])) {
        if ($_POST['select_list'] === "student_list") {
            $studentList = getStudentList($conn);
            // Display student list in table format
            echo "<h2>Student List</h2>";
            echo "<table border='1'>
                    <tr>
                        <th>Select</th>
                        <th>User ID</th>
                        <th>Student ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Dept</th>
                    </tr>";
            while ($row = mysqli_fetch_assoc($studentList)) {
                echo "<tr>
                        <td><input type='checkbox' name='selected_students[]' value='" . $row['user_id'] . "'></td>
                        <td>" . $row['user_id'] . "</td>
                        <td>" . $row['student_id'] . "</td>
                        <td>" . $row['name'] . "</td>
                        <td>" . $row['email'] . "</td>
                        <td>" . $row['department'] . "</td>
                    </tr>";
            }
            echo "</table>";
        } elseif ($_POST['select_list'] === "student_tutor_list") {
            $studentTutorList = getStudentTutorList($conn);
            // Display student tutor list in table format
            echo "<h2>Student Tutor List</h2>";
            echo "<table border='1'>
                    <tr>
                        <th>ID</th>
                        <th>User ID</th>
                        <th>Student ID</th>
                        <th>Assigned Course</th>
                        <th>Assigned Section</th>
                        <th>Assigned Under</th>
                    </tr>";
            while ($row = mysqli_fetch_assoc($studentTutorList)) {
                echo "<tr>
                        <td>" . $row['user_id'] . "</td>
                        <td>" . $row['st_id'] . "</td>
                        <td>" . $row['assigned_course'] . "</td>
                        <td>" . $row['assigned_section'] . "</td>
                        <td>" . $row['assigned_under'] . "</td>
                    </tr>";
            }
            echo "</table>";
        }
    }
    ?>

<h2>Assign Student Tutor</h2>
<form action="FacultyDashboard.php" method="post">
    <label for="assign_course">Assign Course:</label>
    <select name="assign_course" id="assign_course">
        <option value="CSE110">CSE110</option>
        <option value="CSE111">CSE111</option>
        <option value="CSE220">CSE220</option>
    </select>
    
    <label for="assign_section">Assign Section:</label>
    <select name="assign_section" id="assign_section">
        <?php for ($i = 1; $i <= 10; $i++) { ?>
            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
        <?php } ?>
    </select>
    
    <!-- It's important to pass the user ID of the student being assigned as tutor -->
    <!-- Assume we have a way to select the student's user_id -->
    <label for="student_user_id">Student User ID:</label>
    <input type="text" name="student_user_id" id="student_user_id" required>
    
    <button type="submit">Assign</button>
</form>


    <button onclick="location.href='consultation.html';">Go to Consultation Page</button>
    <button onclick="location.href='login.html';">Logout</button>
</body>
</html>

<?php mysqli_close($conn); ?>
