<?php 
	session_start();
	
	if (!isset($_SESSION['privileges'])) 
	{
		header("Location: index.php");
	}
	else if (intval($_SESSION['privileges']) < 2) 
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
        <title>Manage Inventory</title>
    </head>
    <body>
        <div class="div-padding">    
            <div class="header-div" style="float:left; font-weight: bold;">
        	    Welcome <?php 
            			if (isset($_SESSION['username'])) 
            			{
            				echo $_SESSION['username']; 
            				?>!
        	</div>
	
        	<div class="header-div" style="float:right;">
        	    <a href="logout.php" class="menu-option">Log Out </a>
        	    <a href="viewInventory.php" class="menu-option">View Inventory </a>
            	<a href="manageStock.php" class="menu-option">Edit Inventory </a>
            	<a href="pendingOrders.php" class="menu-option">Pending Orders </a>
            	
            	<?php if (intval($_SESSION['privileges']) == 3) { ?>
        		    <a href="managePromotions.php" class="menu-option">Promotions </a>
            		<a href="statistics.php" class="menu-option">Stats </a>
            	<?php } ?>
            	
        	</div>
	
        	            <?php } ?>
        </div>
        
        <?php include "message.php"?>
        <br>

        <div class="order-line" align="center"><b>Add Item to Inventory</b></div><br>
        
        <div align="center">
            <form method="POST" action="addStock.php"> 
            	Name: * <br><input type="text" name="name"><br><br>
            	Description: * <br><input type="text" name="description"><br><br>
            	Type: * <br><select name="type">
            			<option value="toy">Toy</option>
            			<option value = "game">Game</option>
            			</select><br><br>
            	Amount: <br><input type="text" name="amount"><br><br>
            	Price: <br><input type="text" name="price"><br><br>
            	<input type="submit" value="Add Item to Store">
            </form> 
        </div>

        <h1 align="center"> 
            <form method="POST" action="updateStock.php"> 
            	<?php include 'showStock.php'; ?>
            	<p style="float:right; margin-right:30px;"><input type="submit" 
            	    value="Add Quantity"></p>
            </form><br>
        </h1>
        <br>

    </body>
    
</html>

<?php } ?>	

