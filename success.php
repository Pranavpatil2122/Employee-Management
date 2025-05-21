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

$employeeId = isset($_SESSION['emp_id']) ? $_SESSION['emp_id'] : 0;

$sql = "SELECT emp_name, net_sal, bank_name, account_no, payment_date FROM tblhistory WHERE emp_id = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Error in SQL query: " . $conn->error);
}

$stmt->bind_param("i", $employeeId);
$stmt->execute();

$result = $stmt->get_result();

if (!$result) {
    die("Error in SQL query: " . $conn->error);
}

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $employeeName = $row['emp_name'];
    $netSalary = $row['net_sal'];
    $bankName = $row['bank_name'];
    $accountNo = $row['account_no'];
    $paymentDate = $row['payment_date'];
}

$result->free_result();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Successful</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-top: 50px;
        }

        h2 {
            color: #28a745;
        }

        hr {
            border-top: 2px solid #28a745;
            margin-top: 10px;
        }

        .row {
            margin-top: 20px;
        }

        .col-md-6 {
            padding: 15px;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            margin-bottom: 10px;
            font-size: 16px;
        }

    </style>
</head>

<body>
    <div class="container">
        <h2>Payment Successful</h2>
        <hr>

        <div class="row">
            <!-- Employee Details -->
            <div class="col-md-6">
                <h4>Employee Details</h4>
                <ul>
                    <li><strong>Employee ID:</strong> <?php echo $employeeId; ?></li>
                    <li><strong>Employee Name:</strong> <?php echo $employeeName; ?></li>
                    <li><strong>Net Salary:</strong> <?php echo $netSalary; ?></li>
                    <li><strong>Payment date:</strong> <?php echo $paymentDate; ?></li>
                </ul>
            </div>

            <!-- Bank Information -->
            <div class="col-md-6">
                <h4>Bank Information</h4>
                <ul>
                    <li><strong>Bank Name:</strong> <?php echo $bankName; ?></li>
                    <li><strong>Account Number:</strong> <?php echo $accountNo; ?></li>
                </ul>
            </div>
        </div>

        <div class="mt-3">
            <button onclick="window.print()" class="btn btn-success">Print</button>
            <a href="sal.php" class="btn btn-danger">Back</a>
        </div>
    </div>
</body>

</html>
