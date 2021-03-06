<?php 

    session_start();
  
	if (!isset($_SESSION['privileges'])) 
	{
		header("Location: index.php");
	} 
	
	else 
	{
		header("Location: shoppingBasket.php");

    	$mysqli = new mysqli("mysql.cs.uky.edu", "clef222", "Mtfbwy4;", "clef222");

    	if (mysqli_connect_errno()) 
    	{
    		printf("Failed to connect: %s\n", mysqli_connect_error());
    		
    		return false;
    	}
    	
    	$r = $mysqli->query("SELECT max(orderNum) FROM Orders");
    	
    	$id = 0;
    	
    	if ($r) 
    	{
    		$row = $r->fetch_array();
    		$id = intval($row[0]) + 1; 
    		$r->close();
    	}
    	
    	$r= $mysqli->query("SELECT sum(s.amount*(i.price-i.price*(i.promotion/100))) 
    	    FROM Inventory i, ShoppingBasket s WHERE s.cID='$_SESSION[username]' AND
    	    i.itemId=s.itemId");
    	    
    	$total = $r->fetch_array();
    	
    	$r->close();
	
    	$r = $mysqli->query("INSERT INTO Orders VALUES ('$id',FALSE,NULL,'$total[0]')");
	
    	$r = $mysqli->query("INSERT INTO CustomerPlacesOrder VALUES
    	     ('$_SESSION[username]','$id')");
	
    	$r = $mysqli->query("SELECT B.itemId, B.amount FROM ShoppingBasket B WHERE cID = 
    	    '$_SESSION[username]'");
    	    
    	while($row = $r->fetch_array())
    	{
        	$i = $mysqli->query("INSERT INTO OrderContainsItem VALUES
        	     ('$id','$row[0]','$row[1]')");
    	}
	
    	$r = $mysqli->query("DELETE FROM ShoppingBasket WHERE
    	     cID='$_SESSION[username]'");
	
    	if ($r) 
    	{
    	    $r->close();
    	}

    	// close the connection
    	if ($mysqli) 
    	{
    		$mysqli->close();
    	}

    	$_SESSION['message']="Successfully Placed Order!";
	
    }
    
?>
