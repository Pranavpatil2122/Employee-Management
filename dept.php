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
    h2{
      margin-top:30px ;
    }
    form {
      border: 1px solid black; 
      background-color:#d0f9ff;
      border-radius:20px;
      margin-top:40px;
      padding: 20px; 
      backdrop-filter:blur(10px);
      
    }
    body{
   background-image:url(images/office1.jpg);
   background-size: cover;
   background-repeat: no-repeat;
}
  
  </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-info">
        <div class="container">
            <a class="navbar-brand"><b><i>Employee Payroll</i></b></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
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
<div class="col-md-6 mx-auto">
    <form name="frmreg" action="" method="post" class="was-validated">
        <div class="form-group">
        <h1 class="text-center">New Department</h1>
        <label>Department Name</label><br>
        <input type="text" class="form-control" name="txtdname" placeholder="Enter Department Name" required>
        <div class="valid-feedback">Valid</div>
          <div class="invalid-feedback">Please fill out this field</div>
</div>
<div class="form-group">
        <label>Department Location </label><br>
        <input type="text" class="form-control" name="txtloc" placeholder="Enter Department Location" required>
        <div class="valid-feedback">Valid</div>
          <div class="invalid-feedback">Please fill out this field</div>
</div>
        <input type="submit" class="btn btn-outline-primary" name="btnsave" value="Save" style="font-weight:bold;">
        <p><a href="admin.php" class="btn btn-primary" style="margin-top: 10px;">Back</a></p>
    </form>
</div>
</div>
</div>
    <?php
include('dbconnect.php');

if(isset($_POST['btnsave'])) {
    $dname = $_POST['txtdname'];
    $loc = $_POST['txtloc'];
    
    $res = "INSERT INTO dept (department, dept_location)
            VALUES ('$dname', '$loc')";

    if($conn->query($res) === TRUE) {
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

