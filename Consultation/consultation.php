<?php
require_once('DBconnect.php');

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

// userID error checker : cant be empty
if (isset($_GET['UserID']) && !empty($_GET['UserID'])) {
    // user ID from URL (shormi pls help)
    $user_id = $_GET['UserID'];

    $reviews = fetchReviews($user_id, $conn);
    $totalHours = fetchTotalHours($user_id, $conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <link rel="shortcut icon" type="image/png" href="images/favicon.png">
    <title>Consulting Dashboard</title>
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
            <li><a href="#">Student Dashboard</a></li>
            <!-- Teacher dashboard link included if user ID starts with 1 or 3 -->
            <?php if (substr($_GET['UserID'], 0, 1) == '1' || substr($_GET['UserID'], 0, 1) == '3'): ?>
                <li><a href="#">Teacher Dashboard</a></li>
            <?php endif; ?>
        </ul>
        <div id='logout'>
            <button type="button" class="btn-danger">Logout</button>
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
                            <!-- Display fetched reviews here -->

                            <p>Total Consulted Hours: <?php echo $totalHours; ?></p><br>
                            <!-- Display fetched total consultation hours here -->

                        </div>
                    </div>
                </form>
            </div>
        </section>
    </main>
</body>
</html>