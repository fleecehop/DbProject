<?php

    session_start();
    
    if (AddUser()) 
    {
    	 $_SESSION['message'] = $_SESSION['message']."Success: Registration was successful. <br>";
    	 
    	header("Location: index.php");
    } 
    else 
    {
    	header("Location: registerNewUser.php");
    }

    function AddUser() 
    {
    	// check if username is empty
    	if(empty($_POST['username']))
        {
    		$_SESSION['error'] = $_SESSION['error']."Please input a username.<br>";
    		
            return false;
        }
    	else if(empty($_POST['password']))
        {
            $_SESSION['error'] = $_SESSION['error']."Please input a password.<br>";
            
            return false;
        }
	
    	// connect to DB
    	$mysqli = new mysqli("mysql.cs.uky.edu", "mage223", "u0688279", "mage223");
	
    	/* check connection */
    	if (mysqli_connect_errno()) 
    	{
    		printf("Failed to Connect: %s\n", mysqli_connect_error());
    		return false;
    	}
	
    	// insert new user into DB
    	$r = $mysqli->query("INSERT INTO Users VALUES ('$_POST[username]',
    	     '$_POST[password]', '$_POST[firstName]', '$_POST[lastName]', '$_POST[street]',
    	     '$_POST[city]', '$_POST[state]', '$_POST[zip]', '1')");
	
    	if ($mysqli) 
    	{
    		$mysqli->close();
    	}
	
    	if ($r != 1) 
    	{
    		$_SESSION['error'] = $_SESSION['error']."Username is already in use.<br>"; 
    		
    		return false;
    	}
    	
    	return true;	
    }	
?>