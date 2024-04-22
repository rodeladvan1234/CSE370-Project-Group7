
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultation Information</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0; 
            margin: 0;
            padding: 0;
        }
        
        main {
            padding: 20px;
        }
        
        a {
            text-decoration: none;
            color: #007bff; 
            margin-bottom: 10px;
            display: inline-block;
        }
        
        a:hover {
            text-decoration: underline;
        }
        
        .Consulting_Dashboard {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        
        h1 {
            color: #007bff; 
        }
        
        p {
            color: #007bdd; 
        }
        
        hr {
            border: none;
            border-top: 1px solid #ccc; 
            margin-top: 10px;
            margin-bottom: 20px;
        }
        
        .Previous a {
            color: #007bff;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        
        th {
            background-color: #007bff;
            color: white;
        }
        
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
<main>
    <a href="consultation.html">Back to Consultation Dashboard</a>
    <section class="Consulting Dashboard">
        <div class="Consulting_Dashboard">
            <form action="action_page.php" style="border:1px solid #ccc">
                <div class="container">
                    <h1>Consultation Information</h1>
                    <p>Manage all your consultation here</p>
                    <hr>

                    <div class="Previous Consultations">
                        <a href="ongoingConso.html">Ongoing Consultations</a>
                        <br><br>
                        <br>
                        <table>
                            <tr>
                                <th>Consultation ID</th>
                                <th>Faculty Name</th>
                                <th>Student Name</th>
                                <th>Review</th>
                            </tr>
                            <?php
                            include 'previous.php';
                            ?>

                        </table>
                    </div>
                </div>
            </form>
        </div>
    </section>
</main>
</body>
</html>
