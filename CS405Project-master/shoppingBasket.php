<?php 
  session_start();
if (isset($_SESSION['privileges'])) {
	if (intval($_SESSION['privileges']) > 1) {
		header("Location: inventory.php");
	}
	} else {
	header("Location: loginForm.php");
}
?> 

<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css">

<h2 class="div-padding">A & G Company</h2>
<title>Shopping Basket</title>
</head>

<div class="div-padding">    
    <div class="header-div" style="float:left; font-weight: bold;">
	    Welcome <?php 
    			if (isset($_SESSION['username'])) {
    				echo $_SESSION['username']; 
    				?>!
	</div>
	
	<div class="header-div" style="float:right;">
	    <a href="logout.php" class="menu-option">Log Out </a>
	    <a href="store.php" class="menu-option">Return To Store </a>
    	<a href="viewOrderHistory.php" class="menu-option">Order History </a>
    	
	</div>
	
	<?php }
	else {
		echo "Guest";
		?><br>
			<a href="loginForm.php">Log In </a><br> 	
			<a href="registrationForm.php">Register As New User </a> 
		<?php } ?><br>
</div>
		
<?php //include "message.php"?>

<?php

	// connect to database
	$mysqli = new mysqli("mysql.cs.uky.edu", "clef222", "Mtfbwy4;", "clef222");

	// check connection 
	if (mysqli_connect_errno()) {
		printf("Connect failed: %s\n", mysqli_connect_error());
		return false;
	}

	// set up DB Query and execute it

	$query = "SELECT I.itemId, I.name,I.description,I.type,I.quantity,I.price,I.promotion,B.amount FROM Inventory I, ShoppingBasket B WHERE I.itemId=B.itemId AND B.cID='$_SESSION[username]'";
	$result = $mysqli->query($query); // Execute the Query 
	
	echo "<h1 align=\"center\">";
	
	if($result->num_rows <1){
	echo "There is nothing in your cart.";
	return false;
	}
	
	echo "<br><br><b>Shopping Cart</b><br>";
	echo "<table align=\"center\" border = 2 bgcolor=\"#F0F0F0\"><tr>";

	
	echo "<td>Name</td><td>Description</td><td>Type</td><td>Amount In Stock</td><td>Price</td><td>Promotion</td>";
	echo "<td>Quantity</td><td>Remove From Cart</td>";
	echo "</tr>";
	while ($row = $result->fetch_array()) {
			echo "<tr>"; 
			for ($i = 1; $i < $mysqli->field_count; $i++) {
				echo "<td>$row[$i]</td>";
			}
			echo "<form method=\"POST\"action=\"removeFromShoppingBasket.php\">";
			echo "<input type=\"hidden\" name=\"itemId\" value=\"$row[0]\">";
			echo "<td><input type=\"submit\"value=\"Remove\"></td></form>"; 
			echo "</tr>";
	}
	echo "</table>";
	?>
	<body>
	<?php include "message.php"?>
	<form method="POST" action="addPendingOrder.php"> 
	<input type="submit" value="Place Order">
	</form>
	</h1>
	</body>
	</html>
	
	
	<?php

	if ($result) {
		$result->close();
	}

	// close the connection
	if ($mysqli) {
		$mysqli->close();
	}





?> 
