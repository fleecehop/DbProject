<?php 

	session_start();
	
	if (!isset($_SESSION['privileges'])) 
	{
		header("Location: index.php");
	}
	else if (intval($_SESSION['privileges']) < 2) 
	{
		header("Location: customerInventory.php");
	} 
	else 
	{
		header("Location: pendingOrders.php");
		
	    // connect to database
    	$mysqli = new mysqli("mysql.cs.uky.edu", "clef222", "Mtfbwy4;", "clef222");
	
    	// check connection 
    	if (mysqli_connect_errno()) 
    	{
    		printf("Connect failed: %s\n", mysqli_connect_error());
    		return false;
    	}
    	
    	$r = $mysqli->query("SELECT i.itemId FROM Inventory i, Orders o,
    	     OrderContainsItem oc WHERE o.orderNum = '$_POST[orderNum]' AND oc.orderNum =
    	     '$_POST[orderNum]' AND i.itemId = oc.itemId AND i.quantity < oc.amount");
    	     
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
    		$result = $mysqli->query("SELECT itemId, amount FROM OrderContainsItem WHERE
    		     orderNum = '$_POST[orderNum]'");
    		
    		while ($row = $result->fetch_array()) 
    		{
    			if (($update = $mysqli->query("UPDATE Inventory SET quantity = quantity - 
    			    '$row[1]' WHERE itemId = '$row[0]'")) != 1) 
    			{
    				$_SESSION['error'] = $_SESSION['error']."Error: Item ID $row[0] was not updated.<br>";
    			}
    		}
    		
    		if ($r) 
    		{
    			$r->close();
    		}
    		
    		if (($update = $mysqli->query("UPDATE Orders SET shipStatus=TRUE, shipDate = 
    		    CURRENT_TIMESTAMP WHERE orderNum = '$_POST[orderNum]'")) != 1) 
    		{
    				$_SESSION['error'] = $_SESSION['error']."Error: Error shipping $_POST[orderNum].<br>";
    		}
		
    	}
	}
?>