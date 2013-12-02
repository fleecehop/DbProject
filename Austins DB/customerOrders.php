<?php 

    // Start session if not active
	session_start();
	
	// If no user is logged in, go to login screen
	if (!isset($_SESSION['username'])) 
	{
		header("Location: index.php");
	}
	// If the user is staff, go to staff page
	else if (intval($_SESSION['privilege']) > 1) 
	{
		header("Location: viewInventory.php");
	} 
	// If the user is a customer
	else 
	{
?> 

<html>
    <head>
        
        <!-- Reference the stylesheet -->
        <link rel="stylesheet" type="text/css" href="style.css">
        
        <!-- Set title bar with company name -->
        <h2 class="div-padding">A & G Company</h2>
        
        <!-- Set title for webpage -->
        <title>Order History</title>
        
    </head>
    
    <div class="div-padding">    
        
        <!-- Set welcome text for user -->
        <div class="header-div" style="float:left; font-weight: bold;">
    	    
    	    Welcome 
    	    
    	    <?php 
    	            // If the user is logged in
        			if (isset($_SESSION['username'])) 
        			{
        				echo $_SESSION['username']; 
        				?>!
    	</div>
	
	    <!-- Set navigation bar for customer -->
    	<div class="header-div" style="float:right;">
    	    <a href="logout.php" class="menu-option">Log Out </a>
    	    <a href="shoppingBasket.php" class="menu-option">Shopping Basket</a>
    	    <a href="customerInventory.php" class="menu-option">Return To Store </a>
    	
    	</div>
	
    	<?php } ?>
    	
    	<br>
    </div>
    
    <body>
        
        <!-- Show message if one exists -->
        <?php include "message.php" ?>
        
        <!-- Display the customer's orders -->
        <div align="center"> 
        	<?php 
        		include 'showCustomerOrders.php'; 
        	?>
        	</div>
        <br> <br> <br>
    </body>
    
</html>

<?php } ?>	

