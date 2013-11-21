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
<link rel="stylesheet" type="text/css" href="style.css">
<h2>The Store</h2>
<title>Manage Inventory</title>
</head>

<h4 align="right">	
Welcome <?php echo $_SESSION['username'];  ?>
<a href="logout.php"> Log Out </a><br> 
<a href="viewInventory.php">View Inventory  </a><br>
<a href="pendingOrders.php">Manage Pending Orders </a><br>
<?php if (intval($_SESSION['privileges']) > 2) { ?>
<a href="managePromotions.php">Manage Promotions </a><br>
<a href="salesInfo.php">View Sales Statistics </a><br>
<?php } ?>
</h4>
<body>
<?php include "message.php"?>
<h1 align="center"> 
<form method="POST" action="updateInventory.php"> 
	<?php include 'displayInventory.php'; ?>
	<input type="submit" value="Update">
</form><br>
</h1>
<br><br> 

<div align="center"><b>Add Item to Inventory</b></div>
<div class="box">
<form method="POST" action="addInventory.php"> 
	Name*: <input type="text" name="name"><br>
	Description*: <input type="text" name="description"><br>
	Type*: <select name="type">
			<option value="toy">toy</option>
			<option value = "game">game</option>
			</select><br>
	Amount: <input type="text" name="amount"><br>
	Price: <input type="text" name="price"><br>
	<input type="submit" value="Add Item to Store">
</form> 
</div>
</body>
</html>

<?php } ?>	

