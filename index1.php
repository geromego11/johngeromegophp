<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>LOGIN</title>
	<link rel="stylesheet" type="text/css" href="style1.css">
</head>
<body>
	<form method="POST" action="login.php">
		<h2>LOGIN</h2>
		<?php if (isset($_GET['error'])) { ?>
			<p class="error"><?php echo $_GET['error']; ?></p>
		<?php } ?>
			
		<label>User Name</label>
		<input type="text" name="username" placeholder="User Name">
		<br>

		<label>Password</label>
		<input type="password" name="password" placeholder="Password">
		<br>

		<button type="submit" name="login"><b>LOGIN</b></button>
	</form>
</body>
</html>