<?php
// Razorpay test mode credentials from your Razorpay dashboard
define('RAZORPAY_KEY', 'rzp_test_YourKeyHere');  // Replace with your Key ID
define('RAZORPAY_SECRET', 'YourSecretHere');     // Replace with your Key Secret
?>
<?php
session_start();
if (empty($_SESSION['uname'])) {
    header('location: adminlogin.php');
    exit();
}

include('dbconnect.php');
include('razorpay-config.php');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$emp_name = $emp_salary = $emp_id = $payment_date = $payment_month = $da = $ta = $pf = $net_sal = $bank_name = $account_no = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['btnsrch'])) {
    $emp_id = intval($_POST['txtid']);
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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
</head>
<body>
<div class="container mt-5">
    <h3 class="text-center">Salary Payment</h3>
    <form method="POST" action="">
        <table class="table table-bordered">
            <tr>
                <td>Employee ID</td>
                <td><input type="text" name="txtid" value="<?php echo $emp_id; ?>" required>
                    <button type="submit" name="btnsrch" class="btn btn-info btn-sm">Search</button></td>
            </tr>
            <tr><td>Employee Name</td><td><?php echo $emp_name; ?></td></tr>
            <tr><td>Basic Salary</td><td><?php echo $emp_salary; ?></td></tr>
            <tr><td>DA</td><td><?php echo $da; ?></td></tr>
            <tr><td>TA</td><td><?php echo $ta; ?></td></tr>
            <tr><td>PF</td><td><?php echo $pf; ?></td></tr>
            <tr><td>Net Salary</td><td><?php echo $net_sal; ?></td></tr>
            <tr><td>Payment Date</td><td><?php echo $payment_date; ?></td></tr>
            <tr><td>Pay Month</td><td><?php echo $payment_month; ?></td></tr>
            <tr><td colspan="2" class="text-center">
                <button id="rzp-button" class="btn btn-success">Pay with Razorpay</button>
                <a href="sal.php" class="btn btn-danger ml-2">Back</a>
            </td></tr>
        </table>
    </form>
</div>

<script>
document.getElementById('rzp-button').onclick = function(e){
    e.preventDefault();

    var options = {
        "key": "<?php echo RAZORPAY_KEY; ?>",
        "amount": "<?php echo $net_sal * 100; ?>",
        "currency": "INR",
        "name": "<?php echo $emp_name; ?>",
        "description": "Salary Payment for <?php echo $payment_month; ?>",
        "handler": function (response){
            window.location.href = "success.php?payment_id=" + response.razorpay_payment_id +
                "&emp_id=<?php echo $emp_id; ?>";
        },
        "theme": { "color": "#3399cc" }
    };
    var rzp1 = new Razorpay(options);
    rzp1.open();
};
</script>
</body>
</html>