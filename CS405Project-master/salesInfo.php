<?php 
	session_start();
	if (!isset($_SESSION['privileges'])) {
		header("Location: loginForm.php");
	}
	else if (intval($_SESSION['privileges']) < 3) {
		header("Location: store.php");
	} else {
?> 

<html>
<head>
<h2>The Store</h2>
<link rel="stylesheet" type="text/css" href="style.css">
<style>
div.box
{
width:220px;
padding:10px;
border:5px solid gray;
margin-left:auto;
margin-right:auto;
}
</style>
<title>Sales Statistics</title>
</head>
<h4 align="right">
Welcome <?php echo $_SESSION['username'];  ?>
<a href="logout.php"> Log Out</a><br> 
<a href="viewInventory.php">View Inventory</a><br>
<a href="manageInventory.php">Manage Inventory</a><br>
<a href="pendingOrders.php">Manage Pending Orders</a><br>
<a href="managePromotions.php">Manage Promotions</a><br>
</h4>
<body> 
<br><br>
		<div class="box">
		<form method="POST" action="salesInfo.php"> 
			Time Frame: <select name="time">
			<option value="week">week</option>
			<option value="month">month</option>
			<option value = "year">year</option>
			<option value="all">all</option>
		</select>
	<input type="submit" value="View Sales Statistics">
	</form>
	</div>
	<br>
<h3 align="center">
<br>
	<?php include 'showSalesInfo.php' ?>
</h3>
</form> 
</body>
</html>

<?php } ?>	

