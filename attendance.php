<?php
session_start();

if (empty($_SESSION['uname'])) {
    header('location: emplogin.php');
    exit();
}

include 'dbconnect.php';

$emp_id = isset($_SESSION['emp_id']) ? $_SESSION['emp_id'] : 0;
$today = date('Y-m-d');
$has_attended = false;

// Check attendance for today
$check_attendance = "SELECT * FROM tblattendance WHERE emp_id = $emp_id AND date = '$today'";
$result_check = $conn->query($check_attendance);

if ($result_check->num_rows > 0) {
    $has_attended = true;
}

// Handle form submit
if (!$has_attended && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['attend'])) {
    $status = $_POST['status']; // "Present" or "Absent"
    $sql_attend = "INSERT INTO tblattendance (emp_id, date, status) VALUES ($emp_id, '$today', '$status')";
    if ($conn->query($sql_attend)) {
        $has_attended = true;
        $message = "Attendance marked as " . $status . " successfully.";
    } else {
        $error = "Error: " . $conn->error;
    }
}

// Fetch attendance history (without in_time and out_time)
$sql_attendance = "SELECT date, status FROM tblattendance WHERE emp_id = $emp_id ORDER BY date DESC";
$result_attendance = $conn->query($sql_attendance);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Attendance</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-info">
    <div class="container">
        <a class="navbar-brand"><b><i>Patil Tech Inovations</i></b></a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <h4>Attendance</h4>
    <hr>

    <?php if (isset($message)): ?>
        <div class="alert alert-success"><?php echo $message; ?></div>
    <?php elseif (isset($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <?php if (!$has_attended): ?>
        <form method="POST" class="mb-3">
            <div class="form-group">
                <label for="status">Mark your attendance:</label>
                <select name="status" id="status" class="form-control" required>
                    <option value="Present">Present</option>
                    <option value="Absent">Absent</option>
                </select>
            </div>
            <button type="submit" name="attend" class="btn btn-primary">Submit</button>
        </form>
    <?php elseif ($has_attended): ?>
        <div class="alert alert-info">Attendance already marked for today.</div>
    <?php endif; ?>

    <?php if ($result_attendance && $result_attendance->num_rows > 0): ?>
        <div class="table-responsive">
            <table class="table table-bordered table-striped mt-3">
                <thead class="thead-dark">
                    <tr>
                        <th>Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result_attendance->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['date']; ?></td>
                            <td><?php echo $row['status']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <p class="text-danger">No attendance records found.</p>
    <?php endif; ?>

    <div class="mt-3 d-flex gap-2">
        <button onclick="window.print()" class="btn btn-success mr-2">Print</button>
        <a href="empd.php" class="btn btn-danger">Back</a>
    </div>
</div>

</body>
</html>

<?php
$result_check->free_result();
if ($result_attendance) $result_attendance->free_result();
$conn->close();
?>
