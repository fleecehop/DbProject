<?php 
	if (!isset($_SESSION['privileges'])) {
		header("Location: loginForm.php");
	} else if (intval($_SESSION['privileges']) > 1) {
		header("Location: viewInventory.php");
	} else {
	// connect to database
	$mysqli = new mysqli("mysql.cs.uky.edu", "clef222", "Mtfbwy4;", "clef222");
	
	// check connection 
	if (mysqli_connect_errno()) {
		printf("Connect failed: %s\n", mysqli_connect_error());
		return false;
	}
	echo "<b>All Orders For $_SESSION[username]</b>";
	// set up DB Query and execute it
	$query = "SELECT o.orderNum, o.total FROM Orders o, CustomerPlacesOrder c WHERE o.shipStatus =FALSE AND c.cID = '$_SESSION[username]' AND c.orderNum = o.orderNum";
	$result = $mysqli->query($query); // Execute the Query 
	
	echo "<br><br><b>Pending Orders</b><br><br>";
	while ($row = $result->fetch_array()) {
		echo "Order Number: $row[0]    Total: $$row[1]";
		echo "<table align=\"center\" border = 2 bgcolor=\"#F0F0F0\"><tr>";
		echo "<td>Name</td><td>Order Amount</td><td>Price</td><td>Promotion</td></tr>";
		$query = "SELECT i.name, oc.amount, i.price, i.promotion FROM 
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
		echo "</table><br>";
	}
	if ($result) {
		$result->close();
	}
	
	$query = "SELECT o.orderNum, o.total, o.shipDate FROM Orders o, CustomerPlacesOrder c WHERE o.shipStatus =TRUE AND c.cID = '$_SESSION[username]' AND c.orderNum = o.orderNum";
	$result = $mysqli->query($query); // Execute the Query 
	
	echo "<br><b>Shipped Orders</b><br><br>";
	while ($row = $result->fetch_array()) {
		echo "Order Number: $row[0]    Total: $$row[1]     Ship Date: $row[2]";
		echo "<table align=\"center\" border = 2 bgcolor=\"#F0F0F0\"><tr>";
		echo "<td>Name</td><td>Order Amount</td><td>Price</td><td>Promotion</td></tr>";
		$query = "SELECT i.name, oc.amount, i.price, i.promotion FROM 
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
		echo "</table><br>";
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