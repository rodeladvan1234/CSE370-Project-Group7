<?php
require_once('DBconnect.php');

//Consultation table
$sql = "SELECT c_id, faculty_id, student_id FROM consultation";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["c_id"] . "</td>";
        echo "<td>" . $row["faculty_name"] . "</td>";
        echo "<td>" . $row["student_name"] . "</td>";
        
        // students review button only
        if ($_SESSION['user_id'][0] == '2') {
            echo "<td><a href='feedback.html?c_id=" . $row["c_id"] . "&student_id=" . $_SESSION['user_id'] . "'>Review</a></td>";
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