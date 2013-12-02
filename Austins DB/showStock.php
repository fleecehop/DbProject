<?php 

    // If not logged in
	if (!isset($_SESSION['username'])) 
	{
		header("Location: index.php");
	}
	// If logged in
	else 
	{
		// Connect to the database
	    $mysqli = new mysqli("mysql.cs.uky.edu", "mage223", "u0688279", "mage223");
	
    	// Check the database connection for error
    	if (mysqli_connect_errno()) 
    	{
    		return false;
	    }
	
	    // Get all items
    	$result = $mysqli->query("SELECT * FROM Item");
	
    	echo "<br>";
	
    	echo '<div class="div-inventory">';
	    
	    /*
	        Display first column if staff/manager and start at 0
	    */
    	    $j = 0;
	    
        	if (intval($_SESSION['privilege']) > 1) 
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
	
	
	        // Display the rest of the columns for everyone
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
	
	    // For every item
    	while ($row = $result->fetch_array()) 
    	{
    	    echo '<div class="div-inventory">';
	    
    	    for ($i = $j; $i < $mysqli->field_count + 1; $i++) 
    	    {
	        
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
            
                // Alternate colors
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
        	
                    echo '<p style="font-size:medium;">';
                    if ($i == 5)
                    {
                        // Make sure two decimal places
                        $temp = sprintf('%0.2f', $row[$i]);
                        
                        echo "$$temp";
                    }
                    else
                    {
        			    echo "$row[$i]";
    			    }
        			if ($i == 6){echo "% off";}
        			echo "</p>";
        			echo '</div>';
    		    }
    		    // if not in viewInventory, add input fields as the last column
    		    else if (!isset($_SESSION['view'])) 
    		    {
    		        echo "<div class=\"inv-price\" style=\"margin-left:3%;\"><input type=\"text\"name=\"$row[0]\"></div>";
    		    }
    		}
		
    		$count++;
		
    		echo '</div>';
        }
	
    	echo '<br>';
	
	    // Unset view or promotions sessions
    	if (isset($_SESSION['view'])) 
    	{
    		unset($_SESSION['view']);
    	} 
    	else if (isset($_SESSION['promotions'])) 
    	{
    		unset($_SESSION['promotions']);
    	}
	
    	// Close the database connection
    	if ($mysqli) 
    	{
    		$mysqli->close();
    	}
	}

?>		