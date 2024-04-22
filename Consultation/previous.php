<?php
session_start();
require_once('DBconnect.php');
$user_id=$_SESSION['user_id'];
//Consultation table
$sql = "SELECT c_id, consultant, user_id FROM consultation where user_id=$user_id ";
$result = $conn->query($sql);
$user_id=$_SESSION['user_id'];
$sql2= "SELECT user_info.name FROM user_info where user_id=$user_id";
$result2 = $conn->query($sql2);
$row = $result2->fetch_assoc();
$name = $row['name'];
echo $name;

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["c_id"] . "</td>";
        echo "<td>" . $row["consultant"] . "</td>";
        echo "<td>" . $name . "</td>";
        
        // students review button only
        if ($_SESSION['user_id'][0] == '2') {
            echo "<td><a href='feedback_student.php?c_id=" . $row["c_id"] . "&student_id=" . $_SESSION['user_id'] . "'>Review</a></td>";
        } else {
            echo "<td>Not available</td>";
        }
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='4'>No consultations found</td></tr>";
}
$conn->close();
?>