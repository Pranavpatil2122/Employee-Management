<?php
session_start();
include 'dbconnect.php';

if (empty($_SESSION['uname'])) {
    header('location: adminlogin.php');
    exit();
}

$emp_id = $_SESSION['emp_id'];

// Get employee leave balance
$emp_query = $conn->query("SELECT monthly_paid_leaves FROM tblemp WHERE emp_id = $emp_id");
$emp_data = $emp_query->fetch_assoc();
$paid_balance = $emp_data['monthly_paid_leaves'] ?? 0;

// Apply for leave
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['apply_leave'])) {
    $leave_date = $_POST['leave_date'];
    $reason = $conn->real_escape_string($_POST['reason']);
    $requested_type = $_POST['leave_type']; // 'Paid' or 'Unpaid'

    // Check if already applied
    $check_query = $conn->query("SELECT * FROM tblleave WHERE emp_id = $emp_id AND leave_date = '$leave_date'");
    if ($check_query->num_rows == 0) {
        // Insert leave
        $leave_type = ($requested_type == 'Paid' && $paid_balance > 0) ? 'Paid' : 'Unpaid';
        $insert = "INSERT INTO tblleave (emp_id, leave_date, leave_type, reason) 
                   VALUES ($emp_id, '$leave_date', '$leave_type', '$reason')";
        $conn->query($insert);
        $message = "Leave requested successfully as $leave_type leave.";
    } else {
        $error = "You have already applied for leave on this date.";
    }
}

// Fetch leave history
$history = $conn->query("SELECT * FROM tblleave WHERE emp_id = $emp_id ORDER BY leave_date DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Leave Request</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<nav class="navbar navbar-light bg-info">
    <div class="container">
        <span class="navbar-brand mb-0 h1"><b>Patil Tech Innovations</b></span>
        <a href="emplogout.php" class="btn btn-danger">Logout</a>
    </div>
</nav>

<div class="container mt-4">
    <h4>Apply for Leave</h4>

    <?php if (isset($message)): ?>
        <div class="alert alert-success"><?= $message ?></div>
    <?php elseif (isset($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <p><strong>Remaining Paid Leaves:</strong> <?= $paid_balance ?> this month</p>

    <form method="POST">
        <div class="form-group">
            <label for="leave_date">Leave Date</label>
            <input type="date" class="form-control" name="leave_date" required>
        </div>
        <div class="form-group">
            <label for="leave_type">Leave Type</label>
            <select class="form-control" name="leave_type">
                <option value="Paid">Paid</option>
                <option value="Unpaid">Unpaid</option>
            </select>
        </div>
        <div class="form-group">
            <label for="reason">Reason</label>
            <textarea class="form-control" name="reason" rows="3" required></textarea>
        </div>
        <button type="submit" name="apply_leave" class="btn btn-primary">Submit Leave</button>
    </form>

    <hr>
    <h5>Leave History</h5>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Date</th>
                <th>Type</th>
                <th>Reason</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $history->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['leave_date'] ?></td>
                    <td><?= $row['leave_type'] ?></td>
                    <td><?= $row['reason'] ?></td>
                    <td><?= $row['status'] ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

</body>
</html>
