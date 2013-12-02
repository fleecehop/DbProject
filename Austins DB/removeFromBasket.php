<?php 

	session_start();
	
	header("Location: shoppingBasket.php");
	
	// connect to database
	$mysqli = new mysqli("mysql.cs.uky.edu", "mage223", "u0688279", "mage223");
	
	// check connection 
	if (mysqli_connect_errno()) 
	{
		printf("Failed to Connect: %s\n", mysqli_connect_error());
		return false;
	}
	
	// set up DB Query and execute it
	$r = $mysqli->query("DELETE FROM Basket WHERE cID='$_SESSION[username]' AND
	     itemNumber='$_POST[itemNumber]'");
	
	if ($r) 
	{
		$r->close();
	}
	
	// close the connection
	if ($mysqli) 
	{
		$mysqli->close();
	}
	
?> 

