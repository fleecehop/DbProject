<?php 
	session_start();
	
	if (isset($_SESSION['privileges'])) 
	{
		if (intval($_SESSION['privileges']) > 1) 
		{
			header("Location: viewInventory.php");
		}
	}
?>

<html>
    <head>
        <link rel="stylesheet" type="text/css" href="style.css">
        <h2 class="div-padding">A & G Company</h2>
        <title>A & G Company</title>
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
    	    <a href="shoppingBasket.php" class="menu-option">Shopping Basket </a>
        	<a href="customerOrders.php" class="menu-option">Order History </a>
    	
    	</div>
	
    	<?php } ?><br>
    	
    </div>
    
    <body>
        <?php include "message.php"?>

        <div align="center" class="inv-box">
            <form method="POST" action="addToShoppingBasket.php"> 
            	<?php include 'showStock.php'; ?>
            	<div align="right" style="margin-right:7.5%;">
            	    <input type="submit" value="Add To Cart">
            	</div>
            </form>
            <br>
        </div>
        
    </body>
    
</html>

	
 	
