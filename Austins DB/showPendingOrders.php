<?php 
	    
    // Connect to the database
	$mysqli = new mysqli("mysql.cs.uky.edu", "mage223", "u0688279", "mage223");

	// Check the database connection for error
	if (mysqli_connect_errno()) 
	{
		return false;
	}

    // Get orderIDs and totals
	$r = $mysqli->query("SELECT orderID, total FROM Orders WHERE status = 'false'");

	echo '<div align="center" class="div-orders">';

	echo '<p class="order-line">Pending Orders</p><br>';
	
	// For every order
	while ($row = $r->fetch_array()) 
	{  
	    // Make sure two decimal places
	    $temp = sprintf('%0.2f', $row[1]);
	    
	    // Display orderID and total
		echo "<p style=\"font-size:1.25em;\">Order Number: $row[0] &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp Total: $$temp</p>";
	
		echo "<form method=\"POST\" action=\"shipOrder.php\">
                <input type=\"hidden\" name=\"orderID\" value=\"$row[0]\">";
        
        // Get and display userID
		$cr = $mysqli->query("SELECT u.id FROM Users u, Places c WHERE
		     c.orderID ='$row[0]' AND c.cId = u.id");
		
		$cust = $cr->fetch_array();
		
		echo "Customer ID: $cust[0]";
	
		echo "<br><br>";
	
	
	    /*
	        Display column names
	    */
		echo '<div align="center" class="div-inventory" style="margin-left:23%;">';

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
    	            echo "<b>In Stock</b>";
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

    	    echo '<div class="inv-promo" style="background-color: #F0F0F0;">';
    	        echo '<p style="font-size:medium; text-transform: uppercase;">';
    	            echo "<b>Promotion</b>";
    	        echo '</p>';
    	    echo '</div>';

    	echo '</div>';
    	
    	// Get item info for this order
		$items = $mysqli->query("SELECT i.itemNumber, i.name, i.amount, oc.amount,
		     i.price, i.promotion FROM Item i, Contains oc WHERE orderID = '$row[0]' AND
		     oc.itemNumber = i.itemNumber");
	
    	$count = 0;
	
    	$ship = true;

        // For every item in the order
    	while ($r2 = $items->fetch_array()) 
    	{   
    	    echo '<div class="div-inventory" style="margin-left:23%;">';

            // Check if quantity ordered is more than what is in stock
            if ($r2[2] < $r2[3])
            {
                $ship = false;
            }

    	    for ($i = 0; $i < $mysqli->field_count; $i++) 
    	    {
    	        $field = 1;

                // Set the column widths
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
	                
    	            case 3:
    	                echo '<div class="inv-amount" style="';
    	                break;
	                
    	            case 4:
	                    echo '<div class="inv-price" style="';
	                    break;

    	            case 5:
    	                echo '<div class="inv-promo" style="';
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
                    if ($i == 4)
                    {
                        // Set price after promotion included
                        echo "$";
                        $p1 = $r2[$i];
                        $p2 = $r2[$i-1];
                        $p3 = (100-$r2[$i+1])/100;
                        $p4 = $p1 * $p2 * $p3;
                        $p5 = sprintf('%0.2f', $p4);
                        echo "$p5";
                    }
                    else
                    {
        			    echo "$r2[$i]";
    			    }
        			if ($i == 5){echo "% off";}
        			echo "</p>";
        			echo '</div>';
    		    }
		    
    		}

    		$count++;

    		echo '</div>';
    	}
	
    	echo "<br>";
	
	    // If the stock > quantity ordered
    	if ($ship)
    	{
    	    // Show the 'Ship Order' button
    	    echo "<div style=\"margin-right:0px;\"><input type=\"submit\" value=\"Ship Order\"></div></form><br>";
	    }

	    echo "<br>";
	    
	}
	
	echo "</div>";

	// Close the database connection
	if ($mysqli) 
	{
		$mysqli->close();
	}
?>
