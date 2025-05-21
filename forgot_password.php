<?php
include('dbconnect.php');

if (isset($_POST['submit'])) {
    $email = $_POST['txtemail'];

    $sql = "SELECT * FROM tbladmin WHERE email='$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        header("Location: reset_password.php?email=" . urlencode($email));
        exit();
    } else {
        echo "<script>alert('Email not found');</script>";
    }
}
?>


<!DOCTYPE html>
<html>

<head>
  <title>Forgot Password</title>
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
      background-image: url(images/admin.jpg);
      background-size: cover;
      background-repeat: no-repeat;
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
      <h2 class="text-center text-light">Forgot Password</h2>
      <form method="POST" class="was-validated">
        <div class="form-group">
          <label for="email" class="text-light">Enter your Email Address:</label>
          <input type="email" class="form-control" placeholder="Enter Email" name="txtemail" required>
          <div class="valid-feedback text-success">Valid</div>
          <div class="invalid-feedback text-danger">Please enter your email</div>
        </div>
        <input type="submit" name="submit" class="btn btn-warning" value="Continue">
      </form>
    </div>
  </div>

</body>

</html>
