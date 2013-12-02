<?php 

    // Start the session if not active
	session_start();
	
	// If not logged in, go to login screen
	if (!isset($_SESSION['username'])) 
	{
		header("Location: index.php");
	}
	// If not manager, go to staff page
	else if (intval($_SESSION['privilege']) < 3) 
	{
			header("Location: viewInventory.php");
	} 
	// If user is a manager
	else 
	{
?> 

<html>
    <head>
        
        <!-- Reference the stylesheet -->
        <link rel="stylesheet" type="text/css" href="style.css">
        
        <!-- Set title bar with company name -->
        <h2 class="div-padding">A & G Company</h2>
        
        <!-- Set the title of the webpage -->
        <title>Manage Promotions</title>
    </head>
    
    <div class="div-padding">    
        
        <!-- Set welcome text for manager -->
        <div class="header-div" style="float:left; font-weight: bold;">
    	    
    	    Welcome 
    	    
    	    <?php 
        			if (isset($_SESSION['username'])) 
        			{
        				echo $_SESSION['username']; 
        				?>!
    	</div>
	
	    <!-- Set the manager's navigation bar -->
    	<div class="header-div" style="float:right;">
    	    <a href="logout.php" class="menu-option">Log Out </a>
    	    <a href="viewInventory.php" class="menu-option">View Inventory </a>
        	<a href="manageStock.php" class="menu-option">Edit Inventory </a>
        	<a href="pendingOrders.php" class="menu-option">Pending Orders </a>
        	
        	<!-- Make sure only the manager can see these two -->
        	<?php if (intval($_SESSION['privilege']) == 3) { ?>
    		    <a href="managePromotions.php" class="menu-option">Promotions </a>
        		<a href="statistics.php" class="menu-option">Stats </a>
        	<?php } ?>
        	
    	</div>
	
    	<?php } ?>
    	
    </div>
    
    <!-- Display message if one exists -->
    <?php include "message.php" ?>
    
    <h1 align="center"> 
	
	    <!-- Create form to update promotion values -->
    	<form method="POST" action="updatePromotions.php"> 
    	    <?php
        		$_SESSION['promotions'] = true;
        		include 'showStock.php'; 
        	?>
        
        <!-- Display button to signal form action -->	
    	<div style="float:right; margin-right:10px;">
    	    <input type="submit" value="Update Promotions">
    	</div><br><br>
    	
    </h1> 
    <br> <br> <br>
    </body>
    
</html>

<?php } ?>	

