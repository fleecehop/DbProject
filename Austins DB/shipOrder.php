<?php 

	session_start();
	
	header("Location: pendingOrders.php");
	
    // connect to database
	$mysqli = new mysqli("mysql.cs.uky.edu", "mage223", "u0688279", "mage223");

	// check connection 
	if (mysqli_connect_errno()) 
	{
		printf("Connect failed: %s\n", mysqli_connect_error());
		return false;
	}
	     
	$result = $mysqli->query("SELECT itemNumber, amount FROM Contains WHERE
	     orderID = '$_POST[orderID]'");
	
	while ($row = $result->fetch_array()) 
	{
		if (($update = $mysqli->query("UPDATE Item SET amount = amount - 
		    '$row[1]' WHERE itemNumber = '$row[0]'")) != 1) 
		{
			$_SESSION['error'] = $_SESSION['error']."Item ID $row[0] was not updated.<br>";
		}
	}
	
	if (($update = $mysqli->query("UPDATE Orders SET status=TRUE, dateShipped = 
	    CURRENT_TIMESTAMP WHERE orderID = '$_POST[orderID]'")) != 1) 
	{
			$_SESSION['error'] = $_SESSION['error']."Could not ship $_POST[orderID].<br>";
	}
	
?>