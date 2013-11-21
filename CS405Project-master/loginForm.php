<?php
session_start();
if (isset($_SESSION['privileges'])) {
	if (intval($_SESSION['privileges']) > 1) {
		header("Location: viewInventory.php");
	} else {
		header("Location: store.php");
	}
} else {
?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css">
<style>
div.box
{
width:220px;
padding:10px;
border:5px solid gray;
margin-left:auto;
margin-right:auto;
}
</style>
<h2>The Store</h2>
<title>Log In</title>
</head>
<body>
<?php include "message.php"?>
<br> <br>
<div class="box">
<form method="POST" size="small" action="login.php" > 
  Username: <input align ="left" type="text" name="username"><br>
  Password: <input align = "left" type="password" name="password"><br>
  <input type="submit" value="Log In">
</form> 
</div>
<h4 align="center">
<a align="center" href="registrationForm.php">Register As A New User</a>
</h4>

</body>
</html>
<?php } ?>
