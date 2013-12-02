<?php 

    // Start the session if it isn't already started
    session_start();
  
    // If a user is not logged in
	if (!isset($_SESSION['username'])) 
	{
	    // Go to login screen
		header("Location: index.php");
	} 
	else 
	{
	    // Go to Shopping Basket
		header("Location: shoppingBasket.php");

        // Connect to the database
    	$mysqli = new mysqli("mysql.cs.uky.edu", "mage223", "u0688279", "mage223");

        // Check for database connection failure
    	if (mysqli_connect_errno()) 
    	{
    		return false;
    	}
    	
    	// Get the latest ID for uniqueness
    	$r = $mysqli->query("SELECT max(orderID) FROM Orders");
    	
    	// If an ID exists
    	if ($r) 
    	{
    	    // Get an ID that is one above the greatest
    		$r2 = $r->fetch_array();
    		$id = intval($r2[0]) + 1;
    	}
    	// If it is the first item being added
    	else
    	{
    	    $id = 0;
    	}
    	
    	// Get the price with the promotion discount
    	$r= $mysqli->query("SELECT sum( b.amount * (i.price - i.price * (i.promotion/100))) 
    	    FROM Item i, Basket b WHERE b.cID = '$_SESSION[username]' AND
    	    i.itemNumber = b.itemNumber");
    	    
    	$total = $r->fetch_array();
	
	    // Insert Order into database
    	$r = $mysqli->query("INSERT INTO Orders VALUES ('$id', FALSE, NULL, '$total[0]')");
	
	    // Insert values into Places relation
    	$r = $mysqli->query("INSERT INTO Places VALUES ('$_SESSION[username]', '$id')");
	
	    // Get the items and amount for the order
    	$r = $mysqli->query("SELECT B.itemNumber, B.amount FROM Basket B WHERE cID = 
    	    '$_SESSION[username]'");
    	 
    	// Insert order and item relation into Contains table   
    	while($row = $r->fetch_array())
    	{
        	$i = $mysqli->query("INSERT INTO Contains VALUES
        	     ('$id','$row[0]','$row[1]')");
    	}
	
	    // Delete the order from the Shopping Basket
    	$r = $mysqli->query("DELETE FROM Basket WHERE cID='$_SESSION[username]'");

    	// close the connection
    	if ($mysqli) 
    	{
    		$mysqli->close();
    	}

    	$_SESSION['message']="Successfully Placed Order!";
	
    }
    
?>
