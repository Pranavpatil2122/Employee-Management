<!DOCTYPE html>
<html>

<head>
  <title>Employee payroll</title>
  <meta charset="utf-8">
  <meta name="description" content="">

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

  <style>
    h2 {
      margin-top: 30px;
    }

    form {
      border: 1px solid #ccc;
      border-radius: 20px;
      margin-top: 40px;
      padding: 20px;
      backdrop-filter: blur(10px);
    }

    body {
      background-image: url(images/emp.jpg);
      background-size: cover;
      background-repeat: no-repeat;
    }
  </style>
</head>

<body>
  <nav>
    <nav class="navbar navbar-expand-lg navbar-light bg-info">
      <div class="container">
        <a class="navbar-brand"><b><i>Patil Tech Innovations</i></b></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive"
          aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item ">
              <a class="nav-link" href="index.html">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="about.html">About</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="adminlogin.php">Admin</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" href="emplogin.php">Employee</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </nav>

  <div class="container">
    <div class="col-md-6 mx-auto">
      <h2 class="text-center">Employee Login</h2>
      <form name="frmreg" action="#" method="POST" class="was-validated">
        <div class="form-group">
          <label for="userid">Employee ID:</label>
          <input type="number" class="form-control" placeholder="Enter your id:" name="txtid" required min="1">
          <div class="valid-feedback">Valid</div>
          <div class="invalid-feedback">Please fill out this field</div>
        </div>
        <div class="form-group">
          <label for="username">Email:</label>
          <input type="email" class="form-control" placeholder="Enter your Email:" name="txtuname" required pattern=".+@gmail\.com">
          <div class="valid-feedback">Valid</div>
          <div class="invalid-feedback">Please enter a valid Gmail address</div>
        </div>
        <div class="form-group">
          <label for="password">Password:</label>
          <input type="password" class="form-control" placeholder="Enter your password:" name="txtpassw" required>
          <div class="valid-feedback">Valid</div>
          <div class="invalid-feedback">Please fill out this field</div>
        </div>
        <input type="submit" name="btnlogin" class="btn btn-primary" value="Login">

      </form>
    </div>
    
  </div>
  


  <?php
  session_start();
  include('dbconnect.php');

  if (isset($_POST['btnlogin'])) {
    // Get the form input values
    $emp_id = $_POST['txtid'];
    $_SESSION['emp_id'] = $emp_id;
    $uname = $_POST['txtuname'];
    $passw = $_POST['txtpassw']; 

    // Additional validation on the backend for email and ID
    if ($emp_id <= 0) {
      echo "<h3><center> Employee ID should be a positive number </center></h3>";
    } else if (strpos($uname, '@gmail.com') === false) {
      echo "<h3><center> Email must end with @gmail.com </center></h3>";
    } else {
      // Query database to check credentials
      $sql = "SELECT emp_id, emp_email, emp_password FROM tblemp WHERE emp_id='$emp_id' AND emp_email='$uname' AND emp_password='$passw'";
      $result = mysqli_query($conn, $sql);
      $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

      $count = mysqli_num_rows($result);

      if ($count == 1) {
        echo "<h3><center> Login successful </center></h3>";
        $_SESSION['uname'] = $uname;
        header("location: empd.php");
      } else {
        echo "<h3><center> Login failed. Invalid username or password.</center></h3>";
      }
    }
  }
  ?>

</body>

</html>
