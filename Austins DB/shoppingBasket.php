<?php 

    // Start session if not active
    session_start();
    
    // If user is logged in
    if (isset($_SESSION['username'])) 
    {
        // If staff
    	if (intval($_SESSION['privilege']) > 1) 
    	{
    		header("Location: viewInventory.php");
    	}
	} 
	// If not logged in, redirect to login screen
	else 
	{
	    header("Location: index.php");
    }
?> 

<html>

    <head>
        
        <!-- Reference stylesheet -->
        <link rel="stylesheet" type="text/css" href="style.css">
        
        <!-- Set title bar with company name -->
        <h2 class="div-padding">A & G Company</h2>
        
        <!-- Set title for webpage -->
        <title>Shopping Basket</title>
        
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
	
	    <!-- Set customer navigation bar -->
    	<div class="header-div" style="float:right;">
    	    
    	    <a href="logout.php" class="menu-option">Log Out </a>
    	    <a href="customerInventory.php" class="menu-option">Return To Store </a>
        	<a href="customerOrders.php" class="menu-option">Order History </a>
    	
    	</div>
	
    	<?php } ?>
    	<br>
    </div>
	
	<!-- Display message if one exists -->
    <?php include "message.php" ?>
    
    <?php

    	// Connect to the database
    	$mysqli = new mysqli("mysql.cs.uky.edu", "mage223", "u0688279", "mage223");

    	// Check the database connection for error
    	if (mysqli_connect_errno()) 
    	{
    		return false;
    	}

    	// Get item info
    	$r = $mysqli->query("SELECT I.itemNumber, I.name, I.description, I.promotion, B.amount, 
    	    I.price FROM Item I, Basket B WHERE I.itemNumber=B.itemNumber AND B.cID = 
    	    '$_SESSION[username]'");
	
	    // If no items found
    	if($r->num_rows <1)
    	{
    	    // Display nothing in basket message
    	    echo '<h1 align="center" style="padding:25px;">';
    	        echo "Your Shopping Basket is empty.";
    	    echo "</h1>";
    	    
    	    return false;
    	}
	
    	echo '<p align="center" class="header-line"><b>Shopping Basket</b></p>';
	
    	echo '<h1 align="center">';
    	echo "<br>";
	
    	echo '<div class="div-inventory">';
	
	    /* 
	        Display titles of columns in list
	    */
    	    echo '<div class="inv-name" style="background-color: #F0F0F0;">';
    	        echo '<p style="font-size:medium; text-transform: uppercase;">';
    	            echo "<b>Name</b>";
    	        echo '</p>';
    	    echo '</div>';
	    
    	    echo '<div class="inv-description" style="background-color: #F0F0F0;">';
    	        echo '<p style="font-size:medium; text-transform: uppercase;">';
    	            echo "<b>Description</b>";
    	        echo '</p>';
    	    echo '</div>';
	    
    	    echo '<div class="inv-promo" style="background-color: #F0F0F0;">';
    	        echo '<p style="font-size:medium; text-transform: uppercase;">';
    	            echo "<b>Promotion</b>";
    	        echo '</p>';
    	    echo '</div>';
	    
    	    echo '<div class="inv-amount" style="background-color: #F0F0F0;">';
    	        echo '<p style="font-size:medium; text-transform: uppercase;">';
    	            echo "<b>Quantity</b>";
    	        echo '</p>';
    	    echo '</div>';
	    
    	    echo '<div class="inv-price" style="background-color: #F0F0F0;">';
    	        echo '<p style="font-size:medium; text-transform: uppercase;">';
    	            echo "<b>Price</b>";
    	        echo '</p>';
    	    echo '</div>';
	    
    	echo '</div><br>';
	
    	$count = 0;
	
	    // For every item in the Basket table
    	while ($row = $r->fetch_array()) 
    	{
    	    echo '<div class="div-inventory">';
	    
    	    for ($i = 1; $i < $mysqli->field_count + 1; $i++) 
    	    {
    	        $field = 1;
	        
	            // Assign different widths based on column
    	        switch ($i)
    	        {
    	            case 0:
    	                echo '<div class="inv-name" style="';
    	                break;
	            
    	            case 1:
    	                echo '<div class="inv-name" style="';
    	                break;
	             
    	            case 2:
    	                echo '<div class="inv-description" style="';
    	                break;
	            
    	            case 3:
    	                echo '<div class="inv-promo" style="';
    	                break;
	            
    	            case 4:
    	                echo '<div class="inv-amount" style="';
    	                break;
	                
    	            case 5:
    	                echo '<div class="inv-price" style="';
    	                break;
	                
    	            default:
    	                $field = 0;
                }
            
                // Alternate color
                if ($i != $mysqli->field_count && $field == 1)
                {
                    if ($count % 2 == 0)
            	    {
                	    echo 'background-color: white;">';   
            	    }
            	    else
            	    {
            	        echo 'background-color: #F0F0F0;">';
            	    }
        	
                    echo '<p style="font-size:medium;">';
                    if ($i == 5)
                    {
                        // Set the price after promotion rate included
                        echo "$";
                        $p1 = $row[$i];
                        $p2 = $row[$i-1];
                        $p3 = (100-$row[$i-2])/100;
                        $p4 = $p1 * $p2 * $p3;
                        $p5 = sprintf('%0.2f', $p4);
                        echo "$p5";
                    }
                    else
                    {
        			    echo "$row[$i]";
    			    }
        			if ($i == 3){echo "% off";}
        			echo "</p>";
        			echo '</div>';
    		    }
    		    // If it's the last column, add the Remove button
    		    else
    		    {
    		        echo "<form method=\"POST\"action=\"removeFromShoppingBasket.php\">";
        			echo "<input type=\"hidden\" name=\"itemNumber\" value=\"$row[0]\">";
        			echo "<input type=\"submit\"value=\"Remove\"></form>";
    		    }
    		}
		
    		$count++;
		
    		echo '</div>';
        }
	
    	echo '<br>';
    	echo "</h1>";
    	echo '<br>';
	
    	?>
    	
    	<body>
    	    
    	    <!-- Display message if one exists -->
    	    <?php include "message.php" ?>
	
	        <!-- If button is clicked, call addPendingOrder routine -->
        	<form method="POST" action="addPendingOrder.php"> 
        	    <div align="right" style="margin-right:25px;">
        	        <input type="submit" value="Place Order">
        	    </div>
        	</form>
	
    	</body>
    	
	</html>
	
	
<?php

	// Close the database connection
	if ($mysqli) 
	{
		$mysqli->close();
	}

?> 
