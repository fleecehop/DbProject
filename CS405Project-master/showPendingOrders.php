<?php 
	if (!isset($_SESSION['privileges'])) {
		header("Location: loginForm.php");
	} else if (intval($_SESSION['privileges']) < 2) {
		header("Location: store.php");
	} else {
	// connect to database
	$mysqli = new mysqli("mysql.cs.uky.edu", "clef222", "Mtfbwy4;", "clef222");
	
	// check connection 
	if (mysqli_connect_errno()) {
		printf("Connect failed: %s\n", mysqli_connect_error());
		$_SESSION['error'] = $_SESSION['error']."Database Error: Unable to connect to the mySQL Database.<br>"; 
		return false;
	}
	
	
    $query = "SELECT orderNum, total FROM Orders WHERE shipStatus = 'false'";
	$result = $mysqli->query($query); // Execute the Query
	
	
	echo '<div align="center" class="div-orders">';
	
	echo '<p class="order-line">Pending Orders</p><br>';
	while ($row = $result->fetch_array()) 
	{  
		echo "<p style=\"font-size:1.25em;\">Order Number: $row[0]&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspTotal: $$row[1]</p>";
		
		
		echo "   <form method=\"POST\" action=\"shipOrder.php\">
				<input type=\"hidden\" name=\"orderNum\" value=\"$row[0]\">";
		$query = "SELECT u.id FROM Users u, CustomerPlacesOrder c WHERE c.orderNum ='$row[0]' AND c.cId = u.id";
		$custResult = $mysqli->query($query);
		$customer = $custResult->fetch_array();
		echo "Customer ID: $customer[0]";
		
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
	
	
    	$query = "SELECT i.itemId, i.name, i.quantity, oc.amount, i.price, i.promotion FROM 
					Inventory i, OrderContainsItem oc WHERE orderNum = '$row[0]' AND oc.itemId = i.itemId";
		$orderItems = $mysqli->query($query);
    	
    	$count = 0;

    	while ($r = $orderItems->fetch_array()) 
    	{   
    	    echo '<div class="div-inventory" style="margin-left:23%;">';

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
                        $p1 = $r[$i];
                        $p2 = $r[$i-1];
                        $p3 = (100-$r[$i+1])/100;
                        $p4 = $p1 * $p2 * $p3;
                        $p5 = sprintf('%0.2f', $p4);
                        echo "$p5";
                    }
                    else
                    {
        			    echo "$r[$i]";
    			    }
        			if ($i == 5){echo "% off";}
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
    	
    	echo "<br>";
    	
    	echo "<div style=\"margin-right:0px;\"><input type=\"submit\" value=\"Ship Order\"></div></form><br>";
    	
	    echo "<br>";
	}
	echo "</div>";
	
	
	/*
	echo "<br><br><b>Pending Orders</b><br><br>";
	while ($row = $result->fetch_array()) {
		echo "Order Number: $row[0]    Total: $row[1]";
		echo "   <form method=\"POST\" action=\"shipOrder.php\">
				<input type=\"hidden\" name=\"orderNum\" value=\"$row[0]\">";
		$query = "SELECT u.id FROM Users u, CustomerPlacesOrder c WHERE c.orderNum ='$row[0]' AND c.cId = u.id";
		$custResult = $mysqli->query($query);
		$customer = $custResult->fetch_array();
		echo "Customer ID: $customer[0]"; 
		
		echo "<table align=\"center\" border = 2 bgcolor=\"#F0F0F0\"><tr>";
		echo "<td>ID</td><td>Name</td><td>Amount In Stock</td><td>Order Amount</td><td>Price</td><td>Promotion</td></tr>";
		$query = "SELECT i.itemId, i.name, i.quantity, oc.amount, i.price, i.promotion FROM 
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
		echo "</table>";
		echo "<input type=\"submit\" value=\"Ship Order\"></form><br>"; 
	}
	*/
	if ($result) {
		$result->close();
	}
	
	// close the connection
	if ($mysqli) {
		$mysqli->close();
	}
	}
?>
