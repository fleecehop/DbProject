<?php


// Start of PHP error handling code
error_reporting(E_ALL);   // Enable all error checking
$return = set_error_handler("MyError");
// Error handler function, called when PHP runtime error detected
function MyError($errno,$errstr,$errfile,$errline) {
	print "(ERR: $errno) ($errstr) ($errfile) (Line:Ê $errline) <br>";
 	return true;
}
// End of PHP error handling code

	$dbhost = "mysql.cs.uky.edu";
	$dbuser = "gttu222";
	$dbpass = "u0670864";
	$dbname = "gttu222";

	//Connect to MySQL Server
	mysql_connect($dbhost, $dbuser, $dbpass);
	//Select Database
	mysql_select_db($dbname) or die(mysql_error());

    $COMMA = ",";     // can be used to seperate data going to JavaScript

    $message = "PHP returned Register button pressed";  // example message to be sent to JavaScript 
    // Example: get data from JavaScript via GET HTTP protocol
    // Each name in n/v pair will have a member in the $_GET array
    // with its name
    $username=$_GET['username'];  // username is using
    $password=$_GET['password'];  // password is using
	
	$query = 'SELECT username ';
	$query .= 'FROM user ';
	$query .= 'WHERE username = "'.$username.'";';
	$qry_result = mysql_query($query) or die(mysql_error());
	
	if (mysql_num_rows($qry_result) == 0) {
		$query = 'INSERT INTO user VALUES ("'.$username.'", "'.$password.'")';
		$qry_result = mysql_query($query) or die(mysql_error());
		$message = "Registered Account";
	}
	else {
		$message = "Username already registered";
	}
	
	// Example: send data back to JavaScript after correcting runtime error if we want to keep users on login page for login message
	print $message.$COMMA;		// always send messsage first, may be error data
	
	
?>