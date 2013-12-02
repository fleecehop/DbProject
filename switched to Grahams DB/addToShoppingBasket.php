<?php 

	session_start();
	
	header("Location: customerInventory.php");
	
	// connect to database
	$mysqli = new mysqli("mysql.cs.uky.edu", "gttu222", "u0670864", "gttu222");
	
	// check connection 
	if (mysqli_connect_errno()) 
	{
		printf("Failed to Connect: %s\n", mysqli_connect_error());
		return false;
	}
	
	// insert username into Shopping Basket as cID
	
	// set up DB Query and execute it
	$r = $mysqli->query("SELECT itemNumber FROM Item"); // Execute the Query 
	
	while ($currItem = $r->fetch_array()) 
	{
		if (isset($_POST[$currItem[0]])) 
		{
		    $inc = intval($_POST[$currItem[0]]);
		    
			if ($inc > 0) 
			{
				$r2 = $mysqli->query("SELECT * FROM ShoppingBasket WHERE
				    cID='$_SESSION[username]' AND itemNumber='$currItem[0]'");
				
				if ($r2->num_rows > 0 )  // item exists in cart update quantity
				{
				    $r3 = $mysqli->query("UPDATE ShoppingBasket SET amount=amount+'$inc' WHERE
				         itemNumber = '$currItem[0]' AND cID='$_SESSION[username]'");
				    
				} 
				else 
				{   // does not exist, insert into shopping cart
				    $r3 = $mysqli->query("INSERT INTO ShoppingBasket VALUES
				         ('$_SESSION[username]','$currItem[0]','$inc')");
				    
				}
			}
		}
	}
	
	if ($result) {
		$result->close();
	}
	
	// close the connection
	if ($mysqli) {
		$mysqli->close();
	}
	
	
	
?> 

