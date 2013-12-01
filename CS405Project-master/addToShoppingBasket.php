<?php 

	session_start();
	
	header("Location: store.php");
	
	// connect to database
	$mysqli = new mysqli("mysql.cs.uky.edu", "clef222", "Mtfbwy4;", "clef222");
	
	// check connection 
	if (mysqli_connect_errno()) 
	{
		printf("Connect failed: %s\n", mysqli_connect_error());
		return false;
	}
	
	// insert username into Shopping Basket as cID
	
	// set up DB Query and execute it
	$r = $mysqli->query("SELECT itemId FROM Inventory"); // Execute the Query 
	
	while ($currItem = $r->fetch_array()) 
	{
		if (isset($_POST[$currItem[0]])) 
		{
		    $inc = intval($_POST[$currItem[0]]);
		    
			if ($inc > 0) 
			{
				$r2 = $mysqli->query("SELECT * FROM ShoppingBasket WHERE
				    cID='$_SESSION[username]' AND itemId='$currItem[0]'");
				
				if ($r2->num_rows > 0 )  // item exists in cart update quantity
				{
				    $r3 = $mysqli->query("UPDATE ShoppingBasket SET amount=amount+'$inc' WHERE
				         itemId = '$currItem[0]' AND cID='$_SESSION[username]'");
				    
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

