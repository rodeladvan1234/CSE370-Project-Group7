<?php
require_once('DBconnect.php');

// SQL query to fetch all student tutors
$sql = "SELECT * FROM user_info WHERE user_id LIKE '30%'"; // Assuming student tutor IDs start with '30'
$result = $conn->query($sql);

$studentTutors = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $studentTutors[] = $row;
    }
}

echo json_encode($studentTutors);
$conn->close();
?>
