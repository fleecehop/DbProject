<?php 
	if (!isset($_SESSION['privileges'])) {
		header("Location: loginForm.php");
	} else if (intval($_SESSION['privileges']) < 2) {
		header("Location: store.php");
	} else {
	// connect to database
	$mysqli = new mysqli("mysql.cs.uky.edu", "clef222", "Mtfbwy4;", "clef222");
	
	// check connection 
	if (mysqli_connect_errno()) {
		printf("Connect failed: %s\n", mysqli_connect_error());
		$_SESSION['error'] = $_SESSION['error']."Database Error: Unable to connect to the mySQL Database.<br>"; 
		return false;
	}
	
	// set up DB Query and execute it
	
	$query = "SELECT orderNum, total FROM Orders WHERE shipStatus = 'false'";
	$result = $mysqli->query($query); // Execute the Query 
	
	echo "<br><br><b>Pending Orders</b><br><br>";
	while ($row = $result->fetch_array()) {
		echo "Order Number: $row[0]    Total: $row[1]";
		echo "   <form method=\"POST\" action=\"shipOrder.php\">
				<input type=\"hidden\" name=\"orderNum\" value=\"$row[0]\">";
		$query = "SELECT u.id FROM Users u, CustomerPlacesOrder c WHERE c.orderNum ='$row[0]' AND c.cId = u.id";
		$custResult = $mysqli->query($query);
		$customer = $custResult->fetch_array();
		echo "Customer ID: $customer[0]"; 
		
		echo "<table align=\"center\" border = 2 bgcolor=\"#F0F0F0\"><tr>";
		echo "<td>ID</td><td>Name</td><td>Amount In Stock</td><td>Order Amount</td><td>Price</td><td>Promotion</td></tr>";
		$query = "SELECT i.itemId, i.name, i.quantity, oc.amount, i.price, i.promotion FROM 
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
		echo "</table>";
		echo "<input type=\"submit\" value=\"Ship Order\"></form><br>"; 
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
