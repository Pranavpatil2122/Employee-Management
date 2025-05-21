<?php
session_start();
if(isset($_SESSION['uname'])=="") {
  header('location: adminlogin.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Web Design: Index</title>
    <meta charset="UTF-8">
    <meta name="description" content="Web design institute in Kolhapur">
    <meta name="keywords" content="web designing, web hosting">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/custom.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-info">
        <div class="container">
            <a class="navbar-brand"><b><i>Employee Payroll</i></b></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive"
                aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.html">Home</a>
                        <span class="sr-only">(current)</span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about.html">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="adminlogin.php">Admin</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="emplogin.html">Employee</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
        <div class="col-md-6 mx-auto">
            <form name="frmreg" action="" method="post" class="was-validated">
                <div class="form-group">
                    <h1 class="text-center">salary</h1>
                    <label>Employee ID</label><br>
                    <input type="number" class="form-control" name="txtid" placeholder="Enter Employee ID" required><br>
                    <div class="valid-feedback">Valid</div>
                    <div class="invalid-feedback">Please fill out this field</div>
                </div>
                <div class="form-group">
                    <label>Basic salary</label><br>
                    <input type="number" class="form-control" name="txtbasicsal" placeholder="Enter Basic salary"
                        required><br>
                    <div class="valid-feedback">Valid</div>
                    <div class="invalid-feedback">Please fill out this field</div>
                </div>
                <br />
                <br />
                <input type="submit" name="btnsave" value="Save" style="background:#CCFFE5;font-weight:bold;">
                <p><a href="sal.php" class="btn btn-primary">Back</a></p>
            </form>
        </div>
    </div>

    <?php
    include('dbconnect.php');

    if (isset($_POST['btnsave'])) {
        $id = $_POST['txtid'];
        $basicsal = $_POST['txtbasicsal'];

        $res = "INSERT INTO tblsalary (emp_id, basic_salary)
            VALUES ('$id','$basicsal')";

        if ($conn->query($res) === TRUE) {
            echo "<script>alert('You are Registered Successfully');</script>";
        } else {
            echo "<script>alert('Please try again');</script>";
        }
    }
    ?>

    <footer style="margin-top: 70%;">
        <p align="center">Copyright @ 2023 <span style="color:red;"><strong>All rights are reserved.</strong></span></p>
    </footer>
</body>

</html>
