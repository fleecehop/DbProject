<?php

    session_start();
    
    if (isset($_SESSION['privilege'])) 
    {
    	if (intval($_SESSION['privilege']) > 1) 
    	{
    		header("Location: viewInventory.php");
    	} 
    	else 
    	{
    		header("Location: customerInventory.php");
    	}
    } 
    else 
    {

        if (CheckUser()) 
        {
        	// if login successful, redirect to store
        	if (intval($_SESSION['privilege']) > 1) 
        	{
        		header("Location: viewInventory.php");
        	} 
        	else 
        	{
        		header("Location: customerInventory.php");
        	}
        } 
        else 
        {
        	// if unsuccessful, redirect to login screen
        	header("Location: index.php");
        }
        
    }
    
    
    function CheckUser() 
    {

    	// check for empty username
    	if(empty($_POST['username']))
        {
            $_SESSION['error'] = $_SESSION['error']."Error: Please provide a username.<br>"; 
    		return false;
        }
        else if(empty($_POST['password']))
        {
    		$_SESSION['error'] = $_SESSION['error']."Error: Please provide a password.<br>"; 
            return false;
        }
        
    	// connect to database
    	$mysqli = new mysqli("mysql.cs.uky.edu", "gttu222", "u0670864", "gttu222");

    	/* check connection */
    	if (mysqli_connect_errno()) {
    		printf("Failed to Connect: %s\n", mysqli_connect_error());
    	
    		return false;
    	}

    	// set up DB Query and execute it
    	$r = $mysqli->query("SELECT id, privilege FROM Users WHERE id='$_POST[username]'
    	     AND password='$_POST[password]'");

    	// close the connection
    	if ($mysqli) 
    	{
    		$mysqli->close();
    	}

    	if ($r->num_rows > 0) 
    	{
    		// login was successful, user exists
    		$info = $r->fetch_row();
    		$_SESSION['username'] = $info[0];
    		$_SESSION['privilege'] = $info[1];
    		$_SESSION['message'] = $_SESSION['message']."Success: $_SESSION[username] successfully logged in.<br>";
    		
    		return true;
    	} 
    	else 
    	{
    		$_SESSION['error'] = $_SESSION['error']."Error: Invalid credentials. Please provide a registered username and password<br>"; 
    		
    		return false;
    	}
    }

?>