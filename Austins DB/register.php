<?php

    // Start session if not active
    session_start();
    
    // If able to add the new user
    if (AddNewUser()) 
    {
        // Display message
    	 $_SESSION['message'] = $_SESSION['message']."You are now registered!<br>";
    	 
    	// Redirect to login screen 
    	header("Location: index.php");
    } 
    // If not able to add user
    else 
    {
        // Stay on registration page
    	header("Location: registerNewUser.php");
    }

    // Try to add the new user
    function AddNewUser() 
    {
    	// If username is empty
    	if(empty($_POST['username']))
        {
    		$_SESSION['error'] = $_SESSION['error']."Please input a username.<br>";
    		
    		// Don't allow user to be added
            return false;
        }
        // If password is empty
    	else if(empty($_POST['password']))
        {
            $_SESSION['error'] = $_SESSION['error']."Please input a password.<br>";
            
            // Don't allow user to be added
            return false;
        }
        // If first name is empty
        else if(empty($_POST['firstName']))
        {
            $_SESSION['error'] = $_SESSION['error']."Please input a First Name.<br>";
            
            // Don't allow user to be added
            return false;
        }
	
    	// Connect to the database
    	$mysqli = new mysqli("mysql.cs.uky.edu", "mage223", "u0688279", "mage223");
	
    	// Check the database connection for error
    	if (mysqli_connect_errno()) 
    	{
    		return false;
    	}
	
    	// Insert new user into the Users table
    	$r = $mysqli->query("INSERT INTO Users VALUES ('$_POST[username]',
    	     '$_POST[password]', '$_POST[firstName]', '$_POST[lastName]', '$_POST[street]',
    	     '$_POST[city]', '$_POST[state]', '$_POST[zip]', '1')");
	
	    // Close the database connection
    	if ($mysqli) 
    	{
    		$mysqli->close();
    	}
	
	    // If the insert failed
    	if ($r != 1) 
    	{
    	    // Have user choose a new username
    		$_SESSION['error'] = $_SESSION['error']."Username is already in use.<br>"; 
    		
    		// Don't allow user to be added
    		return false;
    	}
    	
    	return true;	
    }	
?>