<?php 

    // If no one logged in
	if (!isset($_SESSION['username'])) 
	{
		header("Location: index.php");
	} 
	// If staff
	else if (intval($_SESSION['privilege']) > 1) 
	{
		header("Location: viewInventory.php");
	} 
	// If customer
	else 
	{
	    
	    // Connect to the database
    	$mysqli = new mysqli("mysql.cs.uky.edu", "mage223", "u0688279", "mage223");
	
    	// Check the database connection for error
    	if (mysqli_connect_errno()) 
    	{
    		return false;
    	}
	
	    // Set title for tab
    	echo "<p align=\"center\" class=\"header-line\">All Orders For $_SESSION[username]</p>";
    	
    	// Get the orderIDs and totals
    	$r = $mysqli->query("SELECT o.orderID, o.total FROM Orders o, 
    	    Places c WHERE o.status =FALSE AND c.cID = '$_SESSION[username]' 
    	    AND c.orderID = o.orderID"); 
	
    	echo '<div align="center" class="div-orders">';
	
	    // Display the bar for Pending Orders
    	echo '<p class="order-line">Pending Orders</p><br>';
    	
    	// For every Pending Order
    	while ($row = $r->fetch_array()) 
    	{  
    	    
    	    // Make sure only two decimal places
            $temp = sprintf('%0.2f', $row[1]);
    	    
    	    // Display OrderID and Total
    		echo "<p style=\"font-size:1.25em;\">Order Number: $row[0] &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp Total: $$temp</p>";
		
		
		    /*
		        Display column names
		    */
    		echo '<div align="center" class="div-inventory" style="margin-left:27%;">';

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
        	
        	// Get item info for each order
    		$items = $mysqli->query("SELECT i.name, oc.amount, i.price, i.promotion FROM 
                Item i, Contains oc WHERE orderID = '$row[0]' AND oc.itemNumber =
                i.itemNumber");
    	
        	$count = 0;

            // For every item in this order
        	while ($r2 = $items->fetch_array()) 
        	{
        	    echo '<div class="div-inventory" style="margin-left:27%;">';

        	    for ($i = 0; $i < $mysqli->field_count; $i++) 
        	    {
        	        $field = 1;

                    // Get column width
        	        switch ($i)
        	        {
        	            case 0:
        	                echo '<div class="inv-name" style="';
        	                break;

        	            case 1:
        	                echo '<div class="inv-amount" style="';
        	                break;
    	                
        	            case 2:
    	                    echo '<div class="inv-price" style="';
    	                    break;

        	            case 3:
        	                echo '<div class="inv-promo" style="';
        	                break;

        	            default:
        	                $field = 0;
                    }
                
                    // Alternate color
                    if ($field == 1)
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
                        if ($i == 2)
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
            			if ($i == 3){echo "% off";}
            			echo "</p>";
            			echo '</div>';
        		    }
        		}

        		$count++;

        		echo '</div>';
        	}
        	
    	    echo "<br><br>";
    	}
    	
    	echo "</div>";
	
	    // Get orderIDs, totals, and shippedDates for Shipped Orders
    	$r = $mysqli->query("SELECT o.orderID, o.total, o.dateShipped FROM Orders o,
    	    Places c WHERE o.status =TRUE AND c.cID = '$_SESSION[username]'
    	    AND c.orderID = o.orderID"); 
	
    	echo '<div align="center" class="div-orders">';
	
    	echo '<p class="order-line">Shipped Orders</p><br>';
    	
    	// For every Shipped Order
    	while ($row = $r->fetch_array()) 
    	{  
    	    // Make sure two decimal places
    	    $temp = sprintf('%0.2f', $row[1]);
    	    
    	    // Display OrderID, Total, and Ship Date
    		echo "<p style=\"font-size:1.25em;\">Order Number: $row[0] &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp Total: $$temp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp Ship Date: $row[2]</p>";
		
		
		    /*
		        Display column names
		    */
    		echo '<div align="center" class="div-inventory" style="margin-left:27%;">';

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
    		$items = $mysqli->query("SELECT i.name, oc.amount, i.price, i.promotion FROM 
    		    Item i, Contains oc WHERE orderID = '$row[0]' AND oc.itemNumber =
    		    i.itemNumber");
    	
        	$count = 0;

            // For every item in this order
        	while ($r2 = $items->fetch_array()) 
        	{
        	    echo '<div class="div-inventory" style="margin-left:27%;">';

        	    for ($i = 0; $i < $mysqli->field_count; $i++) 
        	    {
        	        $field = 1;

                    // Get column width
        	        switch ($i)
        	        {
        	            case 0:
        	                echo '<div class="inv-name" style="';
        	                break;

        	            case 1:
        	                echo '<div class="inv-amount" style="';
        	                break;
    	                
        	            case 2:
    	                    echo '<div class="inv-price" style="';
    	                    break;

        	            case 3:
        	                echo '<div class="inv-promo" style="';
        	                break;

        	            default:
        	                $field = 0;
                    }
                
                    // Alternate color
                    if ($field == 1)
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
                        if ($i == 2)
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
            			if ($i == 3){echo "% off";}
            			echo "</p>";
            			echo '</div>';
        		    }
    		    
        		}

        		$count++;

        		echo '</div>';
        	}
        	
    	    echo "<br><br>";
	    }
	
	    echo "</div>";

    	// Close the database connection
    	if ($mysqli) 
    	{
    		$mysqli->close();
    	}
	}
?>