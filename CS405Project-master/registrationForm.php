<?php
session_start();
if (isset($_SESSION['privileges'])) {
	if (intval($_SESSION['privileges']) > 1) {
		header("Location: inventory.php");
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
<title>New User Registration</title>
</head>
<body>
<?php include "message.php"?>
<br> <br> <br>
<div class = "box">
<form method="POST" action="registration.php">
  Username*: <input type="text" name="username"><br>
  Password*: <input type="text" name="password"><br>
  First Name*: <input type="text" name="fname"><br>
  Last Name: <input type="text" name="lname"><br>
  Street: <input type="text" name="street"><br>
  City: <input type="text" name="city"><br>
  State: <select name="state">
	<option value=""></option>
	<option value="AL">AL</option>
	<option value="AK">AK</option>
	<option value="AZ">AZ</option>
	<option value="AR">AR</option>
	<option value="CA">CA</option>
	<option value="CO">CO</option>
	<option value="CT">CT</option>
	<option value="DE">DE</option>
	<option value="DC">DC</option>
	<option value="FL">FL</option>
	<option value="GA">GA</option>
	<option value="HI">HI</option>
	<option value="ID">ID</option>
	<option value="IL">IL</option>
	<option value="IN">IN</option>
	<option value="IA">IA</option>
	<option value="KS">KS</option>
	<option value="KY">KY</option>
	<option value="LA">LA</option>
	<option value="ME">ME</option>
	<option value="MD">MD</option>
	<option value="MA">MA</option>
	<option value="MI">MI</option>
	<option value="MN">MN</option>
	<option value="MS">MS</option>
	<option value="MO">MO</option>
	<option value="MT">MT</option>
	<option value="NE">NE</option>
	<option value="NV">NV</option>
	<option value="NH">NH</option>
	<option value="NJ">NJ</option>
	<option value="NM">NM</option>
	<option value="NY">NY</option>
	<option value="NC">NC</option>
	<option value="ND">ND</option>
	<option value="OH">OH</option>
	<option value="OK">OK</option>
	<option value="OR">OR</option>
	<option value="PA">PA</option>
	<option value="RI">RI</option>
	<option value="SC">SC</option>
	<option value="SD">SD</option>
	<option value="TN">TN</option>
	<option value="TX">TX</option>
	<option value="UT">UT</option>
	<option value="VT">VT</option>
	<option value="VA">VA</option>
	<option value="WA">WA</option>
	<option value="WV">WV</option>
	<option value="WI">WI</option>
	<option value="WY">WY</option>
	</select><br>
  Zip: <input type="text" name="zip"><br>
  <input type="submit" value="Register">
</form>
</div>
<h4 align="center">
<a align="center" href="loginForm.php">Go back</a>
</h4> 
</body>
</html>
<?php } ?>