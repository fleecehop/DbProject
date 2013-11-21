<?php 
	session_start();
	if (!isset($_SESSION['privileges'])) {
		header("Location: loginForm.php");
	} else if (intval($_SESSION['privileges']) < 2) {
			header("Location: store.php");
	} else {
		header("Location: manageInventory.php");
		addInventory();
}
			
	
function addInventory() {	
	header("Location: manageInventory.php");
	// connect to database
	$mysqli = new mysqli("mysql.cs.uky.edu", "clef222", "Mtfbwy4;", "clef222");
	
	// check connection 
	if (mysqli_connect_errno()) {
		printf("Connect failed: %s\n", mysqli_connect_error());
		return false;
	}
	if (empty($_POST['name']) || empty($_POST['description']) || empty($_POST['type']) || empty($_POST['amount']) || empty($_POST['price'])) {
		//error
		return false;
	}
	$query = "SELECT max(itemId) FROM Inventory";
	$result = $mysqli->query($query); // Execute the Query
	$id = 0;
	if ($result) {
		$row = $result->fetch_array();
		$id = intval($row[0]) + 1; 
		$result->close();
	}
	
	// set up DB Query and execute it
	$query = "INSERT INTO Inventory VALUES ('$id', '$_POST[name]', '$_POST[description]', '$_POST[type]', '$_POST[amount]', '$_POST[price]', '0')";
	$result = $mysqli->query($query); // Execute the Query 
	
	if ($result != 1) {
		//error
	} else {
		// no error
	}
	
	// close the connection
	if ($mysqli) {
		$mysqli->close();
	}
	}

?>
			