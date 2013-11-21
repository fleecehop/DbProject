<?php 
	session_start();
	if (isset($_SESSION['privileges'])) {
		if (intval($_SESSION['privileges']) > 1) {
			header("Location: inventory.php");
		}
	}
?>



<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css">
<h2>The Store</h2>
<title>Store</title>
</head>
<h4 align="right">	
	Welcome <?php 
			if (isset($_SESSION['username'])) {
				echo $_SESSION['username']; 
				?>
	<a href="logout.php">Log Out </a><br> 
	<a href="shoppingBasket.php">View Shopping Basket </a><br>
	<a href="viewOrderHistory.php">View Order History </a><br>
	<?php }
	else {
		echo "Guest";
		?><br>
			<a href="loginForm.php">Log In </a><br> 	
			<a href="registrationForm.php">Register As New User </a> 
		<?php } ?><br>

</h4>
<body>
<?php include "message.php"?>
<h1 align="center">
<form method="POST" action="addToShoppingBasket.php"> 
	<?php include 'displayInventory.php'; ?>
	<input type="submit" value="Update">
</form>
</h1>
</body>
</html>

	
 	
