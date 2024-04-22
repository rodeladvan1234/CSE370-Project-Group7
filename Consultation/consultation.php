<?php
require_once('DBconnect.php');

session_start();
if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
    echo "User ID: $user_id";
    $reviews = fetchReviews($user_id, $conn);
    $totalHours = fetchTotalHours($user_id, $conn);
} else {
    echo "User ID not set in session.";
}


function fetchReviews($user_id, $conn) {
    $sql = "SELECT ROUND(AVG(rating), 2) AS myReviews FROM feedback WHERE user_id = '$user_id'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row['myReviews'];
    } else {
        return "No reviews available.";
    }

}function fetchTotalHours($user_id, $conn) { //repurposed to total student consulted instead of total hours 
    $sql = "SELECT COUNT(*) AS total_rows FROM consultation WHERE faculty_id = '$user_id'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row['totalHours'];
    } else {
        return "No consultation hours available.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <link rel="shortcut icon" type="image/png" href="images/favicon.png">
    <title>Consulting Dashboard</title>
    <style>
        body {
            background-color: #e0f7fa; 
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #007bff; 
            color: white;
            padding: 10px 20px;
        }

        .nav_logo h1 {
            margin: 0;
        }

        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .nav_link {
            list-style-type: none;
            margin: 0;
            padding: 0;
            display: flex;
        }

        .nav_link li {
            margin-right: 20px;
        }

        .Consulting_Dashboard {
            background-color: white;
            padding: 20px;
            margin: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .Previous {
            margin-bottom: 20px;
        }

        .reviews {
            background-color: #f0f0f0; 
            padding: 10px;
            border-radius: 5px;
        }

        .btn-danger {
            background-color: #f44336;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn-danger:hover {
            background-color: #d32f2f;
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <div class="nav_logo">
                <h1><a href="Faculty.html">Interactive Consultation System | ICS </a></h1>
            </div>
        </nav>
        <ul class="nav_link">
            <!-- Adjusted navigation links based on user type -->
            <li><a href="Student_Dashboard.html">Student Dashboard</a></li>
            <!-- Teacher dashboard link included if user ID starts with 1 or 3 -->
            <?php if (substr($_GET['UserID'], 0, 1) == '1' || substr($_GET['UserID'], 0, 1) == '3'): ?>
                <li><a href="#">Teacher Dashboard</a></li>
            <?php endif; ?>
        </ul>
        
<div id='logout'>
    <form action="logout.php" method="post">
        <button type="submit" class="btn-danger" name="logout">Logout</button>
    </form>
</div>

    </header>
    <main>
        <section class="Consulting Dashboard">
            <div class="Consulting_Dashboard">
                <form action="action_page.php" style="border:1px solid #ccc">
                    <div class="container">
                        <h1>Consultation Information</h1>
                        <p>Manage all your consultation here</p>
                        <hr><br>

                        <div class="Previous Consultations">
                            <a href="previous.html">Previous Consultations</a><br>
                            <a href="ongoingConso.html">Ongoing Consultations</a>
                            <br><br>

                            <p>My reviews: <?php echo $reviews; ?></p><br>

                            <p>Total Consulted Hours: <?php echo $totalHours; ?></p><br>

                        </div>
                    </div>
                </form>
            </div>
        </section>
    </main>
</body>
</html>