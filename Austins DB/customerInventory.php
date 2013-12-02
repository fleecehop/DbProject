<?php 

    // Start the session if not started
	session_start();
	
	// If a user is logged in
	if (isset($_SESSION['username'])) 
	{
	    // If the user is staff, redirect
		if (intval($_SESSION['privilege']) > 1) 
		{
			header("Location: viewInventory.php");
		}
	}
?>

<html>
    <head>
        
        <!-- Reference stylesheet -->
        <link rel="stylesheet" type="text/css" href="style.css">
        
        <!-- Set the title bar with the company name -->
        <h2 class="div-padding">A & G Company</h2>
        
        <!-- Set the page's title -->
        <title>A & G Company</title>
    </head>
    
    <div class="div-padding">  
        
        <!-- Set the user's name to show -->  
        <div class="header-div" style="float:left; font-weight: bold;">
            
    	    Welcome 
    	    
    	    <?php 
    	            // If a user is logged in
        			if (isset($_SESSION['username'])) 
        			{
        				echo $_SESSION['username']; 
        				?>!
    	</div>
	
	    <!-- Set the navigation styling and buttons -->
    	<div class="header-div" style="float:right;">
    	    <a href="logout.php" class="menu-option">Log Out </a>
    	    <a href="shoppingBasket.php" class="menu-option">Shopping Basket </a>
        	<a href="customerOrders.php" class="menu-option">Order History </a>
    	
    	</div>
	
    	<?php } ?><br>
    	
    </div>
    
    <body>
        <!-- Show a message if one exists -->
        <?php include "message.php" ?>

        <div align="center" class="inv-box">
            
            <!-- Create form to order items -->
            <form method="POST" action="addToShoppingBasket.php"> 
                
                <!-- call code to display the inventory -->
            	<?php include 'showStock.php'; ?>
            	
            	<!-- display a submit button -->
            	<div align="right" style="margin-right:7.5%;">
            	    <input type="submit" value="Add To Cart">
            	</div>
            	
            </form>
            <br>
        </div>
        
    </body>
    
</html>