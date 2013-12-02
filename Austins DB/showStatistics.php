<?php 

	if (isset($_POST['time'])) 
	{   
	    // Connect to the database
    	$mysqli = new mysqli("mysql.cs.uky.edu", "mage223", "u0688279", "mage223");
	
    	// Check the database connection 
    	if (mysqli_connect_errno()) 
    	{
    		return false;
    	}
    	
    	// Set title for tab
    	echo '<p align="center" class="header-line"><b>Sales Statistics</b></p>';
	
	    // Start two half queries
    	$query = "SELECT count(orderID), sum(total) FROM Orders";
    	$query2 = "SELECT orderID, dateShipped, total FROM Orders";
    	
    	// Finish the queries based on the time frame
    	if ($_POST['time'] == "week") 
    	{
    		$query = $query." WHERE dateShipped > DATE_SUB(CURDATE(), INTERVAL 1 WEEK)";
    		$query2 = $query2." WHERE dateShipped > DATE_SUB(CURDATE(), INTERVAL 1 WEEK)";
    	} 
    	else if ($_POST['time'] == "month") 
    	{
    		$query = $query." WHERE dateShipped > DATE_SUB(CURDATE(), INTERVAL 1 MONTH)";
    		$query2 = $query2." WHERE dateShipped > DATE_SUB(CURDATE(), INTERVAL 1 MONTH)";
    	} 
    	else if ($_POST['time'] == "month") 
    	{
    		$query = $query." WHERE dateShipped > DATE_SUB(CURDATE(), INTERVAL 1 YEAR)";
    		$query2 = $query2." WHERE dateShipped > DATE_SUB(CURDATE(), INTERVAL 1 YEAR)";
    	}
    	
    	// Query the number or orders and full total
    	$r = $mysqli->query($query);
    	
    	// If at least one order
    	if ($r) 
    	{   
    		$row = $r->fetch_array();
    		
    		// Make sure two decimal places
    		$temp = sprintf('%0.2f', $row[1]);
    		
    		// Display the number of orders and full total
    		echo '<div style="font-size:1.5em;>"';
    		    echo "<br>Number of Orders: $row[0] <br><br> Total Sales: $$temp<br><br>";
    		echo "</div>";
    	}

        // If the time frame was all orders
    	if ($_POST['time'] == "all")
    	{
    	    echo "<p class=\"order-line\" style=\"margin: 0px 30px 0px 30px;\">All Orders</p>";
    	}
    	// If anything else
    	else
    	{
    	    echo "<p class=\"order-line\" style=\"margin: 0px 30px 0px 30px;\">Orders for the past $_POST[time]</p>";
        }
	
	    // Query for order info
    	$r = $mysqli->query($query2);
	
    	echo '<div align="center" class="div-orders">';
	
	    // For every order
    	while ($row = $r->fetch_array()) {
	    
    	    $spaceCount = 0;
	    
    	    echo '<div style="font-size:1em;"><br>';
    	    
    	        // Make sure two decimal places
    	        $temp = sprintf('%0.2f', $row[2]);
    	    
    	        // Display orderID, shippedDate, Total, and customerID
    		    echo "Order #: $row[0]<br>Ship Date: $row[1]<br>Total: $$temp<br>";
    	
        		$cr = $mysqli->query("SELECT u.id FROM Users u, Places c
        		     WHERE c.orderID ='$row[0]' AND c.cId = u.id");
    		     
        		$cust = $cr->fetch_array();
    		
        		echo "Customer ID: $cust[0]";
    		
    		echo "</div>"; 
		
		
		    // Display column names
    		echo '<div align="center" class="div-inventory" style="margin-left:36%;">';

        	    echo '<div class="inv-id" style="background-color: #F0F0F0;">';
        	        echo '<p style="font-size:medium; text-transform: uppercase;">';
        	            echo "<b>Item ID</b>";
        	        echo '</p>';
        	    echo '</div>';
    	    
        	    echo '<div class="inv-name" style="background-color: #F0F0F0;">';
        	        echo '<p style="font-size:medium; text-transform: uppercase;">';
        	            echo "<b>Name</b>";
        	        echo '</p>';
        	    echo '</div>';

                echo '<div class="inv-amount" style="background-color: #F0F0F0;">';
        	        echo '<p style="font-size:medium; text-transform: uppercase;">';
        	            echo "<b>Quantity</b>";
        	        echo '</p>';
        	    echo '</div>';

        	echo '</div>';
		
    		echo '<div align="center" class="div-inventory" style="margin-left:35%;">';
		
		    // Get item info
    		$items = $mysqli->query("SELECT i.itemNumber, i.name, oc.amount FROM Item i,
    		     Contains oc WHERE orderID = '$row[0]' AND oc.itemNumber = i.itemNumber");
		
    		$count = 0;
		
		    // For every item
        	while ($r2 = $items->fetch_array()) 
        	{
        	    $spaceCount++;
    	    
        	    echo '<div class="div-inventory" style="margin-left:1%;">';

        	    for ($i = 0; $i < $mysqli->field_count; $i++) 
        	    {   
        	        $field = 1;

                    // Set column widths
        	        switch ($i)
        	        {
        	            case 0:
        	                echo '<div class="inv-id" style="';
        	                break;
    	            
        	            case 1:
        	                echo '<div class="inv-name" style="';
        	                break;

        	            case 2:
        	                echo '<div class="inv-amount" style="';
        	                break;

        	            default:
        	                $field = 0;
                    }
                
                    if ($field == 1)
                    {
                        // Alternate color
                        if ($count % 2 == 0)
                	    {
                    	    echo 'background-color: white;">';   
                	    }
                	    else
                	    {
                	        echo 'background-color: #F0F0F0;">';
                	    }

                        echo '<p style="font-size:medium;">';
                        echo "$r2[$i]";
                    
            			echo "</p>";
            			echo '</div>';
        		    }
    		    
        		}

        		$count++;

        		echo '</div>';
        	}
    	
        	echo "</div>";
    	    echo "<br>";
    	    
    	    // Add spaces based on the number of items
    	    for ($i = 0; $i <= $spaceCount; $i++)
    	    {
    	        echo "<br>";
    	    }
    	}
	
    	echo "</div>";		
	
    	// Close the database connection
    	if ($mysqli) 
    	{
    		$mysqli->close();
    	}
	}
?>