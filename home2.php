<?php
include_once "db.php";
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>HOME2</title>
	<link rel="stylesheet" type="text/css" href="style2.css">
</head>
<body>
	<?php if (isset($_GET['user'])) { ?>
		<p class="user"><?php echo $_GET['user']; ?></p>
	<?php } ?>
	<?php
	$category = $prod_name = $description = $price = $quantity = "";
	$action = "add_product";
	$value = "Add Product";
	$head = "process2.php";

	if(isset($_GET['me'])) {
		if(isset($_GET['edit'])) {
			$query = "SELECT * FROM products NATURAL JOIN category WHERE prod_id= ". $_GET['me'];
			$result = mysqli_query($conn,$query);
			if($result) {
				if($row = mysqli_fetch_assoc($result)) {
					$id = $row['prod_id'];
					$category = $row['cat_name'];
					$prod_name = $row['name'];
					$description = $row['description'];
					$price = $row['price'];
					$quantity = $row['quantity'];
					$action = "update_product";
					$value = "Update Product";
					$head = "home2.php?me='$id'&edit=1";
				}
			}
		}
		if(isset($_GET['delete'])) {
			$query = "DELETE FROM products WHERE prod_id= ". $_GET['me'];
			$result = mysqli_query($conn,$query);
			if($result) {
				echo "Succesfully Deleted...";
				header("location: home2.php");
			}
			else{
			echo mysql_error();
			}
		}
	}

	if(isset($_POST['update_product'])){
		$query = "SELECT cat_id FROM products WHERE prod_id= {$id}";
		$result = mysqli_query($conn,$query);
		$user = mysqli_fetch_assoc($result);

		$category = $_POST['category'];
		$prod_name = $_POST['prod_name'];
		$description = $_POST['description'];
		$price = $_POST['price'];
		$quantity = $_POST['quantity'];

		$query = "UPDATE category SET ";
		$query .= "cat_name = '{$category}'";
		$query .= " WHERE cat_id ='{$user['cat_id']}'";
		$result = mysqli_query($conn,$query);

		$query = "SELECT prod_id FROM products WHERE prod_id= {$id}";
		$result = mysqli_query($conn,$query);
		$user = mysqli_fetch_assoc($result);

		$query = "UPDATE products SET ";
		$query .= "name = '{$prod_name}', description = '{$description}', price = '{$price}', quantity = '{$quantity}'";
		$query .= " WHERE prod_id = '{$user['prod_id']}'";
		$result = mysqli_query($conn,$query);

		if($result) {
			echo "Succesfully added";
		}
		else{
			echo mysql_error();
		}
		$category = $prod_name = $description = $price = $quantity = "";
		header("location: home2.php");
	}
	?>

	<form method="POST" action="<?= $head ?>">
		<h2>New Product?</h2>
		<label>Product Category:</label>
		<input type="text" name="category" value="<?= $category ?>">
		<br>
		<br>

		<label>Product Name:</label>
		<input type="text" name="prod_name" value="<?= $prod_name ?>">
		<br>
		<br>

		<label>Product Description:</label>
		<input type="text" name="description" value="<?= $description ?>">
		<br>
		<br>

		<label>Product Price:</label>
		<input type="number" name="price" value="<?= $price ?>">
		<br>
		<br>

		<label>Product Quantity:</label>
		<input type="number" name="quantity" value="<?= $quantity ?>">
		<br>
		<br>

		<input type="submit" name="<?= $action ?>"  value="<?= $value ?>">
	</form>

	<h2>Products</h2>
	<table>
		<th>Category</th>
		<th>Product ID</th>
		<th>Product Name</th>
		<th>Description</th>
		<th>Price</th>
		<th>Quantity</th>
		<th>Action</th>
	<?php
		$query = "SELECT * FROM products";
		$result = mysqli_query($conn,$query);

		if($result){
			while($row = mysqli_fetch_assoc($result)) {
				echo "<tr>";
				$sql = "SELECT cat_name FROM category WHERE cat_id='$row[cat_id]'";
				$res = mysqli_query($conn,$sql);
				$row1 = mysqli_fetch_assoc($res);

				echo "<td>$row1[cat_name]</td>";
				echo "<td>$row[prod_id]</td>";
				echo "<td>$row[name]</td>";
				echo "<td>$row[description]</td>";
				echo "<td>$row[price]</td>";
				echo "<td>$row[quantity]</td>";
				echo "<td><a href='home2.php?me=$row[prod_id]&edit=1'>Edit</a> | <a href='home2.php?me=$row[prod_id]&delete=1'>Delete</a></td>";
				echo "</tr>";
			}mysqli_free_result($result);
		}
		else{
			echo "Failed query";
		}
	?>
	</table>
	<br>
	<br>
	<br>

	<form method="POST" action="order.php">
		<h2>Add Order</h2>
		<label>Customer Name</label>
		<input type="text" name="fullname" placeholder="fullname">
		<br>

		<label>Contact Number</label>
		<input type="text" name="phone" placeholder="phone">
		<br>

		<label>Address</label>
		<input type="text" name="address" placeholder="address">
		<br>

		<label>Product</label>
		<input type="text" name="product" placeholder="product">
		<br>

		<label>Quantity</label>
		<input type="number" name="quantity" placeholder="quantity">
		<br>

		<label>Mode of Payment</label>
		<input type="text" name="mode" placeholder="mode">
		<br>

		<label>Order Date</label>
		<input type="date" name="date" placeholder="date">
		<br>

		<input type="submit" name="add_order" value="Add Order">
	</form>
	<h2>Orders</h2>
	<table>
		<th>Customer Name</th>
		<th>Phone</th>
		<th>Address</th>
		<th>Product</th>
		<th>Quantity</th>
		<th>Mode of Payment</th>
		<th>Order Date</th>
		<th>Action</th>
	<?php
		$query = "SELECT * FROM orders";
		$result = mysqli_query($conn,$query);

		if($result){
			while($row = mysqli_fetch_assoc($result)) {
				echo "<tr>";
				echo "<td>$row[customer_name]</td>";
				echo "<td>$row[phone]</td>";
				echo "<td>$row[address]</td>";

				$sql = "SELECT name FROM products WHERE prod_id='$row[prod_id]'";
				$res = mysqli_query($conn,$sql);
				$row1 = mysqli_fetch_assoc($res);

				echo "<td>$row1[name]</td>";
				echo "<td>$row[quantity]</td>";

				$sql = "SELECT payment_type FROM payments WHERE payment_id='$row[payment_id]'";
				$res = mysqli_query($conn,$sql);
				$row2 = mysqli_fetch_assoc($res);

				echo "<td>$row2[payment_type]</td>";
				echo "<td>$row[order_date]</td>";
				echo "<td><a href='home2.php?he=$row[order_id]&edit=1'>Edit</a> | <a href='home2.php?me=$row[order_id]&delete=1'>Delete</a></td>";
				echo "</tr>";
			}mysqli_free_result($result);
		}
		else{
			echo "Failed query";
		}
	?>
</body>
</html>