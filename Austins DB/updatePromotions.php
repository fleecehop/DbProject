<?php 

    // Start session if not active
	session_start();
	
	// Redirect to managePromotions.php
    header("Location: managePromotions.php");
	
	// Connect to the database
	$mysqli = new mysqli("mysql.cs.uky.edu", "mage223", "u0688279", "mage223");
	
	// Check the database connection for error
	if (mysqli_connect_errno()) 
	{
		return false;
	}
	
	// Select all items
	$r = $mysqli->query("SELECT itemNumber FROM Item");
	
	// For every item
	while ($item = $r->fetch_array()) 
	{
	    // If the value is a number
		if (is_numeric($_POST[$item[0]])) 
		{
		    
				$val = intval($_POST[$item[0]]);
				
				// If the number is not between 0 and 100
				if ($val < 0 || $val > 100) 
				{
					$_SESSION['error'] = $_SESSION['error']."Promotion rate must be between 0 and 100.<br>";
				} 
				else 
				{
				    $ID = $item[0];
				    
				    // Update Item tablw with new promotion rate
					$result = $mysqli->query("UPDATE Item SET promotion='$val' WHERE
					    itemNumber = $ID");
					 
					// Display success or failure message    
					if ($result != 1) 
					{
						$_SESSION['error'] = $_SESSION['error']."Promotion rate was not updated for Item ID: $ID<br>"; 
					} 
					else 
					{
						$_SESSION['message'] = $_SESSION['message']."Promotion rate was updated for Item ID: $ID<br>"; 
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