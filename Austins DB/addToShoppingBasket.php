<?php 

    // Start a connection if one is not started
	session_start();
	
	// Set return location to customerInventory.php
	header("Location: customerInventory.php");
	
	// Connect to the Database
	$mysqli = new mysqli("mysql.cs.uky.edu", "mage223", "u0688279", "mage223");
	
	// Check for connection error 
	if (mysqli_connect_errno()) 
	{
		return false;
	}
	
	$r = $mysqli->query("SELECT itemNumber FROM Item"); // Execute the Query 
	
	// Loop through the items in Inventory
	while ($item = $r->fetch_array()) 
	{
	    // If the item's field was populated by the user
		if (isset($_POST[$item[0]])) 
		{
		    // Get the value of the field
		    $val = intval($_POST[$item[0]]);
		    
			if ($val > 0) 
			{
			    // Get the current items in the basket
				$r2 = $mysqli->query("SELECT * FROM Basket WHERE
				    cID='$_SESSION[username]' AND itemNumber='$item[0]'");
				
				// If the item is in the basket already
				if ($r2->num_rows > 0 )
				{
				    // Update the item in the Basket table
				    $r3 = $mysqli->query("UPDATE Basket SET amount=amount+'$val' WHERE
				         itemNumber = '$item[0]' AND cID='$_SESSION[username]'");
				    
				} 
				// If the item is not in the basket already
				else 
				{   
				    // Add the item to the Basket table
				    $r3 = $mysqli->query("INSERT INTO Basket VALUES
				         ('$_SESSION[username]','$item[0]','$val')");
				    
				}
			}
		}
	}
	
	// Close the database connection
	if ($mysqli) 
	{
		$mysqli->close();
	}
	
?> 

