<?php
require_once('DBconnect.php');

// Fetch all faculty information
$sql = "SELECT initial, availability FROM faculty";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty Profiles</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            padding-top: 20px;
            background-color: #f8f9fa;
        }
        .profile {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin: 20px auto;
            max-width: 600px;
        }
        .profile h2 {
            margin-top: 0;
        }
        .profile-info label {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <header class="text-center bg-primary text-white p-4">
        <h1>Faculty Profiles</h1>
    </header>
    <main class="container">
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<div class='profile'>";
                echo "<h2>" . $row["name"] . "</h2>";
                echo "<p><strong>Availability:</strong> " . ($row["availability"] ? $row["availability"] : "Not Available") . "</p>";
                echo "</div>";
            }
        } else {
            echo "<p>No faculty found.</p>";
        }
        ?>
    </main>
</body>
</html>
<?php
$conn->close();
?>
