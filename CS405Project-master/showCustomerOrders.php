<?php 
	if (!isset($_SESSION['privileges'])) {
		header("Location: loginForm.php");
	} else if (intval($_SESSION['privileges']) > 1) {
		header("Location: viewInventory.php");
	} else {
	// connect to database
	$mysqli = new mysqli("mysql.cs.uky.edu", "clef222", "Mtfbwy4;", "clef222");
	
	// check connection 
	if (mysqli_connect_errno()) {
		printf("Connect failed: %s\n", mysqli_connect_error());
		return false;
	}
	
	echo "<p align=\"center\" class=\"header-line\">All Orders For $_SESSION[username]</p>";
	// set up DB Query and execute it
	$query = "SELECT o.orderNum, o.total FROM Orders o, CustomerPlacesOrder c WHERE o.shipStatus =FALSE AND c.cID = '$_SESSION[username]' AND c.orderNum = o.orderNum";
	$result = $mysqli->query($query); // Execute the Query 
	
	echo '<div align="center" class="div-orders">';
	
	echo '<p class="order-line">Pending Orders</p><br>';
	while ($row = $result->fetch_array()) 
	{  
		echo "Order Number: $row[0]&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspTotal: $$row[1]";
		
		echo "<br><br>";
		
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
	
    	$q2 = "SELECT i.name, oc.amount, i.price, i.promotion FROM 
					Inventory i, OrderContainsItem oc WHERE orderNum = '$row[0]' AND oc.itemId = i.itemId";
		$orderItems = $mysqli->query($q2);
    	
    	$count = 0;

    	while ($r = $orderItems->fetch_array()) 
    	{
    	    echo '<div class="div-inventory">';

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
                        $p1 = $row[$i];
                        $p2 = $row[$i-1];
                        $p3 = $p1 * $p2;
                        echo "$p3";
                    }
                    else
                    {
        			    echo "$row[$i]";
    			    }
        			if ($i == 3){echo "% off";}
        			echo "</p>";
        			echo '</div>';
    		    }
    		    else
    		    {
    		        
    		    }
    		    
    		}

    		$count++;

    		echo '</div>';
    	}
	}
	echo "</div>";
		/*
		echo "<table align=\"center\" border = 2 bgcolor=\"#F0F0F0\"><tr>";
		echo "<td>Name</td><td>Order Amount</td><td>Price</td><td>Promotion</td></tr>";
    	
		$query = "SELECT i.name, oc.amount, i.price, i.promotion FROM 
					Inventory i, OrderContainsItem oc WHERE orderNum = '$row[0]' AND oc.itemId = i.itemId";
		$orderItems = $mysqli->query($query);
		while ($r = $orderItems->fetch_array()) {
			echo "<tr>"; 
			for ($i = 0; $i < $mysqli->field_count; $i++) {
				echo "<td>$r[$i]</td>";
			}
			echo "</tr>";
		}
		if ($r) {
			$r->close();
		}
		echo "</table><br><br>";
	}
	if ($result) {
		$result->close();
	}
	
	echo "</div>";
	*/
	$query = "SELECT o.orderNum, o.total, o.shipDate FROM Orders o, CustomerPlacesOrder c WHERE o.shipStatus =TRUE AND c.cID = '$_SESSION[username]' AND c.orderNum = o.orderNum";
	$result = $mysqli->query($query); // Execute the Query 
	
	echo '<div align="center" class="div-orders">';
	
	echo '<p class="order-line">Shipped Orders</p><br>';
	while ($row = $result->fetch_array()) {
		echo "Order Number: $row[0]&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspTotal: $$row[1]     Ship Date: $row[2]";
		echo "<br><br>";
		echo "<table align=\"center\" border = 2 bgcolor=\"#F0F0F0\"><tr>";
		echo "<td>Name</td><td>Order Amount</td><td>Price</td><td>Promotion</td></tr>";
		$query = "SELECT i.name, oc.amount, i.price, i.promotion FROM 
					Inventory i, OrderContainsItem oc WHERE orderNum = '$row[0]' AND oc.itemId = i.itemId";
		$orderItems = $mysqli->query($query);
		while ($r = $orderItems->fetch_array()) {
			echo "<tr>"; 
			for ($i = 0; $i < $mysqli->field_count; $i++) {
				echo "<td>$r[$i]</td>";
			}
			echo "</tr>";
		}
		if ($r) {
			$r->close();
		}
		echo "</table><br><br>";
	}
	if ($result) {
		$result->close();
	}
	
	echo "</div>";
	
	// close the connection
	if ($mysqli) {
		$mysqli->close();
	}
	}
?>