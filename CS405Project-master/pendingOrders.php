<?php 
	session_start();
	if (!isset($_SESSION['privileges'])) {
		header("Location: loginForm.php");
	} else if (intval($_SESSION['privileges']) < 2) {
		header("Location: store.php");
	} else {
?> 

<html>
<head>
<h2 class="div-padding">A & G Company</h2>
<title>Manage Pending Orders</title>
</head>
<h4 align="right">	
<link rel="stylesheet" type="text/css" href="style.css">
Welcome <?php echo $_SESSION['username'];  ?>
<a href="logout.php"> Log Out </a><br> 
<a href="viewInventory.php">View Inventory</a><br>
<a href="manageInventory.php">Manage Inventory</a><br>
<?php if (intval($_SESSION['privileges']) > 2) { ?>
<a href="managePromotions.php">Manage Promotions</a><br>
<a href="salesInfo.php">View Sales Statistics</a><br>
<?php } ?>
</h4>
<body>
	<?php include "message.php"?> 
	<h1 align="center">
	<?php include 'showPendingOrders.php'; ?>
	</h1>
<br> <br> <br>
</form> 
</body>
</html>

<?php } ?>	

