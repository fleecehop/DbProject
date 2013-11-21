<?php 
	session_start();
	if (!isset($_SESSION['privileges'])) {
		header("Location: loginForm.php");
	}
	else if (intval($_SESSION['privileges']) < 2) {
			header("Location: store.php");
	} else {
?> 

<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css">
<h2>The Store</h2>
<title>View Inventory</title>
</head>
<h4 align="right">	
Welcome <?php echo $_SESSION['username'];  ?>
<a href="logout.php"> Log Out </a><br> 
<a href="manageInventory.php">Manage Inventory </a><br>
<a href="pendingOrders.php">Manage Pending Orders </a><br>
<?php if (intval($_SESSION['privileges']) > 2) { ?>
<a href="managePromotions.php">Manage Promotions </a><br>
<a href="salesInfo.php">View Sales Statistics </a><br>
<?php } ?>
</h4>
<body>
<?php include "message.php"?>
<h1 align="center"> 
	<?php 
		$_SESSION['view'] = true;
		include 'displayInventory.php'; 
	?>
	</h1>
<br> <br> <br>
</body>
</html>

<?php } ?>	

