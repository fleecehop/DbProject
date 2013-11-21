<?php 
	session_start();
	if (!isset($_SESSION['privileges'])) {
		header("Location: loginForm.php");
	}
	else if (intval($_SESSION['privileges']) > 1) {
			header("Location: viewInventory.php");
	} else {
?> 

<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css">
<h2>The Store</h2>
<title>Order History</title>
</head>
<h4 align="right">	
Welcome <?php echo $_SESSION['username'];  ?>
<a href="logout.php"> Log Out </a><br> 
<a href="shoppingBasket.php">Shopping Basket</a><br>
<a href="store.php">Return to Store</a><br>
</h4>
<body>
<?php include "message.php"?>
<h3 align="center"> 
	<?php 
		include 'showCustomerOrders.php'; 
	?>
	</h3>
<br> <br> <br>
</body>
</html>

<?php } ?>	

