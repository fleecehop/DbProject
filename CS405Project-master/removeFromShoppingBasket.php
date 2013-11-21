<?php 
	session_start();
	if (isset($_SESSION['privileges'])) {
		if (intval($_SESSION['privileges']) > 1) {
			header("Location: inventory.php");
		}
	} else {
	header("Location: loginForm.php");
	}
	header("Location: shoppingBasket.php");
	// connect to database
	$mysqli = new mysqli("mysql.cs.uky.edu", "clef222", "Mtfbwy4;", "clef222");
	
	// check connection 
	if (mysqli_connect_errno()) {
		printf("Connect failed: %s\n", mysqli_connect_error());
		return false;
	}
	
	
	// insert username into Shopping Basket as cID
	
	// set up DB Query and execute it
	$query = "DELETE FROM ShoppingBasket WHERE cID='$_SESSION[username]' AND itemId='$_POST[itemId]' ";
	$result = $mysqli->query($query); // Execute the Query 
	
	
	
	if ($result) {
		$result->close();
	}
	
	// close the connection
	if ($mysqli) {
		$mysqli->close();
	}
	
	
	
?> 

