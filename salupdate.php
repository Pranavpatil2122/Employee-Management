<?php
session_start();
if (!isset($_SESSION['uname']) || empty($_SESSION['uname'])) {
    header('location: adminlogin.php');
    exit();
}

require_once "dbconnect.php";

$basic_sal = "";
$basic_sal_err = "";

if (isset($_POST["id"]) && !empty($_POST["id"])) {
    $id = $_POST["id"];

    $input_basic_sal = trim($_POST["basic_salary"]);
    if (empty($input_basic_sal)) {
        $basic_sal_err = "Please enter the contact number.";
    } elseif (!ctype_digit($input_basic_sal)) {
        $basic_sal_err = "Please enter a valid positive integer value.";
    } else {
        $basic_sal = $input_basic_sal;
    }

    if (empty($basic_sal_err)) {
        $sql = "UPDATE tblsalary SET basic_salary=? WHERE emp_id=?";
        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "si", $param_basic_sal, $param_id);

            $param_basic_sal = $basic_sal;
            $param_id = $id;

            if (mysqli_stmt_execute($stmt)) {
                header("location: sal.php");
                exit();
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        mysqli_stmt_close($stmt);
    }

    mysqli_close($conn);
} else {
    if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
        $id = trim($_GET["id"]);

        $sql = "SELECT * FROM tblsalary WHERE emp_id = ?";
        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "i", $param_id);

            $param_id = $id;

            if (mysqli_stmt_execute($stmt)) {
                $result = mysqli_stmt_get_result($stmt);

                if (mysqli_num_rows($result) == 1) {
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    $basic_sal = $row["basic_salary"];
                } else {
                    header("location: error.php");
                    exit();
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    } else {
        header("location: error.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
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
                    <h2 class="mt-5">Update Salary</h2>
                    <p>Please edit the input values and submit to update the employee record.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group">
                            <label>Basic salary</label>
                            <input type="text" name="basic_salary" class="form-control <?php echo (!empty($basic_sal_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $basic_sal; ?>">
                            <span class="invalid-feedback"><?php echo $contact_no_err;?></span>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index1.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
