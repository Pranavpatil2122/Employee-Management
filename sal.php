<?php
session_start();
if (isset($_SESSION['uname']) == "") {
    header('location: adminlogin.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        .wrapper {
            width: 600px;
            margin: 0 auto;
        }
        table tr td:last-child {
            width: 120px;
        }
    </style>
    <script>
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
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
                <li class="nav-item">
                    <a class="nav-link" href="index.html">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="about.html">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="adminlogin.php">Admin</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="emplogin.php">Employee</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="mt-5 mb-3 clearfix">
                    <h2 class="pull-left">Salary Details</h2>
                    <a href="Payment.php" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Make Payment</a>
                    <a href="salary.php" class="btn btn-success pull-right" style="margin-right: 10px;"><i class="fa fa-plus"></i> Add Salary</a>
                </div>

                <?php
                // Include config file
                require_once "dbconnect.php";

                // Get the current month and year
                $current_month = date('m');
                $current_year = date('Y');

                // Modify SQL query to include the total absent count for each employee
                $sql = "SELECT t1.emp_id, t1.first_name, t1.department, t2.basic_salary, 
                               (SELECT COUNT(*) FROM tblleave 
                                WHERE emp_id = t1.emp_id 
                                  AND leave_type = 'UnPaid'
                                  AND status='Approved'
                                  AND MONTH(leave_date) = $current_month 
                                  AND YEAR(leave_date) = $current_year) AS total_absent
                        FROM tblemp AS t1
                        INNER JOIN tblsalary AS t2 ON t1.emp_id = t2.emp_id";

                if ($result = mysqli_query($conn, $sql)) {
                    if (mysqli_num_rows($result) > 0) {
                        echo '<table class="table table-bordered table-striped">';
                        echo "<thead>";
                        echo "<tr>";
                        echo "<th>#</th>";
                        echo "<th>Name</th>";
                        echo "<th>Salary</th>";
                        echo "<th>Department</th>";
                        echo "<th>Total Absent (This Month)</th>";
                        echo "<th>Action</th>";
                        echo "</tr>";
                        echo "</thead>";
                        echo "<tbody>";

                        while ($row = mysqli_fetch_array($result)) {
                            echo "<tr>";
                            echo "<td>" . $row['emp_id'] . "</td>";
                            echo "<td>" . $row['first_name'] . "</td>";
                            echo "<td>" . $row['basic_salary'] . "</td>";
                            echo "<td>" . $row['department'] . "</td>";
                            echo "<td>" . $row['total_absent'] . "</td>";
                            echo "<td>";
                            echo '<a href="salupdate.php?id=' . $row['emp_id'] . '" class="mr-3" title="Update Record" data-toggle="tooltip"><span class="fa fa-pencil"></span></a>';
                            echo "</td>";
                            echo "</tr>";
                        }

                        echo "</tbody>";
                        echo "</table>";
                        // Free result set
                        mysqli_free_result($result);
                    } else {
                        echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
                    }
                } else {
                    echo "Oops! Something went wrong. Please try again later.";
                }

                // Close connection
                mysqli_close($conn);
                ?>
                <p><a href="admin.php" class="btn btn-primary">Back</a></p>
            </div>
        </div>
    </div>
</div>
</body>
</html>
