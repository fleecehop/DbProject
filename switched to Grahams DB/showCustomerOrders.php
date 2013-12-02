<?php 

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
	    
	    // connect to database
    	$mysqli = new mysqli("mysql.cs.uky.edu", "gttu222", "u0670864", "gttu222");
	
    	// check connection 
    	if (mysqli_connect_errno()) 
    	{
    		printf("Failed to Connect: %s\n", mysqli_connect_error());
    		return false;
    	}
	
    	echo "<p align=\"center\" class=\"header-line\">All Orders For $_SESSION[username]</p>";
    	
    	// set up DB Query and execute it
    	$r = $mysqli->query("SELECT o.orderID, o.total FROM Orders o, 
    	    Places c WHERE o.status =FALSE AND c.cID = '$_SESSION[username]' 
    	    AND c.orderID = o.orderID"); 
	
    	echo '<div align="center" class="div-orders">';
	
    	echo '<p class="order-line">Pending Orders</p><br>';
    	
    	while ($row = $r->fetch_array()) 
    	{  
    	    
            $temp = sprintf('%0.2f', $row[1]);
    	    
    		echo "<p style=\"font-size:1.25em;\">Order Number: $row[0] &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp Total: $$temp</p>";
		
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
        	
    		$items = $mysqli->query("SELECT i.name, oc.amount, i.price, i.promotion FROM 
                Item i, Contains oc WHERE orderID = '$row[0]' AND oc.itemNumber =
                i.itemNumber");
    	
        	$count = 0;

        	while ($r2 = $items->fetch_array()) 
        	{
        	    echo '<div class="div-inventory" style="margin-left:27%;">';

        	    for ($i = 0; $i < $mysqli->field_count; $i++) 
        	    {
        	        $field = 1;

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
	
    	$r = $mysqli->query("SELECT o.orderID, o.total, o.dateShipped FROM Orders o,
    	    Places c WHERE o.status =TRUE AND c.cID = '$_SESSION[username]'
    	    AND c.orderID = o.orderID"); 
	
    	echo '<div align="center" class="div-orders">';
	
    	echo '<p class="order-line">Shipped Orders</p><br>';
    	
    	while ($row = $r->fetch_array()) 
    	{  
    	    $temp = sprintf('%0.2f', $row[1]);
    	    
    		echo "<p style=\"font-size:1.25em;\">Order Number: $row[0] &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp Total: $$temp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp Ship Date: $row[2]</p>";
		
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
	
    		$items = $mysqli->query("SELECT i.name, oc.amount, i.price, i.promotion FROM 
    		    Item i, Contains oc WHERE orderID = '$row[0]' AND oc.itemNumber =
    		    i.itemNumber");
    	
        	$count = 0;

        	while ($r2 = $items->fetch_array()) 
        	{
        	    echo '<div class="div-inventory" style="margin-left:27%;">';

        	    for ($i = 0; $i < $mysqli->field_count; $i++) 
        	    {
        	        $field = 1;

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

    	// close the connection
    	if ($mysqli) 
    	{
    		$mysqli->close();
    	}
	}
?>