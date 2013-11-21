<?php 
  session_start();
	if (!isset($_SESSION['privileges'])) {
		header("Location: loginForm.php");
	} else {
		header("Location: shoppingBasket.php");
		addInventory();
}


function addInventory() {	
	// connect to database
	$mysqli = new mysqli("mysql.cs.uky.edu", "clef222", "Mtfbwy4;", "clef222");

	// check connection 
	if (mysqli_connect_errno()) {
		printf("Connect failed: %s\n", mysqli_connect_error());
		return false;
	}
	//if (empty($_POST['name']) || empty($_POST['description']) || empty($_POST['type']) || empty($_POST['amount']) || empty($_POST['price'])) {
		//error
		//return false;
	//}
	$query = "SELECT max(orderNum) FROM Orders";
	$result = $mysqli->query($query); // Execute the Query
	$id = 0;
	if ($result) {
		$row = $result->fetch_array();
		$id = intval($row[0]) + 1; 
		$result->close();
	}
	$query = "SELECT sum(s.amount*(i.price-i.price*(i.promotion/100))) FROM Inventory i, ShoppingBasket s WHERE s.cID='$_SESSION[username]' AND i.itemId=s.itemId";
	$result= $mysqli->query($query);
	$total = $result->fetch_array();
	$result->close();
	
	$query = "INSERT INTO Orders VALUES ('$id',FALSE,NULL,'$total[0]')";
	$result = $mysqli->query($query); // Execute the Query
	
	$query = "INSERT INTO CustomerPlacesOrder VALUES ('$_SESSION[username]','$id')";
	$result = $mysqli->query($query);
	
	// check if returns -1
	$query = "SELECT B.itemId, B.amount FROM ShoppingBasket B WHERE cID = '$_SESSION[username]'";
	$result = $mysqli->query($query); // Execute the Query
	while($row=$result->fetch_array()){
	
	
	$query = "INSERT INTO OrderContainsItem VALUES ('$id','$row[0]','$row[1]')";
	$insert = $mysqli->query($query); // Execute the Query
	
	
	
	if ($insert != 1) {
	//error
	}
	}
	
	$query = "DELETE FROM ShoppingBasket WHERE cID='$_SESSION[username]'";
	$result = $mysqli->query($query);
	
	if ($result) {
	$result->close();
	}

	// close the connection
	if ($mysqli) {
		$mysqli->close();
	}
	}

	$_SESSION['message']="Your Order Was Sucessfully Placed";
?>
