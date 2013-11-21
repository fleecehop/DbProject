<?php 
	session_start();
	if (!isset($_SESSION['privileges'])) {
		header("Location: loginForm.php");
	}
	else if (intval($_SESSION['privileges']) < 2) {
		header("Location: store.php");
	} else {
		header("Location: pendingOrders.php");
		shipOrder();
	}
	
	function shipOrder() {
	// connect to database
	$mysqli = new mysqli("mysql.cs.uky.edu", "clef222", "Mtfbwy4;", "clef222");
	
	// check connection 
	if (mysqli_connect_errno()) {
		printf("Connect failed: %s\n", mysqli_connect_error());
		return false;
	}
	
	$query = "SELECT i.itemId FROM Inventory i, Orders o, OrderContainsItem oc WHERE 
				o.orderNum = '$_POST[orderNum]' AND oc.orderNum = '$_POST[orderNum]' AND
				 i.itemId = oc.itemId AND i.quantity < oc.amount";
	$result = $mysqli->query($query);
	if ($result->num_rows > 0) {
		$_SESSION['error'] = $_SESSION['error']."Error: There are not enough items in stock. The following items must be restocked before the shipment can be processed<br>"; 
		while ($row = $result->fetch_array()) {
			$_SESSION['error'] = $_SESSION['error']."- Item ID: $row[0]<br>"; 
		}
		return false;
	} else {
		$query = "SELECT itemId, amount FROM OrderContainsItem WHERE orderNum = '$_POST[orderNum]'";
		$result = $mysqli->query($query);
		while ($row = $result->fetch_array()) {
			$query = "Update Inventory SET quantity=quantity-'$row[1]' WHERE itemId = '$row[0]'";
			;
			if (($update = $mysqli->query($query)) != 1) {
				$_SESSION['error'] = $_SESSION['error']."Error: Item ID $row[0] was unsucessfully updated in the database.<br>";
			}
		}
		if ($result) {
			$result->close();
		}
		$query = "UPDATE Orders SET shipStatus=TRUE, shipDate=CURRENT_TIMESTAMP WHERE orderNum = '$_POST[orderNum]'";
		if (($update = $mysqli->query($query)) != 1) {
				$_SESSION['error'] = $_SESSION['error']."Error: Error shipping $_POST[orderNum].<br>";
		}
		
		//check update
		
	}
	}
?>