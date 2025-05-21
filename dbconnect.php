<?php
$conn=new mysqli("localhost","root","admin","dbpay2");
if($conn-> connect_error)
{
    die("connection failed".$conn-> connect_error);
}
?>