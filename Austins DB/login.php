<?php

    // Start session if not active
    session_start();
    
    // If user is logged in
    if (isset($_SESSION['username'])) 
    {
        // If staff member
    	if (intval($_SESSION['privilege']) > 1) 
    	{
    		header("Location: viewInventory.php");
    	} 
    	// If not staff member
    	else 
    	{
    		header("Location: customerInventory.php");
    	}
    } 
    // If not logged in
    else 
    {

        // If the user passes the check
        if (CheckUser()) 
        {
            // If staff, go here
        	if (intval($_SESSION['privilege']) > 1) 
        	{
        		header("Location: viewInventory.php");
        	} 
        	// If customer, go here
        	else 
        	{
        		header("Location: customerInventory.php");
        	}
        } 
        // If user doesn't check out
        else 
        {
            // Go to login screen
        	header("Location: index.php");
        }
        
    }
    
    
    function CheckUser() 
    {

    	// Check for empty username
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
        
    	// Connect to the database
    	$mysqli = new mysqli("mysql.cs.uky.edu", "mage223", "u0688279", "mage223");

    	// Check the database connection
    	if (mysqli_connect_errno()) 
    	{
    		return false;
    	}

    	// Get the user's id and privilege level
    	$r = $mysqli->query("SELECT id, privilege FROM Users WHERE id='$_POST[username]'
    	     AND password='$_POST[password]'");

         // If the user exists
    	if ($r->num_rows > 0) 
    	{
    	    // Set the information for later use
    		$i = $r->fetch_row();
    		$_SESSION['username'] = $i[0];
    		$_SESSION['privilege'] = $i[1];
    		
    		return true;
    	} 
    	// If the user does not exist
    	else 
    	{
    		$_SESSION['error'] = $_SESSION['error']."Invalid credentials. Please provide a valid username/password<br>"; 
    		
    		return false;
    	}
    
        // Close database connection
    	if ($mysqli) 
    	{
    		$mysqli->close();
    	}
	
    }

?>