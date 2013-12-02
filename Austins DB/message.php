<?php

    // If a message is queued to be displayed
    if (isset($_SESSION['message'])) 
    {
        // Show the message
    	echo "<div class=\"success\">";
    	echo "<b>";
    	echo strval($_SESSION['message']);
    	echo "</b>";
    	echo "</div>";
    	
    	// Unqueue the message
    	unset($_SESSION['message']);
    }
    
    // If an error is queued to be displayed
    if (isset($_SESSION['error'])) 
    {
        // Show the error
    	echo "<div class=\"error\">";
    	echo "<b>";
    	echo strval($_SESSION['error']);
    	echo "</b>";
    	echo "</div>";
    	
    	// Unqueue the error
    	unset($_SESSION['error']);
    }
?>