<?php 

	session_start();
	
	if (!isset($_SESSION['privilege'])) 
	{
		header("Location: index.php");
	}
	else if (intval($_SESSION['privilege']) > 1) 
	{
		header("Location: viewInventory.php");
	} 
	else 
	{
?> 

<html>
    <head>
        <link rel="stylesheet" type="text/css" href="style.css">
        <h2 class="div-padding">A & G Company</h2>
        <title>Order History</title>
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
    	    <a href="shoppingBasket.php" class="menu-option">Shopping Basket</a>
    	    <a href="customerInventory.php" class="menu-option">Return To Store </a>
    	
    	</div>
	
    	<?php } ?>
    	
    	<br>
    </div>
    
    <body>
        <?php include "message.php"?>
        <div align="center"> 
        	<?php 
        		include 'showCustomerOrders.php'; 
        	?>
        	</div>
        <br> <br> <br>
    </body>
</html>

<?php } ?>	

