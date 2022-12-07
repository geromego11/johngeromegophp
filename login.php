<?php
include_once "db.php";

session_start();

if(isset($_POST['login'])){

	$username = $_POST['username'];
	$password = $_POST['password'];

	if (empty($username)) {
		header("location: index.php?error=User Name is required");
	}else if(empty($password)) {
		header("location: index.php?error=Password is required");
	}else{
		$query = "SELECT * FROM account WHERE username='$username' AND password='$password'";
		$result = mysqli_query($conn,$query);

		if($result) {
			if(mysqli_num_rows($result) == 1) {
				$query = "SELECT emp_id FROM account WHERE username='$username' AND password='$password'";
				$result = mysqli_query($conn,$query);

				while($me = mysqli_fetch_assoc($result)) {
					if($me['emp_id'] == "103") {
						header("location: home.php?admin='$me[emp_id]'");
					}else {
						header("location: home2.php?user='$me[emp_id]'");
					}
				}
			}else{
				header("location: index.php?error=Incorrect User Name or Password");
			}
		}
	}
}else{
	header("location: index.php");
	exit();
}
mysqli_close($conn);
?>