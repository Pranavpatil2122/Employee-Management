<?php
session_start();
if(isset($_SESSION['uname'])=="") {
  header('location: adminlogin.php');
}
?>
<?php
// Include config file
require_once "dbconnect.php";

// Define variables and initialize with empty values
$first_name = $last_name = $address = $department = $contact_no = $emp_email = $emp_password = "";
$first_name_err = $last_name_err = $address_err = $department_err = $contact_no_err = $emp_email_err = $emp_password_err = "";

// Processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];

    // Validate first name
    $input_first_name = trim($_POST["first_name"]);
    if(empty($input_first_name)){
        $first_name_err = "Please enter a first name.";
    } elseif(!filter_var($input_first_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $first_name_err = "Please enter a valid first name.";
    } else{
        $first_name = $input_first_name;
    }

    // Validate last name
    $input_last_name = trim($_POST["last_name"]);
    if(empty($input_last_name)){
        $last_name_err = "Please enter a last name.";
    } elseif(!filter_var($input_last_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $last_name_err = "Please enter a valid last name.";
    } else{
        $last_name = $input_last_name;
    }

    // Validate address
    $input_address = trim($_POST["address"]);
    if(empty($input_address)){
        $address_err = "Please enter an address.";     
    } else{
        $address = $input_address;
    }

    // Validate department
    $input_department = trim($_POST["department"]);
    if(empty($input_department)){
        $department_err = "Please enter a department.";     
    } else{
        $department = $input_department;
    }

    // Validate contact number
    $input_contact_no = trim($_POST["contact_no"]);
    if(empty($input_contact_no)){
        $contact_no_err = "Please enter the contact number.";     
    } elseif(!ctype_digit($input_contact_no)){
        $contact_no_err = "Please enter a valid positive integer value.";
    } else{
        $contact_no = $input_contact_no;
    }

    // Validate email
    $input_emp_email = trim($_POST["emp_email"]);
    if(empty($input_emp_email)){
        $emp_email_err = "Please enter an email address.";     
    } elseif(!filter_var($input_emp_email, FILTER_VALIDATE_EMAIL)){
        $emp_email_err = "Please enter a valid email address.";
    } else{
        $emp_email = $input_emp_email;
    }

    // Validate password
    $input_emp_password = trim($_POST["emp_password"]);
    if(empty($input_emp_password)){
        $emp_password_err = "Please enter a password.";     
    } else{
        $emp_password = $input_emp_password;
    }

    // Check input errors before inserting in database
    if(empty($first_name_err) && empty($last_name_err) && empty($address_err) && empty($department_err) && empty($contact_no_err) && empty($emp_email_err) && empty($emp_password_err)){
        // Prepare an update statement
        $sql = "UPDATE tblemp SET first_name=?, last_name=?, emp_address=?, department=?, contact_no=?, emp_email=?, emp_password=? WHERE emp_id=?";

        if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssssissi", $param_first_name, $param_last_name, $param_address, $param_department, $param_contact_no, $param_emp_email, $param_emp_password, $param_id);

            // Set parameters
            $param_first_name = $first_name;
            $param_last_name = $last_name;
            $param_address = $address;
            $param_department = $department;
            $param_contact_no = $contact_no;
            $param_emp_email = $emp_email;
            $param_emp_password = $emp_password;
            $param_id = $id;

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records updated successfully. Redirect to landing page
                header("location: index1.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }

    // Close connection
    mysqli_close($conn);
} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // Get URL parameter
        $id =  trim($_GET["id"]);

        // Prepare a select statement
        $sql = "SELECT * FROM tblemp WHERE emp_id = ?";
        if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_id);

            // Set parameters
            $param_id = $id;

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);

                if(mysqli_num_rows($result) == 1){
                    /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use a while loop */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

                    // Retrieve individual field value
                    $first_name = $row["first_name"];
                    $last_name = $row["last_name"];
                    $address = $row["emp_address"];
                    $department = $row["department"];
                    $contact_no = $row["contact_no"];
                    $emp_email = $row["emp_email"];
                    $emp_password = $row["emp_password"];
                } else{
                    // URL doesn't contain a valid id. Redirect to the error page
                    header("location: error.php");
                    exit();
                }

            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);

        // Close connection
        mysqli_close($conn);
    }  else{
        // URL doesn't contain an id parameter. Redirect to the error page
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
        .wrapper{
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
                    <h2 class="mt-5">Update Record</h2>
                    <p>Please edit the input values and submit to update the employee record.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group">
                            <label>First Name</label>
                            <input type="text" name="first_name" class="form-control <?php echo (!empty($first_name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $first_name; ?>">
                            <span class="invalid-feedback"><?php echo $first_name_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Last Name</label>
                            <input type="text" name="last_name" class="form-control <?php echo (!empty($last_name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $last_name; ?>">
                            <span class="invalid-feedback"><?php echo $last_name_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                            <textarea name="address" class="form-control <?php echo (!empty($address_err)) ? 'is-invalid' : ''; ?>"><?php echo $address; ?></textarea>
                            <span class="invalid-feedback"><?php echo $address_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Department</label>
                            <input type="text" name="department" class="form-control <?php echo (!empty($department_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $department; ?>">
                            <span class="invalid-feedback"><?php echo $department_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Contact</label>
                            <input type="text" name="contact_no" class="form-control <?php echo (!empty($contact_no_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $contact_no; ?>">
                            <span class="invalid-feedback"><?php echo $contact_no_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" name="emp_email" class="form-control <?php echo (!empty($emp_email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $emp_email; ?>">
                            <span class="invalid-feedback"><?php echo $emp_email_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="emp_password" class="form-control <?php echo (!empty($emp_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $emp_password; ?>">
                            <span class="invalid-feedback"><?php echo $emp_password_err;?></span>
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
