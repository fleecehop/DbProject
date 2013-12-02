<?php 

    // Start the session if not active
	session_start();
	
	// If no user is logged in, go to login screen
	if (!isset($_SESSION['username'])) 
	{
		header("Location: index.php");
	} 
	// If the user is a customer, go to customer page
	else if (intval($_SESSION['privilege']) < 2) 
	{
		header("Location: customerInventory.php");
	} 
	// If the user is staff
	else 
	{
?> 

<html>

    <head>
        
        <!-- Reference stylesheet -->
        <link rel="stylesheet" type="text/css" href="style.css">
        
        <!-- Set title bar with company name -->
        <h2 class="div-padding">A & G Company</h2>
        
        <!-- Set title of webpage -->
        <title>Manage Pending Orders</title>
        
    </head>
    
    <div class="div-padding"> 
         
        <!-- Set welcome text for staff -->   
        <div class="header-div" style="float:left; font-weight: bold;">
    	    
    	    Welcome 
    	    
    	    <?php 
        			if (isset($_SESSION['username'])) 
        			{
        				echo $_SESSION['username']; 
        				?>!
    	</div>
	
	    <!-- Set navigation bar for staff -->
    	<div class="header-div" style="float:right;">
    	    <a href="logout.php" class="menu-option">Log Out </a>
    	    <a href="viewInventory.php" class="menu-option">View Inventory </a>
        	<a href="manageStock.php" class="menu-option">Edit Inventory </a>
        	<a href="pendingOrders.php" class="menu-option">Pending Orders </a>
        	
        	<!-- Show buttons for manager only -->
        	<?php if (intval($_SESSION['privilege']) == 3) { ?>
    		    <a href="managePromotions.php" class="menu-option">Promotions </a>
        		<a href="statistics.php" class="menu-option">Stats </a>
        	<?php } ?>
        	
    	</div>
	
    	<?php } ?>
    	
    </div>
    
    <body>
        
        <!-- Display message if one exists -->
    	<?php include "message.php" ?> 
    	
    	<!-- Call code to display orders -->
    	<div align="center">
    	    <?php include 'showPendingOrders.php'; ?>
    	</div>
    	
    <br> <br> <br>
    
    </body>
    
</html>

<?php } ?>	

