<?php

    // Start session
    session_start();
    
    // If a user is logged in
    if (isset($_SESSION['username'])) 
    {
        // If the user is a staff member
    	if (intval($_SESSION['privilege']) > 1) 
    	{
    		header("Location: viewInventory.php");
    	} 
    	// Else the user is a customer
    	else 
    	{
    		header("Location: customerInventory.php");
    	}
    } 
    // If not logged in
    else 
    {
?>
    <html>

        <head>
            
            <!-- Reference the stylesheet -->
            <link rel="stylesheet" type="text/css" href="style.css">
            
            <!-- Display the title bar with the company name -->
            <h2 class="div-padding">A & G Company</h2>
            
            <!-- Give the webpage a title -->
            <title>Log In</title>
        
        </head>
    
        <body>
        
            <!-- Display a message if one exists -->
            <?php include "message.php" ?>
            
            <br> <br>
            <div class="box">
            
                <!-- Create a form to send data to login.php when button is clicked -->
                <form method="POST" size="small" action="login.php" > 
                    Username: <br><input align = "left" type="text" name="username"><br><br>
                    Password: <br><input align = "left" type="password" name="password"><br><br>
                    <input type="submit" value="Log In">
                </form> 
                
            </div>
        
            <!-- Display clickable text for new users to sign up -->
            <h4 align="center">
                <a align="center" href="registerNewUser.php">New User? Sign Up</a>
            </h4>

        </body>
    
    </html>

<?php } ?>
