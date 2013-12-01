<?php 

	session_start();
	
	header("Location: manageStock.php");
	
	// connect to database
	$mysqli = new mysqli("mysql.cs.uky.edu", "clef222", "Mtfbwy4;", "clef222");
	
	// check connection 
	if (mysqli_connect_errno()) 
	{
		printf("Failed to Connect: %s\n", mysqli_connect_error());
		return false;
	}
	
	// set up DB Query and execute it
	$r = $mysqli->query("SELECT itemId FROM Inventory");
	
	while ($item = $r->fetch_array()) 
	{
		if (isset($_POST[$item[0]])) 
		{
			if (intval($_POST[$item[0]]) > 0) 
			{
				$inc = intval($_POST[$item[0]]);
				
				$result = $mysqli->query("UPDATE Inventory SET quantity=quantity+'$inc'
				    WHERE itemId = '$item[0]'");
			}
		}
	}
	
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
			