<?php 
    
    // Start session if not active
	session_start();
	
	// Redirect to Shopping Basket
	header("Location: shoppingBasket.php");
	
	// Connect to the database
	$mysqli = new mysqli("mysql.cs.uky.edu", "mage223", "u0688279", "mage223");
	
	// Check database connection for error
	if (mysqli_connect_errno()) 
	{
		return false;
	}
	
	// Delete the item from the Basket table
	$r = $mysqli->query("DELETE FROM Basket WHERE cID='$_SESSION[username]' AND
	     itemNumber='$_POST[itemNumber]'");
	
	// Close the database connection
	if ($mysqli) 
	{
		$mysqli->close();
	}
	
?> 

