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
    
    <style>
        body {
            background-image: url('images/office1.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }

        .form-container {
            background-color: rgba(245, 245, 245, 0.9); /* whitesmoke with transparency */
            padding: 30px;
            border-radius: 10px;
            margin-top: 50px;
            box-shadow: 0 0 15px rgba(0,0,0,0.2);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        footer {
            margin-top: 50px;
            color: white;
        }
    </style>
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
                <li class="nav-item active">
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
    <div class="col-md-6 mx-auto form-container">
        <form name="frmreg" action="" method="post" class="was-validated">
            <h1>Registration</h1>
            <div class="form-group">
                <label>First Name</label>
                <input type="text" class="form-control" name="txtfname" placeholder="Enter First Name" required>
                <div class="valid-feedback">Valid</div>
                <div class="invalid-feedback">Please fill out this field</div>
            </div>
            <div class="form-group">
                <label>Last Name</label>
                <input type="text" class="form-control" name="txtlname" placeholder="Enter Last Name" required>
                <div class="valid-feedback">Valid</div>
                <div class="invalid-feedback">Please fill out this field</div>
            </div>
            <div class="form-group">
                <label>Contact No</label>
                <input type="text" class="form-control" name="txtphone" placeholder="Enter Contact No" maxlength="10" autocomplete="off" required>
                <div class="valid-feedback">Valid</div>
                <div class="invalid-feedback">Please fill out this field</div>
            </div>
            <div class="form-group">
                <label>Address</label>
                <input type="text" class="form-control" name="txtcity" placeholder="Enter Address" required>
                <div class="valid-feedback">Valid</div>
                <div class="invalid-feedback">Please fill out this field</div>
            </div>
            <div class="form-group">
                <label>Department</label>
                <input type="text" class="form-control" name="txtdept" placeholder="Enter Department Name" required>
                <div class="valid-feedback">Valid</div>
                <div class="invalid-feedback">Please fill out this field</div>
            </div>
            <div class="form-group">
                <label>Email ID</label>
                <input type="email" class="form-control" name="txtemail" placeholder="Enter Email" required>
                <div class="valid-feedback">Valid</div>
                <div class="invalid-feedback">Please fill out this field</div>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" class="form-control" name="txtpass" placeholder="Enter Password" required>
                <div class="valid-feedback">Valid</div>
                <div class="invalid-feedback">Please fill out this field</div>
            </div>
            <input type="submit" name="btnsave" value="Save" class="btn btn-primary">
            <a href="index1.php" class="btn btn-secondary ml-2">Cancel</a>
        </form>
    </div>
</div>

<?php
include('dbconnect.php');

if(isset($_POST['btnsave'])) {
    $fname = $_POST['txtfname'];
    $lname = $_POST['txtlname'];
    $phoneno = $_POST['txtphone'];
    $pcity = $_POST['txtcity'];
    $dept = $_POST['txtdept'];
    $emailid = $_POST['txtemail'];
    $password = $_POST['txtpass'];

    $res = "INSERT INTO tblemp (first_name, last_name, contact_no, emp_address, department, emp_email, emp_password)
            VALUES ('$fname', '$lname', '$phoneno', '$pcity', '$dept', '$emailid', '$password')";

    if($conn->query($res) === TRUE) {
        echo "<script>alert('You are Registered Successfully');</script>";
    } else {
        echo "<script>alert('Please try again');</script>";
    }
}
?>

<footer class="text-center text-light mt-5">
    <p>&copy; 2023 <span style="color:red;"><strong>All rights are reserved.</strong></span></p>
</footer>
</body>
</html>
