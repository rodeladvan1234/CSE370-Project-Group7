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
//echo $name;

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $consultant=$row["consultant"];
        echo "<tr>";
        echo "<td>" . $row["c_id"] . "</td>";
        echo "<td>" . $consultant . "</td>";
        echo "<td>" . $name . "</td>";
        
        // students review button only
        if ($_SESSION['user_id'][0] == '2') {
            $sql2 = "SELECT `feedback`.`user_id` FROM `feedback` WHERE `feedback`.`user_id` = ? AND `feedback`.`initial` = ?";
            $stmt2 = $conn->prepare($sql2);
            $stmt2->bind_param("is", $user_id, $consultant);
            $user_id = $_SESSION['user_id'];
            $consultant = $consultant; 
            $stmt2->execute();
            $result2 = $stmt2->get_result();
        
            if ($result2->num_rows > 0) {
                $sql4 = "SELECT ROUND(AVG(rating), 1) AS avg_rating FROM feedback WHERE `initial` = ?";
                $stmt4 = $conn->prepare($sql4);
                $stmt4->bind_param("s", $consultant);
                $stmt4->execute();
                $result4 = $stmt4->get_result();
                $row2 = $result4->fetch_assoc();
                echo "<td>" . $row2["avg_rating"] . "</td>";
            } else {
                echo "<td><a href='feedback_student.php?c_id=" . $row["c_id"] . "&student_id=" . $_SESSION['user_id'] . "'>Review</a></td>";
            }
        // if ($_SESSION['user_id'][0] == '2') {
        //     $sql2="SELECT `feedback`.`user_id` FROM `feedback` WHERE `feedback`.`user_id` = $user_id AND `feedback`.`initial`='$consultant'";
        //     $result2 = $conn->query($sql2);
        //     if ($result2->num_rows > 0){
        //         $sql4="SELECT  AVG(rating) AS avg_rating FROM feedback GROUP BY consultant where `feedback`.`initial`='$consultant'";
        //         $result3 = $conn->query($sql4);
        //         $row2 = $result3->fetch_assoc();
        //         echo "<td>" . $row2["avg_rating"] . "</td>";
                

                
        //     }
        //     else{
        //         echo "<td><a href='feedback_student.php?c_id=" . $row["c_id"] . "&student_id=" . $_SESSION['user_id'] . "'>Review</a></td>";

        //     }
            
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