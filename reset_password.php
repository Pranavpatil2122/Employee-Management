<?php
include('dbconnect.php');

if (isset($_GET['email'])) {
    $email = $_GET['email'];
} else {
    echo "<script>alert('Email not specified.'); window.location.href='forgot_password.php';</script>";
    exit();
}

if (isset($_POST['submit'])) {
    $newpass = $_POST['new_password'];
    $confpass = $_POST['confirm_password'];

    if ($newpass === $confpass) {
        // Store password as plain text (not secure, but as requested)
        $sql = "UPDATE tbladmin SET user_password='$newpass' WHERE email='$email'";

        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Password reset successfully. You can now login.'); window.location.href='adminlogin.php';</script>";
        } else {
            echo "<script>alert('Error updating password.');</script>";
        }
    } else {
        echo "<script>alert('Passwords do not match.');</script>";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
  <title>Reset Password</title>
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
      <a class="navbar-brand"><b><i>Patil Tech Inovations</i></b></a>
    </div>
  </nav>

  <div class="container">
    <div class="col-md-6 mx-auto">
      <h2 class="text-center text-light">Reset Password</h2>
      <form method="POST" class="was-validated">
        <div class="form-group">
          <label for="new_password" class="text-light">New Password:</label>
          <input type="password" class="form-control" name="new_password" required>
          <div class="valid-feedback text-success">Valid</div>
          <div class="invalid-feedback text-danger">Please enter new password</div>
        </div>
        <div class="form-group">
          <label for="confirm_password" class="text-light">Confirm Password:</label>
          <input type="password" class="form-control" name="confirm_password" required>
          <div class="valid-feedback text-success">Valid</div>
          <div class="invalid-feedback text-danger">Please confirm the password</div>
        </div>
        <input type="submit" name="submit" class="btn btn-success" value="Reset Password">
      </form>
    </div>
  </div>
</body>

</html>
