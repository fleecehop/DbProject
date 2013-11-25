<?php 

	if (!isset($_SESSION['privileges'])) {
		header("Location: loginForm.php");
	} else if (intval($_SESSION['privileges']) < 3) {
		header("Location: store.php");
	}
	else if (!isset($_POST['time'])) {
		// do nothing
	} else {
	// connect to database
	$mysqli = new mysqli("mysql.cs.uky.edu", "clef222", "Mtfbwy4;", "clef222");
	
	// check connection 
	if (mysqli_connect_errno()) {
		printf("Connect failed: %s\n", mysqli_connect_error());
		return false;
	}
	echo '<p align="center" class="header-line"><b>Sales Statistics</b></p>';
	
	$query = "SELECT count(orderNum), sum(total) FROM Orders";
	if ($_POST['time'] == "week") {
		$query = $query." WHERE shipDate > DATE_SUB(CURDATE(), INTERVAL 1 WEEK)";
	} else if ($_POST['time'] == "month") {
		$query = $query." WHERE shipDate > DATE_SUB(CURDATE(), INTERVAL 1 MONTH)";
	} else if ($_POST['time'] == "month") {
		$query = $query." WHERE shipDate > DATE_SUB(CURDATE(), INTERVAL 1 YEAR)";
	}
	$result = $mysqli->query($query); // Execute the Query 
	if ($result) {
		$row = $result->fetch_array();
		echo '<div style="font-size:1.5em;>"';
		echo "<br>Number of Orders: $row[0] <br><br> Total Sales: $$row[1]<br><br>";
		echo "</div>";
		$result->close();
	}
	
	// set up DB Query and execute it
	$query = "SELECT orderNum, shipDate, total FROM Orders";
	
	if ($_POST['time'] == "week") {
		$query = $query." WHERE shipDate > DATE_SUB(CURDATE(), INTERVAL 1 WEEK)";
	} else if ($_POST['time'] == "month") {
		$query = $query." WHERE shipDate > DATE_SUB(CURDATE(), INTERVAL 1 MONTH)";
	} else if ($_POST['time'] == "year") {
		$query = $query." WHERE shipDate > DATE_SUB(CURDATE(), INTERVAL 1 YEAR)";	
	}
	
	if ($_POST['time'] == "all")
	{
	    echo "<p class=\"order-line\" style=\"margin: 0px 30px 0px 30px;\">All Orders</p>";
	}
	else
	{
	    echo "<p class=\"order-line\" style=\"margin: 0px 30px 0px 30px;\">Orders for the past
	        $_POST[time]</p>";
    }
	
	$result = $mysqli->query($query); // Execute the Query 
	
	echo '<div align="center" class="div-orders">';
	
	while ($row = $result->fetch_array()) {
	    
	    $spaceCount = 0;
	    
	    echo '<div style="font-size:1em;"><br>';
		echo "Order #: $row[0]<br>Ship Date: $row[1]<br>Total: $$row[2]<br>";
		$query = "SELECT u.id FROM Users u, CustomerPlacesOrder c WHERE c.orderNum ='$row[0]' AND c.cId = u.id";
		$custResult = $mysqli->query($query);
		$customer = $custResult->fetch_array();
		echo "Customer ID: $customer[0]";
		echo "</div>"; 
		
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
		
		$query = "SELECT i.itemId, i.name, oc.amount FROM 
					Inventory i, OrderContainsItem oc WHERE orderNum = '$row[0]' AND oc.itemId = i.itemId";
		$orderItems = $mysqli->query($query);
		
		$count = 0;
		
    	while ($r = $orderItems->fetch_array()) 
    	{
    	    $spaceCount++;
    	    
    	    echo '<div class="div-inventory" style="margin-left:1%;">';

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
                    echo "$r[$i]";
                    
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
    	
    	echo "</div>";
	    echo "<br>";
	    for ($i = 0; $i <= $spaceCount; $i++)
	    {
	        echo "<br>";
	    }
	}
	
	echo "</div>";
	
	if ($result) {
		$result->close();
	}		
	
	// close the connection
	if ($mysqli) {
		$mysqli->close();
	}
	}
?>