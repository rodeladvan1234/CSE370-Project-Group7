<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultation Information</title>
    <style>
        body {
            font-family: Arial, sans-serif; /* Change font to Arial */
            background-color: #ffffff; /* Change background color to white */
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
        
        h2 {
            color: #007bff;
            margin-bottom: 10px;
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
            background-color: white; /* Set table background color to white */
        }
        
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            font-family: Arial, sans-serif; /* Change font to Arial */
            font-size: 14px; /* Change font size to 14px */
        }
        
        th {
            background-color: #7DBBFF; /* Change table header background color */
            color: white;
        }
        
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .button-container {
            text-align: center;
            margin-top: 20px;
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            text-decoration: none;
        }

        .button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<main>
    <h2>Consultation Review</h2>
    <table>
        <tr>
            <th>Consultation ID</th>
            <th>Consultant Name</th>
            <th>Student Name</th>
            <th>Review</th>
        </tr>
        <?php
        include 'previous_updated.php';
        ?>

    </table>
    <div class="button-container">
        <a href="Student_Dashboard.html" class="button">Back to Student Dashboard</a>
    </div>
</main>
</body>
</html>
