<?php
session_start();
if (isset($_SESSION['privileges'])) {
	if (intval($_SESSION['privileges']) > 1) {
		header("Location: viewInventory.php");
	} else {
		header("Location: store.php");
	}
} else {

if (Login()) {
	// if login successful, redirect to store
	if (intval($_SESSION['privileges']) > 1) {
		header("Location: viewInventory.php");
	} else {
		header("Location: store.php");
	}
} else {
	// if unsuccessful, redirect to login screen
	header("Location: loginForm.php");
}
}
function Login() {
	
	// check for empty username
	if(empty($_POST['username']))
    {
        $_SESSION['error'] = $_SESSION['error']."Error: Please provide a username.<br>"; 
		return false;
    }
    
	// check for empty password
    if(empty($_POST['password']))
    {
		$_SESSION['error'] = $_SESSION['error']."Error: Please provide a password.<br>"; 
        return false;
    }
	// connect to database
	$mysqli = new mysqli("mysql.cs.uky.edu", "clef222", "Mtfbwy4;", "clef222");
	
	/* check connection */
	if (mysqli_connect_errno()) {
		printf("Connect failed: %s\n", mysqli_connect_error());
		$_SESSION['error'] = $_SESSION['error']."Database Error: Unable to connect to the Authentication Server.<br>"; 
		return false;
	}
	
	// set up DB Query and execute it
	$query = "SELECT id, privileges FROM Users WHERE id='$_POST[username]' AND password='$_POST[password]'";
	$result = $mysqli->query($query); // Execute the Query 

	// close the connection
	if ($mysqli) {
		$mysqli->close();
	}
	
	if ($result->num_rows > 0) {
		// login was successful, user exists
		$info = $result->fetch_row();
		$_SESSION['username'] = $info[0];
		$_SESSION['privileges'] = $info[1];
		$_SESSION['message'] = $_SESSION['message']."Success: $_SESSION[username] successfully logged in.<br>";
		return true;
	} else {
		$_SESSION['error'] = $_SESSION['error']."Error: Invalid credentials. Please provide a registered username and password<br>"; 
		return false;
	}
}

?>