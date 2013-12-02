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
?>
<html>

    <head>
        
        <link rel="stylesheet" type="text/css" href="style.css">
        <h2 class="div-padding">A & G Company</h2>
        <title>Log In</title>
        
    </head>
    
    <body>
        
        <?php include "message.php"?>
        <br> <br>
        <div class="box">
            <form method="POST" size="small" action="login.php" > 
                Username: <br><input align ="left" type="text" name="username"><br><br>
                Password: <br><input align = "left" type="password" name="password"><br><br>
                <input type="submit" value="Log In">
            </form> 
        </div>
        
        <h4 align="center">
            <a align="center" href="registerNewUser.php">New User? Sign Up</a>
        </h4>

    </body>
    
</html>

<?php } ?>
