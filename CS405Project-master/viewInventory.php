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
<title>View Inventory</title>
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
	<?php 
		$_SESSION['view'] = true;
		include 'displayInventory.php'; 
	?>
	</h1>
<br> <br> <br>
</body>
</html>

<?php } ?>	

