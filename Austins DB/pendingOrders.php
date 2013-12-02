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
        	<a href="manageStock.php" class="menu-option">Edit Inventory </a>
        	<a href="pendingOrders.php" class="menu-option">Pending Orders </a>
        	
        	<?php if (intval($_SESSION['privilege']) == 3) { ?>
    		    <a href="managePromotions.php" class="menu-option">Promotions </a>
        		<a href="statistics.php" class="menu-option">Stats </a>
        	<?php } ?>
    	</div>
	
    	<?php } ?>
    	
    </div>
    
    <body>
    	<?php include "message.php"?> 
    	<div align="center">
    	    <?php include 'showPendingOrders.php'; ?>
    	</div>
    <br> <br> <br>
    
    </body>
    
</html>

<?php } ?>	

