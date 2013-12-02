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
		header("Location: manageStock.php");

    	$mysqli = new mysqli("mysql.cs.uky.edu", "gttu222", "u0670864", "gttu222");
	
    	if (mysqli_connect_errno()) 
    	{
    		printf("Failed to Connect: %s\n", mysqli_connect_error());
    		
    		return false;
    	}
    	
    	if (empty($_POST['name']) || empty($_POST['description']) 
    	    || empty($_POST['type']) || empty($_POST['amount']) || empty($_POST['price'])) 
    	{
    		return false;
    	}
    	
    	$r = $mysqli->query("SELECT max(itemNumber) FROM Item");
    	
    	$id = 0;
    	
    	if ($r) 
    	{
    		$row = $r->fetch_array();
    		$id = intval($row[0]) + 1; 
    		$r->close();
    	}
    	    
    	$r = $mysqli->query("INSERT INTO Item VALUES ('$id', '$_POST[name]',
    	    '$_POST[description]', '$_POST[type]', '$_POST[amount]', '$_POST[price]', '0')");
	
    	if ($mysqli) 
    	{
    		$mysqli->close();
    	}
    }

?>
			