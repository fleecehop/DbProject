<?php 

	if (!isset($_SESSION['privileges'])) 
	{
		header("Location: index.php");
	}
	else 
	{
		// connect to database
	    $mysqli = new mysqli("mysql.cs.uky.edu", "clef222", "Mtfbwy4;", "clef222");
	
    	// check connection 
    	if (mysqli_connect_errno()) 
    	{
    		printf("Failed to Connect: %s\n", mysqli_connect_error());
    		return false;
	    }
	
	    // set up DB Query and execute it
    	$result = $mysqli->query("SELECT * FROM Inventory");
	
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
    		        echo "<div class=\"inv-price\" style=\"margin-left:3%;\"><input type=\"text\"name=\"$row[0]\"></div>";
    		    }
    		}
		
    		$count++;
		
    		echo '</div>';
        }
	
    	echo '<br>';
	
    	if (isset($_SESSION['view'])) 
    	{
    		unset($_SESSION['view']);
    	} 
    	else if (isset($_SESSION['promotions'])) 
    	{
    		unset($_SESSION['promotions']);
    	}
	
    	if ($result) 
    	{
    		$result->close();
    	}
	
    	// close the connection
    	if ($mysqli) 
    	{
    		$mysqli->close();
    	}
	}

?>		