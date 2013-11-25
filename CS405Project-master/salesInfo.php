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
<h2 class="div-padding">A & G Company</h2>
<link rel="stylesheet" type="text/css" href="style.css">

<title>Sales Statistics</title>
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
    	<a href="manageInventory.php" class="menu-option">Edit Inventory </a>
    	<a href="pendingOrders.php" class="menu-option">Pending Orders </a>
    	<?php if (intval($_SESSION['privileges']) == 3) { ?>
		<a href="managePromotions.php" class="menu-option">Promotions </a>
		<a href="salesInfo.php" class="menu-option">Stats </a>
    	<?php } ?>
	</div>
	
	<?php }
	else {} ?>
</div>
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

