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
<link rel="stylesheet" type="text/css" href="style.css">
<h2 class="div-padding">A & G Company</h2>
<title>Manage Pending Orders</title>
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
    	<a href="managePromotions.php" class="menu-option">Promotions </a>
		<a href="salesInfo.php" class="menu-option">Stats </a>
    	
	</div>
	
	<?php }
	else {} ?>
</div>
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

