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
    h2{
      margin-top:30px ;
    }
    form {
      border: 1px solid black; 
      border-radius:20px;
      margin-top:40px;
      padding: 20px; 
      backdrop-filter:blur(10px);
      
    }
    body{
   background-image:url(images/admin.jpg);
   background-size: cover;
   background-repeat: no-repeat;
}
  
  </style>
</head>

<body>
<nav><nav class="navbar navbar-expand-lg navbar-light bg-info">
            <div class="container">
              <a class="navbar-brand"><b><i>Patil Tech Inovations</i></b></a>
              <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
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
                    <a class="nav-link active" href="adminlogin.php">Admin</a>
                    <span class="sr-only">(current)</span>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="emplogin.php">Employee</a>
                  </li>
                </ul>
              </div>
            </div>
          </nav>
        </nav>

        <div class="container">
    <div class="col-md-6 mx-auto">
        <h2 class="text-center text-light">Admin Login</h2>
        <form name="frmreg" action="#" method="POST" class="was-validated">
            <div class="form-group">
                <label for="username" class="text-light">User Name:</label>
                <input type="text" class="form-control" placeholder="Enter User Name:" name="txtuname" required>
                <div class="valid-feedback text-success">Valid</div>
                <div class="invalid-feedback text-danger">Please fill out this field</div>
            </div>
            <div class="form-group">
                <label for="password" class="text-light">Password:</label>
                <input type="password" class="form-control" placeholder="Enter password:" name="txtpassw" required>
                <div class="valid-feedback text-success">Valid</div>
                <div class="invalid-feedback text-danger">Please fill out this field</div>
            </div>
            <input type="submit" name="btnlogin" class="btn btn-primary" value="Login">
            <div class="text-center mt-2">
  <a href="forgot_password.php" class="text-light">Forgot Password?</a>
</div>
        </form>
    </div>
    
</div>

  <?php
  session_start();
  include('dbconnect.php');

  if (isset($_POST['btnlogin']))
   {
    $uname = $_POST['txtuname'];
    $passw = $_POST['txtpassw']; 

    $sql = "SELECT user_name, user_password FROM tbladmin WHERE user_name='$uname' AND user_password='$passw'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

    $count = mysqli_num_rows($result);

    if ($count == 1) {
      echo "<h3><center> Login successful </center></h3>";
      $_SESSION['uname'] = $uname;
      header("location:admin.php");
    } else {
      echo "<h4><center> Login failed. Invalid username or password.</center></h4>";
    }
  }
  ?>

</body>

</html>
