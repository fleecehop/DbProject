<?php 

	session_start();
	
    header("Location: managePromotions.php");
	
	// connect to database
	$mysqli = new mysqli("mysql.cs.uky.edu", "gttu222", "u0670864", "gttu222");
	
	// check connection 
	if (mysqli_connect_errno()) 
	{
		printf("Failed to Connect: %s\n", mysqli_connect_error());
		
		return false;
	}
	
	// set up DB Query and execute it
	$r = $mysqli->query("SELECT itemNumber FROM Item"); // Execute the Query 
	
	while ($item = $r->fetch_array()) 
	{
		if (is_numeric($_POST[$item[0]])) 
		{
				$inc = intval($_POST[$item[0]]);
				
				if ($inc < 0 || $inc > 100) 
				{
					$_SESSION['error'] = $_SESSION['error']."Error: Promotion rate must be between 0 and 100. Promotion was not updated for ItemID: $currItem[0]<br>";
				} 
				else 
				{
				    $ID = $item[0];
				    
					$result = $mysqli->query("UPDATE Item SET promotion='$inc' WHERE
					    itemNumber = $ID");
					    
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
	
	if ($result) 
	{
		$result->close();
	}
	
	// close the connection
	if ($mysqli) 
	{
		$mysqli->close();
	}

?>		