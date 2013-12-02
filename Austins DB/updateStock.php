<?php 

    // Start session if not active
	session_start();
	
	// Redirect to manageStock.php
	header("Location: manageStock.php");
	
	// Connect to the database
	$mysqli = new mysqli("mysql.cs.uky.edu", "mage223", "u0688279", "mage223");
	
	// Check the database connection 
	if (mysqli_connect_errno()) 
	{
		return false;
	}
	
	// Get all items
	$r = $mysqli->query("SELECT itemNumber FROM Item");
	
	// For every item
	while ($item = $r->fetch_array()) 
	{
	    // If a value was input for this item
		if (isset($_POST[$item[0]])) 
		{
		    // If the value is greater than 0
			if (intval($_POST[$item[0]]) > 0) 
			{
				$val = intval($_POST[$item[0]]);
				
				$result = $mysqli->query("UPDATE Item SET amount = amount + '$val'
				    WHERE itemNumber = '$item[0]'");
			}
		}
	}
	
	// Close the database connection
	if ($mysqli) 
	{
		$mysqli->close();
	}
?>
			