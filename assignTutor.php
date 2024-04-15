<?php
require_once('DBconnect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['studentIds'])) {
    $studentIds = json_decode($_POST['studentIds']);

    foreach ($studentIds as $oldUserId) {
        // Compute new user ID (from student to tutor)
        $newUserId = '30' . substr($oldUserId, 2);

        // Update user_id in user_info table
        $updateSql = "UPDATE user_info SET user_id = ? WHERE user_id = ?";
        $stmt = $conn->prepare($updateSql);
        $stmt->bind_param("ss", $newUserId, $oldUserId);
        $stmt->execute();

        // Insert new tutor entry in student_tutor table
        $insertSql = "INSERT INTO student_tutor (user_id) VALUES (?)";
        $insertStmt = $conn->prepare($insertSql);
        $insertStmt->bind_param("s", $newUserId);
        $insertStmt->execute();
    }

    echo "Students successfully assigned as tutors.";
} else {
    echo "No students selected or wrong method.";
}

$conn->close();
?>
