<?php
session_start();
if(isset($_SESSION['uname'])=="") {
  header('location: adminlogin.php');
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Employee Payroll</title>
    <meta charset="utf-8">
    <meta name="description" content="">
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <style>
        body {
            background-image: url('images/emp.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }

        .btn-container {
            background-color: rgba(245, 245, 245, 0.95); /* whitesmoke with slight transparency */
            padding: 30px;
            border-radius: 10px;
            margin-top: 100px;
            box-shadow: 0 0 15px rgba(0,0,0,0.2);
        }

        .btn-container .btn {
            margin-bottom: 20px;
            width: 100%;
        }

        a.btn-link {
            text-decoration: none;
            color: black;
            display: block;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-info">
        <div class="container">
            <a class="navbar-brand"><b><i>Patil Tech Innovations</i></b></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarResponsive" aria-controls="navbarResponsive"
                    aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Button Section -->
    <div class="container">
        <div class="col-md-4 mx-auto btn-container text-center">
            <a href="index1.php" class="btn btn-outline-primary btn-link">Employee Info</a>
            <a href="dept.php" class="btn btn-outline-primary btn-link">Add New Department</a>
            <a href="sal.php" class="btn btn-outline-primary btn-link">Monthly Salary</a>
            <a href="reportmain.php" class="btn btn-outline-primary btn-link">Generate Report</a>
        </div>
    </div>

</body>

</html>
