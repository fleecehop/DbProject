<?php
session_start();
if (Register()) {
	 $_SESSION['message'] = $_SESSION['message']."Success: Registration was successful. You can now log in to your account.<br>";
	header("Location: loginForm.php");
} else {
	header("Location: registrationForm.php");
}

function Register() {
	// check if username is empty
	if(empty($_POST['username']))
    {
		$_SESSION['error'] = $_SESSION['error']."Error: Please provide a unique username.<br>";
        return false;
    }
	
	// check if password is empty
	if(empty($_POST['password']))
    {
        $_SESSION['error'] = $_SESSION['error']."Error: Please provide a password.<br>";
        return false;
    }
	
	// connect to DB
	$mysqli = new mysqli("mysql.cs.uky.edu", "clef222", "Mtfbwy4;", "clef222");
	
	
	/* check connection */
	if (mysqli_connect_errno()) {
		printf("Connect failed: %s\n", mysqli_connect_error());
		return false;
	}
	
	// insert new user into  the DB
	$query = "INSERT INTO Users VALUES ('$_POST[username]', '$_POST[password]', '$_POST[fname]', 
				'$_POST[lname]', '$_POST[street]', '$_POST[city]', '$_POST[state]', '$_POST[zip]', '1')";
	$result = $mysqli->query($query); // Execute the Query 
	
	if ($mysqli) {
		$mysqli->close();
	}
	
	if ($result != 1) {
		$_SESSION['error'] = $_SESSION['error']."Error: The username is already being used. Please choose another username.<br>"; 
		return false;
	}
	return true;	
}	
?>