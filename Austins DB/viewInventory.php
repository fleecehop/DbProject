<?php 

    // Start session if not active
	session_start();
	
	// If not logged in, go to login screen
	if (!isset($_SESSION['username'])) 
	{
		header("Location: index.php");
	}
	// If customer
	else if (intval($_SESSION['privilege']) < 2) 
	{
		header("Location: customerInventory.php");
	} 
	// If staff
	else 
	{
?> 

<html>

    <head>
        
        <!-- Reference stylesheet -->
        <link rel="stylesheet" type="text/css" href="style.css">
        
        <!-- Set title with company name -->
        <h2 class="div-padding">A & G Company</h2>
        
        <!-- Set title for webpage -->
        <title>View Inventory</title>
        
    </head>
    
    <div class="div-padding">  
        
        <!-- Set welcome text for user -->  
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
        	
        	<!-- Show for manager only -->
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
    	<?php 
    	    // Show the inventory
    		$_SESSION['view'] = true;
    		include 'showStock.php'; 
    	?>
    	</h1>
    <br> <br> <br>
    
</html>

<?php } ?>	

