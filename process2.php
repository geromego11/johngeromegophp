<?php

include_once "db.php";

if(isset($_POST['add_product'])){
	$name = $_POST['category'];
	$query = "SELECT cat_name FROM category WHERE cat_name='$name'";
	$res = mysqli_query($conn,$query);
	if($row = mysqli_fetch_assoc($res)) {
		if($row['cat_name'] == $name){
			echo "category already exists...";
		}
	}else{
		$query = "INSERT INTO category (";
		$query .= " cat_name";
		$query .= ") Values (";
		$query .= " '{$_POST['category']}'";
		$query .= ")";

		$result = mysqli_query($conn,$query);

		echo "Added Succesfully";
	}

	$query = "INSERT INTO products (";
	$query .= " name, description, price, quantity";
	$query .= ") Values (";
	$query .= " '{$_POST['prod_name']}', '{$_POST['description']}', '{$_POST['price']}', '{$_POST['quantity']}'";
	$query .= ")";
	$resulta = mysqli_query($conn,$query);

	if($resulta){
		$category = $_POST['category'];
		$product = $_POST['prod_name'];

		$query = "SELECT cat_id FROM category WHERE cat_name='$category'";
		$result = mysqli_query($conn,$query);

		if($me = mysqli_fetch_assoc($result)) {
			$sql = "SELECT prod_id FROM products WHERE name='$product'";
			$res = mysqli_query($conn,$sql);

			if($my = mysqli_fetch_assoc($res)) {
				$query = "UPDATE products SET cat_id='$me[cat_id]' WHERE prod_id='$my[prod_id]'";
				$result = mysqli_query($conn,$query);
			}else {
				echo mysql_error();
			}

			echo "Succesfull Added";
		}
	}
	else{
		echo mysql_error();
	}
}

header("location: home2.php");
?>