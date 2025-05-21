<?php
session_start();
if (empty($_SESSION['uname'])) {
    header('location: adminlogin.php');
    exit();
}

include('dbconnect.php');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$emp_name = $emp_salary = $emp_id = $payment_date = $payment_month = $da = $ta = $pf = $net_sal = $bank_name = $account_no = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $emp_id = isset($_POST['txtid']) ? intval($_POST['txtid']) : 0;
    $_SESSION['emp_id'] = $emp_id;

    $sql = "SELECT emp_name, basic_sal, da, ta, pf, net_salary, payment_date, month
            FROM tblpayment 
            WHERE emp_id = $emp_id
            ORDER BY payment_date DESC
            LIMIT 1";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $emp_name = $row['emp_name'];
        $emp_salary = $row['basic_sal'];
        $da = $row['da'];
        $ta = $row['ta'];
        $pf = $row['pf'];
        $net_sal = $row['net_salary'];
        $payment_date = $row['payment_date'];
        $payment_month = $row['month'];
        $bank_name = isset($_POST['bank_name']) ? $_POST['bank_name'] : "";
        $account_no = isset($_POST['account_no']) ? $_POST['account_no'] : "";
    }
}

if (isset($_POST["btnsave"])) {
    // Check for duplicate payment for the month
    $checkSql = "SELECT * FROM tblhistory 
                 WHERE emp_id = '$emp_id' 
                   AND payment_month = '$payment_month'";

    $checkResult = $conn->query($checkSql);

    if ($checkResult->num_rows > 0) {
        echo '<script>alert("This employee has already been paid for the month of ' . $payment_month . '.");</script>';
    } else {
        $insertSql = "INSERT INTO tblhistory (emp_id, emp_name, basic_sal, da, ta, pf, net_sal, payment_date, payment_month, bank_name, account_no)
                      VALUES ('$emp_id', '$emp_name', '$emp_salary', '$da', '$ta', '$pf', '$net_sal', '$payment_date', '$payment_month', '$bank_name', '$account_no')";

        if ($conn->query($insertSql) === TRUE) {
            echo '<script>alert("Payment successfully recorded.");</script>';
            header('location: success.php');
            exit();
        } else {
            echo '<script>alert("Error: ' . $conn->error . '");</script>';
        }
    }
}

$conn->close();
?>
<?php
$_SESSION['emp_id']=$emp_id;
?>



<!DOCTYPE html>
<html>

<head>
    <title>Employee payment</title>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <style>
        #table-container {
            width: 500px;
            margin: 0 auto;
        }

        table {
            margin-top: 30px;
            width: 100%;
        }

        #table-container table {
            padding: 10px;
        }
    </style>

</head>

<body>
    <nav>
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
    </nav>

    <!-- table -->

    <div id="table-container">
    <form method="POST" action="">
        <table cellspacing="10px" cellpadding="10px">
            <tr>
                <th>Employee no</th>
                <th>
                    <input type="text" name="txtid" id="txtid" placeholder="Enter Emp no" value="<?php echo $emp_id; ?>" required>
                    <button type="submit" name="btnsrch">search</button>
                </th>
            </tr>
            <tr>
                <th>Employee name</th>
                <th>
                    <label for="txtname"><?php echo $emp_name; ?></label>
                </th>
            </tr>
            <tr>
                <th>Basic Salary</th>
                <th>
                    <label for="txtsalary"><?php echo $emp_salary; ?></label>
                </th>
            </tr>
            <tr>
                <th>DA</th>
                <th>
                    <label for="txtda"><?php echo $da; ?></label>
                </th>
            </tr>
            <tr>
                <th>TA</th>
                <th>
                    <label for="txtta"><?php echo $ta; ?></label>
                </th>
            </tr>
            <tr>
                <th>PF</th>
                <th>
                    <label for="txtpf"><?php echo $pf; ?></label>
                </th>
            </tr>
            <tr>
                <th>Net Salary</th>
                <th>
                    <label for="txtnetsalary"><?php echo $net_sal; ?></label>
                </th>
            </tr>
            <tr>
                <th>Payment Date</th>
                <th>
                    <label for="txtpaymentdate"><?php echo $payment_date; ?></label>
                </th>
            </tr>
            <tr>
                <th>Pay Month</th>
                <th>
                    <label for="txtpaymentmonth"><?php echo $payment_month; ?></label>
                </th>
            </tr>
            <tr>
    <th>Bank Name</th>
    <th>
        <input type="text" name="bank_name" id="bank_name" placeholder="Enter Bank Name" >
    </th>
</tr>
<tr>
    <th>Account Number</th>
    <th>
        <input type="text" name="account_no" id="account_no" placeholder="Enter Account Number">
    </th>
</tr>

            <tr>
                <th></th>
                <th>
                    <div class="button-container">
                    <input type="submit" name="btnsave" value="Payment" class="btn btn-primary">
                        <a href="sal.php" class="btn btn-danger" style="margin-left: 10px;">Back</a>
                    </div>
                </th>
            </tr>
        </table>
    </form>
</div>
</div>
    </div>
   
</body>

</html>
