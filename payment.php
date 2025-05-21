<?php
session_start();
if (isset($_SESSION['uname']) == "") {
    header('location: adminlogin.php');
}
?>
<?php
include('dbconnect.php');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$emp_name = $emp_salary = $emp_id = $payment_date = $da = $ta = $pf = $net_sal = $absent_days = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $emp_id = isset($_POST['txtid']) ? intval($_POST['txtid']) : 0;

    $sql = "SELECT first_name, basic_salary FROM v1 WHERE emp_id = $emp_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $emp_name = $row['first_name'];
        $emp_salary = $row['basic_salary'];

        // Get unpaid absent days from tblleave for current month
        $current_month = date('m');
        $current_year = date('Y');
        $absent_sql = "SELECT COUNT(*) as absent_days FROM tblleave 
                       WHERE emp_id = $emp_id 
                       AND leave_type = 'Unpaid' 
                       AND status = 'Approved'
                       AND MONTH(leave_date) = $current_month
                       AND YEAR(leave_date) = $current_year";
        $absent_result = $conn->query($absent_sql);
        $absent_row = $absent_result->fetch_assoc();
        $absent_days = $absent_row['absent_days'];

        $da = ($emp_salary * 55 / 100);
        $ta = ($emp_salary * 30 / 100);
        $pf = ($emp_salary * 20 / 100);
        $net_sal = ($emp_salary + $da + $ta) - ($pf + 5400 + (($emp_salary / 30) * $absent_days));

        $payment_date = isset($_POST['txtdate']) ? $_POST['txtdate'] : date('Y-m-d'); // Set to current date
        $payment_month = isset($_POST['txtmonth']) ? $_POST['txtmonth'] : date('F'); // Set to current month

        $checkSql = "SELECT * FROM tblpayment WHERE emp_id = $emp_id AND MONTH(payment_date) = MONTH('$payment_date') AND YEAR(payment_date) = YEAR('$payment_date')";
        $checkResult = $conn->query($checkSql);

        if ($checkResult->num_rows > 0) {
            echo '<script>alert("Record already saved for this month!");</script>';
        } else {
            if (isset($_POST["btnsave"])) {
                $insertSql = "INSERT INTO tblpayment (emp_id, emp_name, basic_sal, da, ta, pf, net_salary, payment_date, month)
                              VALUES ('$emp_id', '$emp_name', '$emp_salary', '$da', '$ta', '$pf', '$net_sal', '$payment_date', '$payment_month')";

                if ($conn->query($insertSql) === TRUE) {
                    echo '<script>alert("Record saved successfully");</script>';
                } else {
                    echo '<script>alert("Error: ' . $conn->error . '");</script>';
                }
            }
        }
    } else {
        $emp_name = "Employee not found";
        $emp_salary = "";
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Employee payment</title>
    <meta charset="UTF-8">
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
            border: 1px solid black;
            width: 100%;
        }

        #table-container table {
            padding: 10px;
        }
    </style>

    <script lang="javascript">
        function salp() {
            var basic = parseFloat(document.getElementById('txtsalary').value) || 0;
            var totalAbsent = parseInt(document.getElementById('txtabsent').value) || 0;

            var da = basic * 0.55;
            var ta = basic * 0.30;
            var pf = basic * 0.20;
            var insurance = 5400;

            var perDay = basic / 30;
            var absentDeduction = totalAbsent * perDay;

            var gross = basic + da + ta;
            var deductions = pf + insurance + absentDeduction;
            var net = gross - deductions;

            document.getElementById('txtda').value = da.toFixed(2);
            document.getElementById('txtta').value = ta.toFixed(2);
            document.getElementById('txtpf').value = pf.toFixed(2);
            document.getElementById('txtnet').value = net.toFixed(2);
        }

        function clearAll() {
            document.getElementById('txtid').value = "";
            document.getElementById('txtname').value = "";
            document.getElementById('txtsalary').value = "";
            document.getElementById('txtda').value = "";
            document.getElementById('txtta').value = "";
            document.getElementById('txtpf').value = "";
            document.getElementById('txtnet').value = "";
            document.getElementById('txtid').focus();
            document.getElementById('txtabsent').value = "";
        }
    </script>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-info">
        <div class="container">
            <a class="navbar-brand"><b><i>Patil Tech Innovations</i></b></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item "><a class="nav-link" href="index.html">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="about.html">About</a></li>
                    <li class="nav-item"><a class="nav-link active" href="adminlogin.php">Admin</a></li>
                    <li class="nav-item"><a class="nav-link" href="emplogin.php">Employee</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div id="table-container">
        <form method="POST" action="">
            <table border="1" cellspacing="10px" cellpadding="10px">
                <tr>
                    <th>Employee no</th>
                    <th>
                        <input type="text" name="txtid" id="txtid" placeholder="Enter Emp no" value="<?php echo $emp_id; ?>" required>
                        <button type="submit" name="btnsrch">Search</button>
                    </th>
                </tr>
                <tr>
                    <th>Employee name</th>
                    <th><input type="text" name="txtname" id="txtname" value="<?php echo $emp_name; ?>" readonly></th>
                </tr>
                <tr>
                    <th>Basic</th>
                    <th><input type="text" name="txtsalary" id="txtsalary" value="<?php echo $emp_salary; ?>" readonly></th>
                </tr>
                <tr>
                    <th>+DA</th>
                    <th><input type="text" name="txtda" id="txtda" placeholder="55%" disabled></th>
                </tr>
                <tr>
                    <th>+TA</th>
                    <th><input type="text" name="txtta" id="txtta" placeholder="30%" disabled></th>
                </tr>
                <tr>
                    <th>-PF</th>
                    <th><input type="text" name="txtpf" id="txtpf" placeholder="20%" disabled></th>
                </tr>
                <tr>
                    <th>-Insurance</th>
                    <th><input type="text" value="5400" disabled></th>
                </tr>
                <tr>
                    <th>-Absent Days</th>
                    <th><input type="number" name="txtabsent" id="txtabsent" value="<?php echo $absent_days; ?>" readonly></th>
                </tr>
                <tr>
                    <th>Net Salary</th>
                    <th><input type="text" name="txtnet" id="txtnet" disabled></th>
                </tr>
                <tr>
                    <th>Payment Date</th>
                    <th><input type="date" name="txtdate" id="txtdate" value="<?php echo date('Y-m-d'); ?>"></th>
                </tr>
                <tr>
                    <th>Payment Month</th>
                    <th>
                        <select class="form-select" id="txtmonth" name="txtmonth">
                            <option value="January" <?php echo (date('F') == 'January') ? 'selected' : ''; ?>>January</option>
                            <option value="February" <?php echo (date('F') == 'February') ? 'selected' : ''; ?>>February</option>
                            <option value="March" <?php echo (date('F') == 'March') ? 'selected' : ''; ?>>March</option>
                            <option value="April" <?php echo (date('F') == 'April') ? 'selected' : ''; ?>>April</option>
                            <option value="May" <?php echo (date('F') == 'May') ? 'selected' : ''; ?>>May</option>
                            <option value="June" <?php echo (date('F') == 'June') ? 'selected' : ''; ?>>June</option>
                            <option value="July" <?php echo (date('F') == 'July') ? 'selected' : ''; ?>>July</option>
                            <option value="August" <?php echo (date('F') == 'August') ? 'selected' : ''; ?>>August</option>
                            <option value="September" <?php echo (date('F') == 'September') ? 'selected' : ''; ?>>September</option>
                            <option value="October" <?php echo (date('F') == 'October') ? 'selected' : ''; ?>>October</option>
                            <option value="November" <?php echo (date('F') == 'November') ? 'selected' : ''; ?>>November</option>
                            <option value="December" <?php echo (date('F') == 'December') ? 'selected' : ''; ?>>December</option>
                        </select>
                    </th>
                </tr>
                <tr>
                    <td>
                        <button type="button" class="btn btn-secondary" onclick="salp()">Calculate</button>
                        <input type="submit" name="btnsave" value="Save" class="btn btn-primary">
                    </td>
                    <td>
                        <button type="button" class="btn btn-secondary" onclick="clearAll()">Clear all</button>
                        <a href="empPay.php" class="btn btn-primary" style="margin-left: 10px;">Payment</a>
                    </td>
                </tr>
            </table>
        </form>

        <p style="margin-top: 10px;"><a href="sal.php" class="btn btn-danger">Back</a></p>
    </div>
</body>
</html>
