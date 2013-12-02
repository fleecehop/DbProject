<?php 

    // Start session if not active
	session_start();
	
	// Redirect to Pending Orders screen
	header("Location: pendingOrders.php");
	
    // Connect to the database
	$mysqli = new mysqli("mysql.cs.uky.edu", "mage223", "u0688279", "mage223");

	// Check database connection for error
	if (mysqli_connect_errno()) 
	{
		return false;
	}
	
	// Get itemNumbers and amounts from Basket table     
	$r = $mysqli->query("SELECT itemNumber, amount FROM Contains WHERE
	     orderID = '$_POST[orderID]'");
	
	// For every item in the basket
	while ($row = $r->fetch_array()) 
	{
	    // Update the quantity in the Item table
		if (($update = $mysqli->query("UPDATE Item SET amount = amount - 
		    '$row[1]' WHERE itemNumber = '$row[0]'")) != 1) 
		{
		    // If the update failed, print error
			$_SESSION['error'] = $_SESSION['error']."Item ID $row[0] was not updated.<br>";
		}
	}
	
	// Update the Orders table with the order
	if (($update = $mysqli->query("UPDATE Orders SET status=TRUE, dateShipped = 
	    CURRENT_TIMESTAMP WHERE orderID = '$_POST[orderID]'")) != 1) 
	{
	    // If the update failed, print error
		$_SESSION['error'] = $_SESSION['error']."Ship failed for ID: $_POST[orderID].<br>";
	}
	
	// Close the database connection
	if ($mysqli) 
	{
		$mysqli->close();
	}
	
?>