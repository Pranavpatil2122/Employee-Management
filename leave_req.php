<?php
session_start();
include 'dbconnect.php';

// Manual reset of monthly paid leaves
if (isset($_POST['reset_leaves'])) {
    $stmt = $conn->prepare("UPDATE tblemp SET monthly_paid_leaves = 5");
    $stmt->execute();
    $stmt->close();
    $message = "All employees' paid leaves have been reset to 5.";
}

// Approve or Reject logic
if (isset($_POST['leave_date'], $_POST['action'], $_POST['emp_id'], $_POST['leave_type'])) {
    $leave_date = $_POST['leave_date'];
    $status = $_POST['action'];
    $emp_id = (int)$_POST['emp_id'];
    $leave_type = $_POST['leave_type'];

    // Update leave status
    $stmt = $conn->prepare("UPDATE tblleave SET status = ? WHERE emp_id = ? AND leave_date = ?");
    $stmt->bind_param("sis", $status, $emp_id, $leave_date);
    $stmt->execute();
    $stmt->close();

    if ($status === 'Approved') {
        if ($leave_type === 'Paid') {
            // Deduct paid leave if available
            $stmt = $conn->prepare("UPDATE tblemp SET monthly_paid_leaves = monthly_paid_leaves - 1 
                                    WHERE emp_id = ? AND monthly_paid_leaves > 0");
            $stmt->bind_param("i", $emp_id);
            $stmt->execute();
            $stmt->close();
            
            // Mark as Absent (Paid) in attendance
            $stmt = $conn->prepare("INSERT INTO tblattendance (emp_id, date, status) 
                                    VALUES (?, ?, 'Absent (Paid)')
                                    ON DUPLICATE KEY UPDATE status = 'Absent (Paid)'");
            $stmt->bind_param("is", $emp_id, $leave_date);
            $stmt->execute();
            $stmt->close();
        } elseif ($leave_type === 'UnPaid') {
            // Mark as Absent (Unpaid) in attendance
            $stmt = $conn->prepare("INSERT INTO tblattendance (emp_id, date, status) 
                                    VALUES (?, ?, 'Absent (Unpaid)')
                                    ON DUPLICATE KEY UPDATE status = 'Absent (Unpaid)'");
            $stmt->bind_param("is", $emp_id, $leave_date);
            $stmt->execute();
            $stmt->close();
        }
    }

    $message = "Leave $status successfully.";
} else if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['reset_leaves'])) {
    $error = "Missing required parameters.";
}

// Get all leave requests
$result = $conn->query("
    SELECT l.emp_id as leave_id, l.emp_id, l.leave_date, l.leave_type, l.reason, l.status, 
           e.first_name, e.last_name
    FROM tblleave l
    JOIN tblemp e ON l.emp_id = e.emp_id
    ORDER BY l.leave_date DESC
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin - Leave Requests</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<nav><nav class="navbar navbar-expand-lg navbar-light bg-info">
            <div class="container">
              <a class="navbar-brand"><b><i>Patil Tech Inovations</i></b></a>
              <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
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
                    <span class="sr-only">(current)</span>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="emplogin.php">Employee</a>
                  </li>
                </ul>
              </div>
            </div>
          </nav>
        </nav>

<div class="container mt-5">
    <h3>Leave Requests</h3>

    <!-- Show success or error messages -->
    <?php if (isset($message)): ?>
        <div class="alert alert-success"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <!-- Reset Paid Leaves Button -->
    <form method="POST" class="mb-3">
    <div class="d-flex justify-content-between align-items-center">
        <button type="submit" name="reset_leaves" class="btn btn-primary"
                onclick="return confirm('Are you sure you want to reset paid leaves to 5 for all employees?');">
            Reset Paid Leaves For this Month
        </button>

        <a href="admin.php" class="btn btn-secondary">← Back</a>
    </div>
</form>


    <!-- Leave Requests Table -->
    <table class="table table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>Employee</th>
                <th></th>
                <th>Date</th>
                <th>Type</th>
                <th>Reason</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['first_name']) ?></td>
                <td><?= htmlspecialchars($row['last_name']) ?></td>
                <td><?= htmlspecialchars($row['leave_date']) ?></td>
                <td><?= htmlspecialchars($row['leave_type']) ?></td>
                <td><?= htmlspecialchars($row['reason']) ?></td>
                <td><?= htmlspecialchars($row['status']) ?></td>
                <td>
                    <?php if ($row['status'] === 'Pending'): ?>
                        <form method="POST" style="display:inline-block;">
                            <input type="hidden" name="leave_id" value="<?= $row['leave_id'] ?>">
                            <input type="hidden" name="emp_id" value="<?= $row['emp_id'] ?>">
                            <input type="hidden" name="leave_type" value="<?= $row['leave_type'] ?>">
                            <input type="hidden" name="leave_date" value="<?= $row['leave_date'] ?>">
                            <button type="submit" name="action" value="Approved" class="btn btn-success btn-sm"
                                    onclick="return confirm('Are you sure you want to approve this leave?');">
                                Approve
                            </button>
                            <button type="submit" name="action" value="Rejected" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Are you sure you want to reject this leave?');">
                                Reject
                            </button>
                        </form>
                    <?php else: ?>
                        <em>No action</em>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>

</body>
</html>
