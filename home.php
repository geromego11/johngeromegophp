<?php
include_once "db.php";
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>HOME</title>
	<link rel="stylesheet" type="text/css" href="style2.css">
</head>
<body>

	<?php
	$full_name = $age = $phone = $email = $job_position = "";
	$action = "add_employee";
	$btn_value = "Add Employee";

	if(isset($_GET['id'])) {
		if(isset($_GET['edit'])) {
			$query = "SELECT * FROM employees WHERE emp_id= ". $_GET['id'];
			$result = mysqli_query($conn,$query);
			if($result) {
				if($row = mysqli_fetch_assoc($result)) {
					$emp_id = $row['emp_id'];
					$full_name = $row['full_name'];
					$age = $row['age'];
					$phone = $row['phone'];
					$email = $row['email'];
					$job_position = $row['job_position'];
					$action = "update_employee";
					$btn_value = "Update Employee";
				}
			}
		}
	}

	if(isset($_POST['update_employee'])){
		$user = $_GET['id'];
		$full_name = $_POST['full_name'];
		$age = $_POST['age'];
		$phone = $_POST['phone'];
		$email = $_POST['email'];
		$job_position = $_POST['job_position'];

		$query = "UPDATE employees SET ";
		$query .= "full_name = '{$full_name}', age = '{$age}', phone = '{$phone}', email = '{$email}', job_position = '{$job_position}'";
		$query .= " WHERE emp_id = '{$user}'";

		$result = mysqli_query($conn,$query);
		echo mysql_error();
		if($result) {
			echo "Succesfully added";
		}
		if(!$result) {
			echo mysqli_error();
		}
	}
	?>
	<form method="POST" action="process.php">
		<h2>New Employee?</h2>
		<label>Employee Full Name:</label>
		<input type="text" name="full_name" value="<?= $full_name ?>">
		<br>
		<br>

		<label>Employee Age:</label>
		<input type="number" name="age" value="<?= $age ?>">
		<br>
		<br>

		<label>Employee Phone Number:</label>
		<input type="number" name="phone" value="<?= $phone ?>">
		<br>
		<br>

		<label>Employee Email:</label>
		<input type="text" name="email" value="<?= $email ?>">
		<br>
		<br>

		<label>Employee Job Position:</label>
		<input type="text" name="job_position" value="<?= $job_position ?>">
		<br>
		<br>

		<label>User Name:</label>
		<input type="text" name="username">
		<br>
		<br>

		<label>Password:</label>
		<input type="text" name="password">
		<br>
		<br>

		<input type="submit" name="<?= $action ?>" value="<?= $btn_value ?>">
	</form>

	<h2>Retrieving Data...</h2>
	<table border="1">
		<th>Employee_id</th>
		<th>Full Name</th>
		<th>Age</th>
		<th>Phone</th>
		<th>Email</th>
		<th>Job Position</th>
		<th>Action</th>
	<?php
		$query = "SELECT * from employees";
		$result = mysqli_query($conn,$query);

		if($result){
			while($row = mysqli_fetch_assoc($result)){
				echo "<tr>";
					echo "<td>$row[emp_id]</td>";
					echo "<td>$row[full_name]</td>";
					echo "<td>$row[age]</td>";
					echo "<td>$row[phone]</td>";
					echo "<td>$row[email]</td>";
					echo "<td>$row[job_position]</td>";
					echo "<td><a href='home.php?id=$row[emp_id]&edit=1'>Edit</a></td>";
				echo "</tr>";
			}
			mysqli_free_result($result);
		}
		else{
			echo "Failed query";
		}
	?>
	</table>
</body>
</html>