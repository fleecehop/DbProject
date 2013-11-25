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
<h2 class="div-padding">A & G Company</h2>
<title>Manage Promotions</title>
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
<?php include "message.php"?>
<h1 align="center"> 
	
	<form method="POST" action="updatePromotions.php"> 
	<?php
		$_SESSION['promotions'] = true;
		include 'displayInventory.php'; 
	?>
	<div style="float:right; margin-right:10px;"><input type="submit" value="Update Promotions"></div><br><br>
</h1> 
<br> <br> <br>
</body>
</html>

<?php } ?>	

