<?php 
	if (!isset($_SESSION['privileges'])) {
		header("Location: loginForm.php");
	}
	else {
		// connect to database
	$mysqli = new mysqli("mysql.cs.uky.edu", "clef222", "Mtfbwy4;", "clef222");
	
	// check connection 
	if (mysqli_connect_errno()) {
		printf("Connect failed: %s\n", mysqli_connect_error());
		return false;
	}
	
	// set up DB Query and execute it
	
	$query = "SELECT * FROM Inventory";
	$result = $mysqli->query($query); // Execute the Query 
	
	/*
	echo "<br><br><div align=\"center\"><b>";
	if (intval($_SESSION['privileges']) > 1) {
		echo "Inventory";
	} else {
		echo "Store";
	}
	echo "</b></div><br>";
	
	
	echo "<table align=\"center\" border = 2 bgcolor=\"#F0F0F0\"><tr>";
	

	echo "<td>Name</td><td>Description</td><td>Type</td><td>Amount In Stock</td><td>Price</td><td>Promotion (% off)</td>";
	if (intval($_SESSION['privileges']) > 1) {
		if (isset($_SESSION['promotions'])) {
			echo "<td>Change Promotion</td>";
		} else if (!isset($_SESSION['view'])) {
			echo "<td>Add Inventory</td>";
		} 
	} else {
		echo "<td>Add Amount to Cart</td>";
	}
	echo "</tr>";
	
	while ($row = $result->fetch_array()) {
			echo "<tr>"; 
			for ($i = 1; $i < $mysqli->field_count; $i++) {
				echo "<td>$row[$i]</td>";
			}
			if (!isset($_SESSION['view'])) { 
				echo "<td><input type=\"text\"name=\"$row[0]\"></td>";
			} 
			echo "</tr>";
	}
	echo "</table><br>";
	*/
	
	echo "<br>";
	
	echo '<div class="div-inventory">';
	    
	    $j = 0;
	    
    	if (intval($_SESSION['privileges']) > 1) 
    	{
    		echo '<div class="inv-id" style="background-color: #F0F0F0;">';
    	        echo '<p style="font-size:medium;">';
    	            echo "<b>Item ID</b>";
    	        echo '</p>';
    	    echo '</div>';
    	} 
    	else 
    	{
    		$j = 1;
    	}
	
	    echo '<div class="inv-name" style="background-color: #F0F0F0;">';
	        echo '<p style="font-size:medium;">';
	            echo "<b>Name</b>";
	        echo '</p>';
	    echo '</div>';
	    
	    echo '<div class="inv-description" style="background-color: #F0F0F0;">';
	        echo '<p style="font-size:medium;">';
	            echo "<b>Description</b>";
	        echo '</p>';
	    echo '</div>';
	    
	    echo '<div class="inv-type" style="background-color: #F0F0F0;">';
	        echo '<p style="font-size:medium;">';
	            echo "<b>Type</b>";
	        echo '</p>';
	    echo '</div>';
	    
	    echo '<div class="inv-amount" style="background-color: #F0F0F0;">';
	        echo '<p style="font-size:medium;">';
	            echo "<b>Quantity</b>";
	        echo '</p>';
	    echo '</div>';
	    
	    echo '<div class="inv-price" style="background-color: #F0F0F0;">';
	        echo '<p style="font-size:medium;">';
	            echo "<b>Price</b>";
	        echo '</p>';
	    echo '</div>';
	    
	    echo '<div class="inv-promo" style="background-color: #F0F0F0;">';
	        echo '<p style="font-size:medium;">';
	            echo "<b>Promotion</b>";
	        echo '</p>';
	    echo '</div>';
	echo '</div><br>';
	
	$count = 0;
	
	while ($row = $result->fetch_array()) 
	{
	    echo '<div class="div-inventory">';
	    
	    for ($i = $j; $i < $mysqli->field_count + 1; $i++) 
	    {
	        
	        switch ($i)
	        {
	            case 0:
	                echo '<div class="inv-id" style="';
	                break;
	            
	            case 1:
	                echo '<div class="inv-name" style="';
	                break;
	             
	            case 2:
	                echo '<div class="inv-description" style="';
	                break;
	            
	            case 3:
	                echo '<div class="inv-type" style="';
	                break;
	            
	            case 4:
	                echo '<div class="inv-amount" style="';
	                break;
	                
	            case 5:
	                echo '<div class="inv-price" style="';
	                break;
	                
	            case 6:
	                echo '<div class="inv-promo" style="';
	                break;
            }
            
            if ($i != $mysqli->field_count)
            {
                if ($count % 2 == 0)
        	    {
            	    echo 'background-color: white;">';   
        	    }
        	    else
        	    {
        	        echo 'background-color: #F0F0F0;">';
        	    }
        	
            
                //echo '<div class="inv-name">';
                echo '<p style="font-size:medium;">';
                if ($i == 5){echo "$";}
    			echo "$row[$i]";
    			if ($i == 6){echo "% off";}
    			echo "</p>";
    			echo '</div>';
		    }
		    else if (!isset($_SESSION['view'])) 
		    {
		        echo "<input type=\"text\"name=\"$row[0]\">";
		    }
		}
		
		$count++;
		
		echo '</div>';
    }
	
	echo '<br>';
	
	if (isset($_SESSION['view'])) {
			unset($_SESSION['view']);
	} else if (isset($_SESSION['promotions'])) {
			unset($_SESSION['promotions']);
	}
	
	if ($result) {
		$result->close();
	}
	
	// close the connection
	if ($mysqli) {
		$mysqli->close();
	}
	}

?>		