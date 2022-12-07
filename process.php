<?php

include_once "db.php";

if(isset($_POST['add_employee'])){
	$query = "INSERT INTO employees (";
	$query .= " full_name, age, phone, email, job_position";
	$query .= ") Values (";
	$query .= " '{$_POST['full_name']}', '{$_POST['age']}', '{$_POST['phone']}', '{$_POST['email']}', '{$_POST['job_position']}'";
	$query .= ")";

	$result = mysqli_query($conn,$query);

	$query = "INSERT INTO account (";
	$query .= " username, password";
	$query .= ") Values (";
	$query .= "  '{$_POST['username']}',  '{$_POST['password']}'";
	$query .= ")";

	$resulta = mysqli_query($conn,$query);

	if($result && $resulta){
		$full_name = $_POST['full_name'];
		$password = $_POST['password'];

		$query = "SELECT emp_id FROM employees WHERE full_name='$full_name'";
		$result = mysqli_query($conn,$query);

		if($me = mysqli_fetch_assoc($result)) {
			$sql = "SELECT username FROM account WHERE password='$password'";
			$res = mysqli_query($conn,$sql);

			if($my = mysqli_fetch_assoc($res)) {
				$query = "UPDATE account SET emp_id='$me[emp_id]' WHERE username='$my[username]'";
				$result = mysqli_query($conn,$query);
			}
			echo "Succesfull Added";
		}
	}
	else{
		echo mysql_error();
	}
}

header('location: home.php');
?>