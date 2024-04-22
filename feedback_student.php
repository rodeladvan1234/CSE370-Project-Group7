<?php
require_once("DBconnect.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Feedback Form</title>
<style>
  body {
    font-family: Arial, sans-serif; /* Arial font */
    padding: 20px;
  }
  form {
    max-width: 600px;
    margin: 0 auto;
    background-color: #7DBBFF; /* Light blue background color */
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
  }
  h2 {
    color: #420303;
    text-align: center;
  }
  label {
    font-weight: bold;
    color: #070707;
    font-family: Arial, sans-serif; /* Arial font */
  }
  input[type="text"],
  textarea,
  select {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
    font-family: Arial, sans-serif; /* Arial font */
    font-size: 14px; /* Font size 14px */
  }
  input[type="radio"] {
    margin-right: 5px;
  }
  input[type="submit"] {
    display: block;
    margin: 0 auto;
    background-color: #069d48;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 14px;
  }
  input[type="submit"]:hover {
    background-color: #a01d65;
  }
</style>
</head>
<body>

<h2>Students Feedback Form</h2>

<form action="feedback_process.php" method="POST">
  <label>Feedback For:</label><br>
  <input type="radio" id="feedback_type_faculty" name="feedback_type" value="faculty" required>
  <label for="feedback_type_faculty">Faculty</label><br>
  <input type="radio" id="feedback_type_student" name="feedback_type" value="student" required>
  <label for="feedback_type_student">Student Tutor</label><br><br>
  
  <label for="initial">Initial:</label><br>
  <select id="initial" name="initial" required>
    <option value="">Select Initial</option>
    <?php
    session_start();
    $user_id=$_SESSION['user_id'];
    // Assuming you have a database connection named $conn
    $sql = "SELECT DISTINCT consultant FROM consultation where user_id=$user_id ";
    $result = mysqli_query($conn, $sql);

    if ($result) {
      while ($row = mysqli_fetch_assoc($result)) {
        echo '<option value="' . $row['consultant'] . '">' . $row['consultant'] . '</option>';
      }
    }
    ?>
  </select><br><br>

  <label for="semester_name">Semester:</label><br>
  <select id="semester_name" name="semester_name" required>
  <option value="Spring">Spring</option>
  <option value="Summer">Summer</option>
  <option value="Fall">Fall</option>
  </select><br><br>
  
  <label for="course_name">Course</label><br>
  <select id="course_name" name="course_name" required>
    <option value="">Select Course</option>
    <?php
    // Assuming you have a database connection named $conn
    $sql = "SELECT DISTINCT course_code FROM consultation where user_id=$user_id";
    $result = mysqli_query($conn, $sql);

    if ($result) {
      while ($row = mysqli_fetch_assoc($result)) {
        echo '<option value="' . $row['course_code'] . '">' . $row['course_code'] . '</option>';
      }
    }
    ?>
  </select><br><br>
  <label>Rating (Worst being 1 , Highest being 5):</label><br>
  <input type="radio" id="rating_1" name="rating" value="1" required>
  <label for="rating_1">1</label><br>
  <input type="radio" id="rating_2" name="rating" value="2" required>
  <label for="rating_2">2</label><br>
  <input type="radio" id="rating_3" name="rating" value="3" required>
  <label for="rating_3">3</label><br>
  <input type="radio" id="rating_4" name="rating" value="4" required>
  <label for="rating_4">4</label><br>
  <input type="radio" id="rating_5" name="rating" value="5" required>
  <label for="rating_5">5</label><br><br>
  
  <label for="comment">Comments:</label><br>
  <textarea id="comment" name="comment" rows="4" cols="50" required></textarea><br><br>
  
  <input type="submit" value="Submit">
</form>

</body>
</html>
