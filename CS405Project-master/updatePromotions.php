<?php 
	session_start();
	if (!isset($_SESSION['privileges'])) {
		header("Location: loginForm.php");
	} else if (intval($_SESSION['privileges']) < 3) {
			header("Location: store.php");
	} else {
		header("Location: managePromotions.php");
		updatePromotions();
	}
	
	function updatePromotions() {
	// connect to database
	$mysqli = new mysqli("mysql.cs.uky.edu", "clef222", "Mtfbwy4;", "clef222");
	
	// check connection 
	if (mysqli_connect_errno()) {
		printf("Connect failed: %s\n", mysqli_connect_error());
		$_SESSION['error'] = $_SESSION['error']."Database Error: Unable to connect to the mySQL Database.<br>"; 
		return false;
	}
	
	// set up DB Query and execute it
	$query = "SELECT itemId FROM Inventory";
	$result = $mysqli->query($query); // Execute the Query 
	
	while ($currItem = $result->fetch_array()) {
		if (is_numeric($_POST[$currItem[0]])) {
				$inc = intval($_POST[$currItem[0]]);
				if ($inc < 0 || $inc > 100) {
					$_SESSION['error'] = $_SESSION['error']."Error: Promotion rate must be between 0 and 100. Promotion was not updated for ItemID: $currItem[0]<br>";
				} else {
					$update = "UPDATE Inventory SET promotion='$inc' WHERE itemId = '$currItem[0]'";
					$updateResult = $mysqli->query($update);
					if ($updateResult != 1) {
						$_SESSION['error'] = $_SESSION['error']."Error: Promotion was not updated for ItemID: $currItem[0]<br>"; 
					} else {
						$_SESSION['message'] = $_SESSION['message']."Success: Promotion was updated for ItemID: $currItem[0]<br>"; 
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