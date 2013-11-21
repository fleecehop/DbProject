<?php 
	session_start();
	if (!isset($_SESSION['privileges'])) {
		header("Location: loginForm.php");
	} else if (intval($_SESSION['privileges']) < 2) {
			header("Location: store.php");
	} else {
	header("Location: manageInventory.php");
	// connect to database
	$mysqli = new mysqli("mysql.cs.uky.edu", "clef222", "Mtfbwy4;", "clef222");
	
	// check connection 
	if (mysqli_connect_errno()) {
		printf("Connect failed: %s\n", mysqli_connect_error());
		return false;
	}
	
	// set up DB Query and execute it
	$query = "SELECT itemId FROM Inventory";
	$result = $mysqli->query($query); // Execute the Query 
	
	while ($currItem = $result->fetch_array()) {
		if (isset($_POST[$currItem[0]])) {
			if (intval($_POST[$currItem[0]]) > 0) {
				$inc = intval($_POST[$currItem[0]]);
				$update = "UPDATE Inventory SET quantity=quantity+'$inc' WHERE itemId = '$currItem[0]'";
				$updateResult = $mysqli->query($update);
				if ($updateResult != 1) {
					//error
				}
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
	}

?>
			