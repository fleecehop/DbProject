<?php 

	session_start();
	
	if (!isset($_SESSION['privilege'])) 
	{
		header("Location: index.php");
	}
	else if (intval($_SESSION['privilege']) < 2) 
	{
			header("Location: customerInventory.php");
	} 
	else 
	{
?> 

<html>

    <head>
        <link rel="stylesheet" type="text/css" href="style.css">
        <h2 class="div-padding">A & G Company</h2>
        <title>View Item</title>
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
    	    <a href="viewInventory.php" class="menu-option">View Item </a>
        	<a href="manageStock.php" class="menu-option">Edit Item </a>
        	<a href="pendingOrders.php" class="menu-option">Pending Orders </a>
        	
        	<?php if (intval($_SESSION['privilege']) == 3) { ?>
    		    <a href="managePromotions.php" class="menu-option">Promotions </a>
        		<a href="statistics.php" class="menu-option">Stats </a>
    		<?php } ?>
    	
    	</div>
	
    	<?php } ?>
    	
    </div>
    
    <?php include "message.php"?>
    
    <h1 align="center"> 
    	<?php 
    		$_SESSION['view'] = true;
    		include 'showStock.php'; 
    	?>
    	</h1>
    <br> <br> <br>
    
</html>

<?php } ?>	

