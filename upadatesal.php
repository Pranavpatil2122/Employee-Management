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
$contact_no = "";
$contact_no_err = "";

// Processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];
    // Validate contact number
    $input_contact_no = trim($_POST["contact_no"]);
    if(empty($input_contact_no)){
        $contact_no_err = "Please enter the contact number.";     
    } elseif(!ctype_digit($input_contact_no)){
        $contact_no_err = "Please enter a valid positive integer value.";
    } else{
        $contact_no = $input_contact_no;
    }


    // Check input errors before inserting in database
    if(empty($contact_no_err)){
        // Prepare an update statement
        $sql = "UPDATE tblemp SET  contact_no=? WHERE emp_id=?";

        if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssssissi", $param_contact_no, $param_id);

            // Set parameters
           
            $param_contact_no = $contact_no;
            
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
                    $contact_no = $row["contact_no"];
                    
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
                            <label>Contact</label>
                            <input type="text" name="contact_no" class="form-control <?php echo (!empty($contact_no_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $contact_no; ?>">
                            <span class="invalid-feedback"><?php echo $contact_no_err;?></span>
                        </div>
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
