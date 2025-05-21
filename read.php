<?php
// Check existence of id parameter before processing further
if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
    // Include config file
    require_once "dbconnect.php";

    // Prepare a select statement
    $sql = "SELECT * FROM tblemp WHERE emp_id = ?";

    if ($stmt = mysqli_prepare($conn, $sql)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "i", $param_id);

        // Set parameters
        $param_id = trim($_GET["id"]);

        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($result) == 1) {
                /* Fetch result row as an associative array. Since the result set
                contains only one row, we don't need to use a while loop */
                $row = mysqli_fetch_assoc($result);

                // Retrieve individual
                $name = $row["first_name"];
                $address = $row["emp_address"];
                $dept = $row["department"];
            } else {
                // URL doesn't contain a valid id parameter. Redirect to the error page
                header("location: error.php");
                exit();
            }
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }

    // Close connection
    mysqli_close($conn);
} else {
    // URL doesn't contain an id parameter. Redirect to the error page
    header("location: error.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>View Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper {
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="mt-5 mb-3">View Record</h1>
                    <div class="form-group">
                        <label>First Name</label>
                        <p><b><?php echo htmlspecialchars($row["first_name"]); ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Last Name</label>
                        <p><b><?php echo htmlspecialchars($row["last_name"]); ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Contact NO:</label>
                        <p><b><?php echo htmlspecialchars($row["contact_no"]); ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Address</label>
                        <p><b><?php echo htmlspecialchars($row["emp_address"]); ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Department</label>
                        <p><b><?php echo htmlspecialchars($row["department"]); ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>E-Mail</label>
                        <p><b><?php echo htmlspecialchars($row["emp_email"]); ?></b></p>
                    </div>
                    
                    <p><a href="index1.php" class="btn btn-primary">Back</a></p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
