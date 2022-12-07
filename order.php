<?php
include_once "db.php";

session_start();

if(isset($_POST['add_order'])){

	$fullname = $_POST['fullname'];
	$phone = $_POST['phone'];
	$address = $_POST['address'];
	$product = $_POST['product'];
	$quantity = $_POST['quantity'];
	$mode = $_POST['mode'];
	$date = $_POST['date'];

	$query = "SELECT prod_id FROM products WHERE name='$product'";
	$result = mysqli_query($conn,$query);

	if($result) {
		while($row = mysqli_fetch_assoc($result)) {
			$sql = "SELECT payment_id FROM payments WHERE payment_type='$mode'";
			$res = mysqli_query($conn,$sql);
			$row1 = mysqli_fetch_assoc($res);

			$query = "INSERT INTO orders (";
			$query .= " customer_name, phone, address, prod_id, quantity, payment_id, order_date";
			$query .= ") Values (";
			$query .= " '{$fullname}', '{$phone}', '{$address}', '{$row['prod_id']}', '{$quantity}', '{$row1['payment_id']}', '{$order_date}'";
			$query .= ")";
			$result = mysqli_query($conn,$query);

			if($result) {
				echo "Customer Added Succesfully";
				header("location: home2.php");
			}else{
				header("location: home2.php?error=Incorrect Input");
			}
		}
	}
}else{
	header("location: home2.php");
	exit();
}
mysqli_close($conn);
?>
