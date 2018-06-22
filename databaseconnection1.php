<?php

$username="root";
$password="";
$database="ncess_dirnet";
$conn=mysqli_connect("localhost",$username,$password);
mysqli_select_db($conn,$database);
return $conn;
?>
