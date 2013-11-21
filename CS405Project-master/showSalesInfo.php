<?php 

	if (!isset($_SESSION['privileges'])) {
		header("Location: loginForm.php");
	} else if (intval($_SESSION['privileges']) < 3) {
		header("Location: store.php");
	}
	else if (!isset($_POST['time'])) {
		// do nothing
	} else {
	// connect to database
	$mysqli = new mysqli("mysql.cs.uky.edu", "clef222", "Mtfbwy4;", "clef222");
	
	// check connection 
	if (mysqli_connect_errno()) {
		printf("Connect failed: %s\n", mysqli_connect_error());
		return false;
	}
	echo "<b>Sales Statistics";
	// set up DB Query and execute it
	$query = "SELECT orderNum, shipDate, total FROM Orders";
	if ($_POST['time'] == "week") {
		$query = $query." WHERE shipDate > DATE_SUB(CURDATE(), INTERVAL 1 WEEK)";
		echo " for the past $_POST[time]";
	} else if ($_POST['time'] == "month") {
		$query = $query." WHERE shipDate > DATE_SUB(CURDATE(), INTERVAL 1 MONTH)";
		echo " for the past $_POST[time]";
	} else if ($_POST['time'] == "year") {
		$query = $query." WHERE shipDate > DATE_SUB(CURDATE(), INTERVAL 1 YEAR)";
		echo " for the past $_POST[time]";	
	}
	
	$result = $mysqli->query($query); // Execute the Query 
	
	echo "<br><br><b>Orders</b><br><br>";
	while ($row = $result->fetch_array()) {
		echo "Order #: $row[0]<br>Ship Date: $row[1]<br>Total: $$row[2]<br>";
		$query = "SELECT u.id FROM Users u, CustomerPlacesOrder c WHERE c.orderNum ='$row[0]' AND c.cId = u.id";
		$custResult = $mysqli->query($query);
		$customer = $custResult->fetch_array();
		echo "Customer ID: $customer[0]<br>Order Info:<br>"; 
		echo "<table border = 1><tr>";
		echo "<td>ID</td><td>Name</td><td>Order Amount</td></tr>";
		$query = "SELECT i.itemId, i.name, oc.amount FROM 
					Inventory i, OrderContainsItem oc WHERE orderNum = '$row[0]' AND oc.itemId = i.itemId";
		$orderItems = $mysqli->query($query);
		while ($r = $orderItems->fetch_array()) {
			echo "<tr>"; 
			for ($i = 0; $i < $mysqli->field_count; $i++) {
				echo "<td>$r[$i]</td>";
			}
			echo "</tr>";
		}
		if ($r) {
			$r->close();
		}
		echo "</table><br><br>";
	}
	
	if ($result) {
		$result->close();
	}
	
	$query = "SELECT count(orderNum), sum(total) FROM Orders";
	if ($_POST['time'] == "week") {
		$query = $query." WHERE shipDate > DATE_SUB(CURDATE(), INTERVAL 1 WEEK)";
	} else if ($_POST['time'] == "month") {
		$query = $query." WHERE shipDate > DATE_SUB(CURDATE(), INTERVAL 1 MONTH)";
	} else if ($_POST['time'] == "month") {
		$query = $query." WHERE shipDate > DATE_SUB(CURDATE(), INTERVAL 1 YEAR)";
	}
	$result = $mysqli->query($query); // Execute the Query 
	if ($result) {
		$row = $result->fetch_array();
		echo "<br><b>Statistics</b><br>Number of Orders: $row[0] <br> Total Sales: $$row[1]<br><br>";
		$result->close();
	}		
	
	// close the connection
	if ($mysqli) {
		$mysqli->close();
	}
	}
?>