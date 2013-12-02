<?php 

	session_start();
	
	if (!isset($_SESSION['privilege'])) 
	{
		header("Location: index.php");
	}
	else if (intval($_SESSION['privilege']) < 2) 
	{
		header("Location: customerInventory.php");
	} 
	else 
	{
		header("Location: pendingOrders.php");
		
	    // connect to database
    	$mysqli = new mysqli("mysql.cs.uky.edu", "gttu222", "u0670864", "gttu222");
	
    	// check connection 
    	if (mysqli_connect_errno()) 
    	{
    		printf("Connect failed: %s\n", mysqli_connect_error());
    		return false;
    	}
    	
    	$r = $mysqli->query("SELECT i.itemNumber FROM Item i, Orders o,
    	     Contains oc WHERE o.orderID = '$_POST[orderID]' AND oc.orderID =
    	     '$_POST[orderID]' AND i.itemNumber = oc.itemNumber AND i.quantity < oc.amount");
    	     
    	if ($r->num_rows > 0) {
    		$_SESSION['error'] = $_SESSION['error']."Error: There are not enough items in stock for the following:<br>"; 
    		
    		while ($row = $r->fetch_array()) 
    		{
    			$_SESSION['error'] = $_SESSION['error']."- Item ID: $row[0]<br>"; 
    		}
    		
    		return false;
    	} 
    	else 
    	{
    		$result = $mysqli->query("SELECT itemNumber, amount FROM Contains WHERE
    		     orderID = '$_POST[orderID]'");
    		
    		while ($row = $result->fetch_array()) 
    		{
    			if (($update = $mysqli->query("UPDATE Item SET quantity = quantity - 
    			    '$row[1]' WHERE itemNumber = '$row[0]'")) != 1) 
    			{
    				$_SESSION['error'] = $_SESSION['error']."Error: Item ID $row[0] was not updated.<br>";
    			}
    		}
    		
    		if ($r) 
    		{
    			$r->close();
    		}
    		
    		if (($update = $mysqli->query("UPDATE Orders SET status=TRUE, dateShipped = 
    		    CURRENT_TIMESTAMP WHERE orderID = '$_POST[orderID]'")) != 1) 
    		{
    				$_SESSION['error'] = $_SESSION['error']."Error: Error shipping $_POST[orderID].<br>";
    		}
		
    	}
	}
?>