<?php
$conn = mysqli_connect('localhost', 'root', '', 'advb');

if(mysqli_connect_errno()){
	
	echo "Failed to connect to database...";
	echo mysqli_connect_error();
	exit();
}
?>