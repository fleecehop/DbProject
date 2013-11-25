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
<h2 class="div-padding">A & G Company</h2>
<title>Manage Inventory</title>
</head>
<div class="div-padding">    
    <div class="header-div" style="float:left; font-weight: bold;">
	    Welcome <?php 
    			if (isset($_SESSION['username'])) {
    				echo $_SESSION['username']; 
    				?>!
	</div>
	
	<div class="header-div" style="float:right;">
	    <a href="logout.php" class="menu-option">Log Out </a>
	    <a href="viewInventory.php" class="menu-option">View Inventory </a>
    	<a href="manageInventory.php" class="menu-option">Manage Inventory </a>
    	<a href="pendingOrders.php" class="menu-option">Pending Orders </a>
    	<a href="salesInfo.php" class="menu-option">View Statistics </a>
    	
	</div>
	
	<?php }
	else {} ?>
</div>
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

