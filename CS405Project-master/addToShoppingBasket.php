<?php 
	session_start();
	if (isset($_SESSION['privileges'])) {
		if (intval($_SESSION['privileges']) > 1) {
			header("Location: inventory.php");
		}
	} else {
	header("Location: loginForm.php");
	}
	header("Location: store.php");
	// connect to database
	$mysqli = new mysqli("mysql.cs.uky.edu", "clef222", "Mtfbwy4;", "clef222");
	
	// check connection 
	if (mysqli_connect_errno()) {
		printf("Connect failed: %s\n", mysqli_connect_error());
		return false;
	}
	
	
	// insert username into Shopping Basket as cID
	
	// set up DB Query and execute it
	$query = "SELECT itemId FROM Inventory";
	$result = $mysqli->query($query); // Execute the Query 
	
	while ($currItem = $result->fetch_array()) {
		if (isset($_POST[$currItem[0]])) {
		    $inc = intval($_POST[$currItem[0]]);
			if ($inc > 0) {
				
				$query="Select * From ShoppingBasket Where cID='$_SESSION[username]' AND itemId='$currItem[0]'";
				$result2 = $mysqli->query($query);
				
				if ($result2->num_rows>0 )  // item exists in cart update quantity
				{
				    $update = "UPDATE ShoppingBasket SET amount=amount+'$inc' WHERE itemId =                
				        '$currItem[0]' AND cID='$_SESSION[username]'";
				    $result2 = $mysqli->query($update);
				    
				} else {   // does not exist, insert into shopping cart
				    $insert = "INSERT INTO ShoppingBasket VALUES 
				        ('$_SESSION[username]','$currItem[0]','$inc')";
				    $result2 = $mysqli->query($insert);
				    
				}
				
//				$updateResult = $mysqli->query($update);
//				if ($updateResult != 1) {
					//error
//				}
			}
		}
	}
	
	if ($result) {
		$result->close();
	}
	
	// close the connection
	if ($mysqli) {
		$mysqli->close();
	}
	
	
	
?> 

