<?php 
  session_start();
if (isset($_SESSION['privileges'])) {
	if (intval($_SESSION['privileges']) > 1) {
		header("Location: inventory.php");
	}
	} else {
	header("Location: loginForm.php");
}
?> 

<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css">

<h2 class="div-padding">A & G Company</h2>
<title>Shopping Basket</title>
</head>

<div class="div-padding">    
    <div class="header-div" style="float:left; font-weight: bold;">
	    Welcome <?php 
    			if (isset($_SESSION['username'])) {
    				echo $_SESSION['username']; 
    				?>!
	</div>
	
	<div class="header-div" style="float:right;">
	    <a href="logout.php" class="menu-option">Log Out </a>
	    <a href="store.php" class="menu-option">Return To Store </a>
    	<a href="viewOrderHistory.php" class="menu-option">Order History </a>
    	
	</div>
	
	<?php }
	else {
		echo "Guest";
		?><br>
			<a href="loginForm.php">Log In </a><br> 	
			<a href="registrationForm.php">Register As New User </a> 
		<?php } ?><br>
</div>
		
<?php //include "message.php"?>

<?php

	// connect to database
	$mysqli = new mysqli("mysql.cs.uky.edu", "clef222", "Mtfbwy4;", "clef222");

	// check connection 
	if (mysqli_connect_errno()) {
		printf("Connect failed: %s\n", mysqli_connect_error());
		return false;
	}

	// set up DB Query and execute it

	$query = "SELECT I.itemId, I.name,I.description,I.promotion,B.amount,I.price FROM Inventory I, ShoppingBasket B WHERE I.itemId=B.itemId AND B.cID='$_SESSION[username]'";
	
	$result = $mysqli->query($query); // Execute the Query 
	
	if($result->num_rows <1){
	    echo '<h1 align="center" style="padding:25px;">';
	    echo "There is nothing in your basket.";
	    echo "</h1>";
	return false;
	}
	
	echo '<p align="center" class="header-line"><b>Shopping Basket</b></p>';
	
	/*
	echo "<table align=\"center\" border = 2 bgcolor=\"#F0F0F0\"><tr>";

	
	echo "<td>Name</td><td>Description</td><td>Type</td><td>Amount In Stock</td><td>Price</td><td>Promotion</td>";
	echo "<td>Quantity</td><td>Remove From Cart</td>";
	echo "</tr>";
	while ($row = $result->fetch_array()) {
			echo "<tr>"; 
			for ($i = 1; $i < $mysqli->field_count; $i++) {
				echo "<td>$row[$i]</td>";
			}
			echo "<form method=\"POST\"action=\"removeFromShoppingBasket.php\">";
			echo "<input type=\"hidden\" name=\"itemId\" value=\"$row[0]\">";
			echo "<td><input type=\"submit\"value=\"Remove\"></td></form>"; 
			echo "</tr>";
	}
	echo "</table>";
	*/
	
	echo '<h1 align="center">';
	echo "<br>";
	
	echo '<div class="div-inventory">';
	    
	    $j = 0;
	    
    	if (intval($_SESSION['privileges']) > 1) 
    	{
    		echo '<div class="inv-name" style="background-color: #F0F0F0;">';
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
	        echo '<p style="font-size:medium; text-transform: uppercase;">';
	            echo "<b>Name</b>";
	        echo '</p>';
	    echo '</div>';
	    
	    echo '<div class="inv-description" style="background-color: #F0F0F0;">';
	        echo '<p style="font-size:medium; text-transform: uppercase;">';
	            echo "<b>Description</b>";
	        echo '</p>';
	    echo '</div>';
	    
	    echo '<div class="inv-promo" style="background-color: #F0F0F0;">';
	        echo '<p style="font-size:medium; text-transform: uppercase;">';
	            echo "<b>Promotion</b>";
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
	    
	echo '</div><br>';
	
	$count = 0;
	
	while ($row = $result->fetch_array()) 
	{
	    echo '<div class="div-inventory">';
	    
	    for ($i = 1; $i < $mysqli->field_count + 1; $i++) 
	    {
	        $field = 1;
	        
	        switch ($i)
	        {
	            case 0:
	                echo '<div class="inv-name" style="';
	                break;
	            
	            case 1:
	                echo '<div class="inv-name" style="';
	                break;
	             
	            case 2:
	                echo '<div class="inv-description" style="';
	                break;
	            
	            case 3:
	                echo '<div class="inv-promo" style="';
	                break;
	            
	            case 4:
	                echo '<div class="inv-amount" style="';
	                break;
	                
	            case 5:
	                echo '<div class="inv-price" style="';
	                break;
	                
	            default:
	                $field = 0;
            }
            
            if ($i != $mysqli->field_count && $field == 1)
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
		        echo "<form method=\"POST\"action=\"removeFromShoppingBasket.php\">";
    			echo "<input type=\"hidden\" name=\"itemId\" value=\"$row[0]\">";
    			echo "<input type=\"submit\"value=\"Remove\"></form>";
		    }
		}
		
		$count++;
		
		echo '</div>';
    }
	
	echo '<br>';
	echo "</h1>";
	echo '<br>';
	
	?>
	<body>
	<?php //include "message.php"?>
	
	<form method="POST" action="addPendingOrder.php"> 
	    <div align="right" style="margin-right:25px;">
	        <input type="submit" value="Place Order">
	    </div>
	</form>
	
	</body>
	</html>
	
	
	<?php

	if ($result) {
		$result->close();
	}

	// close the connection
	if ($mysqli) {
		$mysqli->close();
	}





?> 
