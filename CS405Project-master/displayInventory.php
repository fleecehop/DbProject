<?php 
	if (!isset($_SESSION['privileges'])) {
		header("Location: loginForm.php");
	}
	else {
		// connect to database
	$mysqli = new mysqli("mysql.cs.uky.edu", "clef222", "Mtfbwy4;", "clef222");
	
	// check connection 
	if (mysqli_connect_errno()) {
		printf("Connect failed: %s\n", mysqli_connect_error());
		return false;
	}
	
	// set up DB Query and execute it
	
	$query = "SELECT * FROM Inventory";
	$result = $mysqli->query($query); // Execute the Query 
	
	echo "<br><br><div align=\"center\"><b>";
	if (intval($_SESSION['privileges']) > 1) {
		echo "Inventory";
	} else {
		echo "Store";
	}
	echo "</b></div><br>";
	echo "<table align=\"center\" border = 2 bgcolor=\"#F0F0F0\"><tr>";
	$j = 0;
	if (intval($_SESSION['privileges']) > 1) {
		echo "<td>Item ID</td>";
	} else {
		$j = 1;
	}
	echo "<td>Name</td><td>Description</td><td>Type</td><td>Amount In Stock</td><td>Price</td><td>Promotion (% off)</td>";
	if (intval($_SESSION['privileges']) > 1) {
		if (isset($_SESSION['promotions'])) {
			echo "<td>Change Promotion</td>";
		} else if (!isset($_SESSION['view'])) {
			echo "<td>Add Inventory</td>";
		} 
	} else {
		echo "<td>Add Amount to Cart</td>";
	}
	echo "</tr>";
	
	while ($row = $result->fetch_array()) {
			echo "<tr>"; 
			for ($i = $j; $i < $mysqli->field_count; $i++) {
				echo "<td>$row[$i]</td>";
			}
			if (!isset($_SESSION['view'])) { 
				echo "<td><input type=\"text\"name=\"$row[0]\"></td>";
			} 
			echo "</tr>";
	}
	echo "</table><br>";
	
	if (isset($_SESSION['view'])) {
			unset($_SESSION['view']);
	} else if (isset($_SESSION['promotions'])) {
			unset($_SESSION['promotions']);
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