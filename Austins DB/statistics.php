<?php 

    // Start session if not active
	session_start();
	
	// If not logged in
	if (!isset($_SESSION['username'])) 
	{
		header("Location: index.php");
	}
	// If not manager
	else if (intval($_SESSION['privilege']) < 3) 
	{
		header("Location: index.php");
	} 
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
        <title>Sales Statistics</title>
        
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
    
    <body> 
        <br>
    		<div align="center" class="box">
    		    
    		    <!-- Create form to call another php file based on input -->
    		    <form method="POST" action="statistics.php"> 
    		        
        			Time Frame: <select name="time">
        			    <option value="week">Week</option>
            			<option value="month">Month</option>
            			<option value="year">Year</option>
            			<option value="all">All</option>
        		    </select><br><br>
        		    
                	<input type="submit" value="View Sales Statistics">
                	
            	</form>
            	
        	</div>
        	
        <!-- Show statistics for the time frame if one was selected -->	
        <div align="center">
        	<?php include 'showStatistics.php' ?>
        </div>
        
    </body>
    
</html>

<?php } ?>	

