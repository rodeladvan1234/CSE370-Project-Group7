<?php
header('Content-Type: application/json');
require_once('DBconnect.php');

// Assuming user_info table holds all user data
$sql = "SELECT * FROM user_info WHERE user_id LIKE '20%'";
$result = $conn->query($sql);

$students = [];
if ($result) {
    while($row = $result->fetch_assoc()) {
        $students[] = $row;
    }
    echo json_encode($students);
} else {
    echo json_encode(['error' => $conn->error]);
}

$conn->close();
?>
