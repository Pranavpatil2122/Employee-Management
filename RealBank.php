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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['btnsrch'])) {
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
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Employee Payment</title>
    <meta charset="UTF-8">
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        #table-container {
            width: 600px;
            margin: 30px auto;
        }
    </style>
</head>
<body>
    <div id="table-container">
        <form method="POST" action="">
            <table class="table">
                <tr>
                    <th>Employee no</th>
                    <td>
                        <input type="text" name="txtid" value="<?php echo $emp_id; ?>" required>
                        <button type="submit" name="btnsrch" class="btn btn-sm btn-info">Search</button>
                    </td>
                </tr>
                <?php if (!empty($emp_name)): ?>
                <tr><th>Employee Name</th><td><?php echo $emp_name; ?></td></tr>
                <tr><th>Basic Salary</th><td><?php echo $emp_salary; ?></td></tr>
                <tr><th>DA</th><td><?php echo $da; ?></td></tr>
                <tr><th>TA</th><td><?php echo $ta; ?></td></tr>
                <tr><th>PF</th><td><?php echo $pf; ?></td></tr>
                <tr><th>Net Salary</th><td><?php echo $net_sal; ?></td></tr>
                <tr><th>Payment Date</th><td><?php echo $payment_date; ?></td></tr>
                <tr><th>Payment Month</th><td><?php echo $payment_month; ?></td></tr>
                <tr>
                    <th>Bank Name</th>
                    <td><input type="text" id="bank_name" placeholder="Bank name" class="form-control"></td>
                </tr>
                <tr>
                    <th>Account No</th>
                    <td><input type="text" id="account_no" placeholder="Account number" class="form-control"></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <button type="button" class="btn btn-success btn-block" onclick="payNow()">Pay via Razorpay</button>
                        <a href="sal.php" class="btn btn-danger btn-block">Back</a>
                    </td>
                </tr>
                <?php endif; ?>
            </table>
        </form>
    </div>

    <script>
    function payNow() {
        var bankName = document.getElementById("bank_name").value;
        var accountNo = document.getElementById("account_no").value;

        if (!bankName || !accountNo) {
            alert("Please fill in bank name and account number.");
            return;
        }

        var options = {
            "key": "YOUR_RAZORPAY_KEY", // Replace with your actual Razorpay key
            "amount": <?php echo $net_sal * 100; ?>, // amount in paise
            "currency": "INR",
            "name": "Patil Tech Innovations",
            "description": "Salary Payment",
            "handler": function (response) {
                window.location.href = "payment_success.php?pid=" + response.razorpay_payment_id + 
                                       "&emp_id=<?php echo $emp_id; ?>" + 
                                       "&bank=" + encodeURIComponent(bankName) + 
                                       "&acc=" + encodeURIComponent(accountNo);
            },
            "prefill": {
                "name": "<?php echo $emp_name; ?>",
                "email": "employee@example.com"
            },
            "theme": {
                "color": "#3399cc"
            }
        };
        var rzp = new Razorpay(options);
        rzp.open();
    }
    </script>
</body>
</html>
