<!--user login-->

<!DOCTYPE html>

<html lang="en">

<head>

</head>

<body>

<form name="frmlogin" action="login.php" method="post">

<table border="1" cellspacing="10" cellpadding="10">
<tr>
<th>Username:</th>
<td><input type="text"  name ="txtuname"  size="22px"  ></td>
</tr>
<tr>
<th>Password:</th>
<td><input type="password"  name ="txtpass"  size="22px"  ></td>
</tr>
<tr>
<th> </th>
<td><input type="submit"  name ="btnlogin"  size="22px" value="Login" ></td>
</tr>

</table>


<?php

 session_start();
 
 include ('dbconnect.php');

 if(isset($_POST['btnlogin']))
 {
   
 $uname=$_POST['txtuname'];
 $passw=$_POST['txtpass'];

 
 $sql = "select user_name ,user_password from tbladmin where user_name='$uname' and user_password='$passw'";
 
 $result = mysqli_query($conn,$sql);
 
 $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
 

$count = mysqli_num_rows($result);

    if($count == 1)
	{  
            echo "<h1><center> Login successful </center></h1>";  
			$_SESSION['uname']=$uname;
			//header("location:empcurdopa.php");
        }  
        else
		{  
            echo "<h1><center> Login failed. Invalid username or password.</center></h1>";  
        }     
 }


?>




</body>
</html>
