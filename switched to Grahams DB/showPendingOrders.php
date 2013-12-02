<?php 

	if (!isset($_SESSION['privilege'])) 
	{
		header("Location: index.php");
	} 
	else if (intval($_SESSION['privilege']) < 2) 
	{
		header("Location: customerInventory.php");
	} 
	else 
	{
	    
	    // connect to database
    	$mysqli = new mysqli("mysql.cs.uky.edu", "gttu222", "u0670864", "gttu222");
	
    	// check connection 
    	if (mysqli_connect_errno()) 
    	{
    		printf("Failed to Connect: %s\n", mysqli_connect_error());
    		
    		return false;
    	}
	
    	$r = $mysqli->query("SELECT orderID, total FROM Orders WHERE status = 'false'");
	
    	echo '<div align="center" class="div-orders">';
	
    	echo '<p class="order-line">Pending Orders</p><br>';
    	
    	while ($row = $r->fetch_array()) 
    	{  
    		echo "<p style=\"font-size:1.25em;\">Order Number: $row[0] &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp Total: $$row[1]</p>";
		
    		echo "<form method=\"POST\" action=\"shipOrder.php\">
                    <input type=\"hidden\" name=\"orderID\" value=\"$row[0]\">";
                    
    		$query = "SELECT u.id FROM Users u, Places c WHERE c.orderID ='$row[0]' AND c.cId = u.id";
    		
    		$cr = $mysqli->query("SELECT u.id FROM Users u, Places c WHERE
    		     c.orderID ='$row[0]' AND c.cId = u.id");
    		
    		$cust = $cr->fetch_array();
    		
    		echo "Customer ID: $cust[0]";
		
    		echo "<br><br>";
		
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
        	
    		$items = $mysqli->query("SELECT i.itemNumber, i.name, i.quantity, oc.amount, i.price,
    		    i.promotion FROM Item i, Contains oc WHERE orderID = '$row[0]'
    		    AND oc.itemNumber = i.itemNumber");
    	
        	$count = 0;
    	
        	$ship = true;

        	while ($r2 = $items->fetch_array()) 
        	{   
        	    echo '<div class="div-inventory" style="margin-left:23%;">';

                if ($r2[2] < $r2[3])
                {
                    $ship = false;
                }

        	    for ($i = 0; $i < $mysqli->field_count; $i++) 
        	    {
        	        $field = 1;

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
    	
        	if ($ship)
        	{
        	    echo "<div style=\"margin-right:0px;\"><input type=\"submit\" value=\"Ship Order\"></div></form><br>";
    	    }
	
    	    echo "<br>";
    	    
    	}
    	
    	echo "</div>";
	
    	if ($r) 
    	{
    		$r->close();
    	}
	
    	// close the connection
    	if ($mysqli) 
    	{
    		$mysqli->close();
    	}
	}
?>
