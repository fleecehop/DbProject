<?php 
	session_start();
	if (isset($_SESSION['privileges'])) {
		if (intval($_SESSION['privileges']) > 1) {
			header("Location: inventory.php");
		}
	}
?>



<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css">

<h2 class="div-padding">A & G Company</h2>
<title>Store</title>
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
	    <a href="shoppingBasket.php" class="menu-option">Shopping Basket </a>
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
<body>
<?//php include "message.php"?>

<h1 align="center">
<form method="POST" action="addToShoppingBasket.php"> 
	<?php include 'displayInventory.php'; ?>
	<div align="right" style="margin-right:3%;">
	    <input type="submit" value="Add To Cart">
	</div>
</form>
</h1>
</body>
</html>

	
 	
