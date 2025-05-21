<?php
include('dbconnect.php');

if (isset($_POST['submit'])) {
    $email = $_POST['txtemail'];

    // Check if email exists in employee table
    $sql = "SELECT * FROM tblemployee WHERE email='$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        // Redirect to employee reset password page
        header("Location: emp_reset_password.php?email=" . urlencode($email));
        exit();
    } else {
        echo "<script>alert('Email not found');</script>";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
  <title>Employee Forgot Password</title>
  <meta charset="utf-8">

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

  <style>
    h2 {
      margin-top: 30px;
    }
    form {
      border: 1px solid black;
      border-radius: 20px;
      margin-top: 40px;
      padding: 20px;
      backdrop-filter: blur(10px);
    }
    body {
      background-image: url(images/employee.jpg);
      background-size: cover;
      background-repeat: no-repeat;
    }
    .link-admin {
      margin-top: 15px;
      display: block;
      text-align: center;
    }
  </style>
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-info">
    <div class="container">
      <a class="navbar-brand"><b><i>Patil Tech Innovations</i></b></a>
    </div>
  </nav>

  <div class="container">
    <div class="col-md-6 mx-auto">
      <h2 class="text-center text-light">Employee Forgot Password</h2>
      <form method="POST" class="was-validated">
        <div class="form-group">
          <label for="email" class="text-dark">Go to Admin Forgot Password</label>
          
        </div>

      </form>
      <a href="forgot_password.php" class="link-admin text-light">Go to Admin Forgot Password</a>
    </div>
  </div>

</body>

</html>
