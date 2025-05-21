<?php
session_start();
if (empty($_SESSION['uname'])) {
    header('location: adminlogin.php');
    exit();
}

include 'dbconnect.php';

$sql = "SELECT emp_id, first_name,last_name, contact_no, emp_address, department, emp_email FROM tblemp";
$result = $conn->query($sql);

if (!$result) {
    die("Error in SQL query: " . $conn->error);
}
?>

<html>
  <head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <style>
      @import url('https://fonts.googleapis.com/css2?family=Open+Sans:wght@300&display=swap');

      body {
        font-family: 'Open Sans', sans-serif;
      }

      .search {
        top: 6px;
        left: 10px;
      }

      .form-control {
        border: none;
        padding-left: 32px;
      }

      .form-control:focus {
        border: none;
        box-shadow: none;
      }

      .green {
        color: green;
      }
    </style>
  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-light bg-info">
      <div class="container">
        <a class="navbar-brand"><b><i>Patil Tech Inovations</i></b></a>
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
              <a class="nav-link " href="about.html">About</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active " href="adminlogin.php">Admin</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="emplogin.php">Employee</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <div class="container mt-5 px-2">
      <div class="table-responsive">
        <table class="table table-responsive table-borderless">
          <thead>
            <tr class="bg-light">
              <th scope="col" width="5%">Emp id</th>
              <th scope="col" width="20%">First Name</th>
              <th scope="col" width="20%">Last Name</th>
              <th scope="col" width="20%">Contact No:</th>
              <th scope="col" width="20%">Address</th>
              <th scope="col" width="10%">Department</th>
              <th scope="col" width="20%">Email</th>
             </tr>
          </thead>
          <tbody>
            <?php
            while ($row = $result->fetch_assoc()) {
              echo "<tr>";
              echo "<td>{$row['emp_id']}</td>";
              echo "<td>{$row['first_name']}</td>";
              echo "<td>{$row['last_name']}</td>";
              echo "<td>{$row['contact_no']}</td>";
              echo "<td>{$row['emp_address']}</td>";
              echo "<td>{$row['department']}</td>";
              echo "<td>{$row['emp_email']}</td>";
              echo "</tr>";
            }
            ?>
          </tbody>
        </table>
        <div class="mt-3">
        <button onclick="window.print()" class="btn btn-success">Print</button>
        <a href="reportmain.php" class="btn btn-danger">Back</a>
    </div>
      </div>
    </div>
  </body>
</html>

<?php
// Free the result set and close the connection
$result->free_result();
$conn->close();
?>
