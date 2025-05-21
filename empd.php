<?php
session_start();

if (empty($_SESSION['uname'])) {
    header('location: adminlogin.php');
    exit();
}

include 'dbconnect.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$emp_id = isset($_SESSION['emp_id']) ? $_SESSION['emp_id'] : 0;

$sql = "SELECT first_name, last_name, contact_no, emp_address, department FROM tblemp WHERE emp_id = $emp_id";
$result = $conn->query($sql);

if (!$result) {
    die("Error in SQL query: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Payment Details</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
    <style>
        body {
            background-image: url('images/office1.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }

        .smoked-box {
            background-color: whitesmoke;
            padding: 25px 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 30px;
        }

        /* Buttons container - inline and spaced */
        .button-row {
            display: flex;
            gap: 10px; /* space between buttons */
            flex-wrap: wrap; /* wrap on small screens */
            margin-top: 20px;
        }

        /* Smaller buttons */
        .button-row .btn {
            padding: 0.25rem 0.75rem;
            font-size: 0.875rem;
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
                    <li class="nav-item">
                        <a class="nav-link" href="emplogout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="smoked-box">
            <h4>Details</h4>
            <div class="table-responsive">
                <table class="table table-responsive table-borderless">
                    <thead>
                        <tr class="bg-light">
                            <th scope="col" width="5%">Id</th>
                            <th scope="col" width="20%">First Name</th>
                            <th scope="col" width="20%">Last Name</th>
                            <th scope="col" width="20%">Contact No:</th>
                            <th scope="col" width="20%">Address</th>
                            <th scope="col" width="10%">Department</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()) : ?>
                            <tr>
                                <td><?= htmlspecialchars($emp_id) ?></td>
                                <td><?= htmlspecialchars($row['first_name']) ?></td>
                                <td><?= htmlspecialchars($row['last_name']) ?></td>
                                <td><?= htmlspecialchars($row['contact_no']) ?></td>
                                <td><?= htmlspecialchars($row['emp_address']) ?></td>
                                <td><?= htmlspecialchars($row['department']) ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

            <hr />

            <h4>Payment Details</h4>
            <div class="table-responsive">
                <?php
                $sql_payment = "SELECT emp_name, net_sal, payment_date, bank_name, account_no FROM tblhistory WHERE emp_id = $emp_id";
                $result_payment = $conn->query($sql_payment);

                if (!$result_payment) {
                    die("Error in SQL query: " . $conn->error);
                }

                if ($result_payment->num_rows > 0) :
                ?>
                    <table class="table table-striped table-dark">
                        <thead>
                            <tr>
                                <th>Employee ID</th>
                                <th>Employee Name</th>
                                <th>Net Salary</th>
                                <th>Payment Date</th>
                                <th>Bank Name</th>
                                <th>Account Number</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row_payment = $result_payment->fetch_assoc()) : ?>
                                <tr>
                                    <td><?= htmlspecialchars($emp_id) ?></td>
                                    <td><?= htmlspecialchars($row_payment['emp_name']) ?></td>
                                    <td><?= htmlspecialchars($row_payment['net_sal']) ?></td>
                                    <td><?= htmlspecialchars($row_payment['payment_date']) ?></td>
                                    <td><?= htmlspecialchars($row_payment['bank_name']) ?></td>
                                    <td><?= htmlspecialchars($row_payment['account_no']) ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php else : ?>
                    <p class="text-danger">No payment records found.</p>
                <?php endif; ?>
            </div>

            <div class="button-row">
                <a href="#" onclick="window.print()" class="btn btn-success btn-sm">Print</a>
                <a href="attendance.php" class="btn btn-primary btn-sm">Attendance</a>
                <a href="leave.php" class="btn btn-primary btn-sm">Req Leave</a>
                <a href="emplogin.php" class="btn btn-danger btn-sm">Back</a>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>

<?php
$result->free_result();
$conn->close();
?>
