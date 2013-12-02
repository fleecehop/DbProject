<?php 

    // Start the session if not active
	session_start();
	
	// Set return location to manageStock.php
	header("Location: manageStock.php");

    // Connect to database
	$mysqli = new mysqli("mysql.cs.uky.edu", "mage223", "u0688279", "mage223");

    // Check for database connection error
	if (mysqli_connect_errno()) 
	{
		return false;
	}
	
	// If any of the fields are empty, do nothing
	if (empty($_POST['name']) || empty($_POST['description']) || empty($_POST['type']) || empty($_POST['price']) || empty($_POST['amount'])) 
	{
		return false;
	}
	
	// Get the highest itemID
	$r = $mysqli->query("SELECT max(itemNumber) FROM Item");
	
	// If an itemID was found
	if ($r) 
	{
	    // Set the itemID to the next greatest
		$row = $r->fetch_array();
		$id = intval($row[0]) + 1; 
	}
	// If it's the first itemID
	else
	{
	    $id = 0;
	}
	   
	// Use the itemID and the values from the fields and insert into Item table 
	$r = $mysqli->query("INSERT INTO Item VALUES ('$id', '$_POST[name]',
	    '$_POST[description]', '$_POST[type]', '$_POST[amount]', '$_POST[price]', '0')");

    // Close the Database connection
	if ($mysqli) 
	{
		$mysqli->close();
	}

?>
			