<?php 
	session_start();
	if (!isset($_SESSION['privileges'])) {
		header("Location: loginForm.php");
	}
	else if (intval($_SESSION['privileges']) < 3) {
			header("Location: viewInventory.php");
	} else {
?> 

<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css">
<h2>The Store</h2>
<title>Manage Promotions</title>
</head>
<h4 align="right">	
	Welcome <?php echo $_SESSION['username'];  ?>
	<a href="logout.php"> Log Out </a><br> 
	<a href="viewInventory.php">View Inventory </a><br>
	<a href="manageInventory.php">Manage Inventory </a><br>
	<a href="pendingOrders.php">Manage Pending Orders </a><br>
	<a href="salesInfo.php">View Sales Statistics </a><br>
</h4>
<body>
<?php include "message.php"?>
<h1 align="center"> 
	
	<form method="POST" action="updatePromotions.php"> 
	<?php
		$_SESSION['promotions'] = true;
		include 'displayInventory.php'; 
	?>
	<input type="submit" value="Update Promotions"><br><br>
</h1> 
<br> <br> <br>
</body>
</html>

<?php } ?>	

