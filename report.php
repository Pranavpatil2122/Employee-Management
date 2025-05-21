<?php
session_start();
if (empty($_SESSION['uname'])) {
    header('location: adminlogin.php');
    exit();
}

include 'dbconnect.php';

// Handle Clear Table Request
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['clear_table'])) {
    $delete_sql = "DELETE FROM tblhistory";
    if ($conn->query($delete_sql) === TRUE) {
        echo "<script>alert('All records have been deleted.');</script>";
    } else {
        echo "<script>alert('Error deleting records: " . $conn->error . "');</script>";
    }
}

// Fetch records again after deletion
$sql = "SELECT emp_id, emp_name, net_sal, payment_date, bank_name, account_no, basic_sal, da, ta, pf FROM tblhistory";
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
    </style>
  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-light bg-info">
      <div class="container">
        <a class="navbar-brand"><b><i>Patil Tech Inovations</i></b></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item"><a class="nav-link" href="index.html">Home</a></li>
            <li class="nav-item"><a class="nav-link" href="about.html">About</a></li>
            <li class="nav-item"><a class="nav-link active" href="adminlogin.php">Admin</a></li>
            <li class="nav-item"><a class="nav-link" href="emplogin.php">Employee</a></li>
          </ul>
        </div>
      </div>
    </nav>

    <div class="container mt-5 px-2">
      <div class="table-responsive">
        <table class="table table-responsive table-borderless">
          <thead>
            <tr class="bg-light">
              <th scope="col">Emp id</th>
              <th scope="col">Name</th>
              <th scope="col">Payment Date</th>
              <th scope="col">Bank Name</th>
              <th scope="col">Account No</th>
              <th scope="col">Basic Salary</th>
              <th scope="col">DA</th>
              <th scope="col">TA</th>
              <th scope="col">PF</th>
              <th scope="col" class="text-end">Net Salary</th>
            </tr>
          </thead>
          <tbody>
            <?php
            if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>{$row['emp_id']}</td>";
                echo "<td>{$row['emp_name']}</td>";
                echo "<td>{$row['payment_date']}</td>";
                echo "<td>{$row['bank_name']}</td>";
                echo "<td>{$row['account_no']}</td>";
                echo "<td>{$row['basic_sal']}</td>";
                echo "<td>{$row['da']}</td>";
                echo "<td>{$row['ta']}</td>";
                echo "<td>{$row['pf']}</td>";
                echo "<td>{$row['net_sal']}</td>";
                echo "</tr>";
              }
            } else {
              echo "<tr><td colspan='10' class='text-center'>No records found.</td></tr>";
            }
            ?>
          </tbody>
        </table>

        <div class="mt-3 d-flex justify-content-start align-items-center gap-2">
  <button onclick="window.print()" class="btn btn-success me-2">Print</button>

  <form method="POST" class="me-2 mb-0" onsubmit="return confirm('Are you sure you want to delete all records?');">
    <input type="hidden" name="clear_table" value="1">
    <button type="submit" class="btn btn-warning">Clear Table</button>
  </form>

  <a href="admin.php" class="btn btn-danger">Back</a>
</div>

      </div>
    </div>
  </body>
</html>

<?php
$result->free_result();
$conn->close();
?>
