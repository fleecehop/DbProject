 <?php
   
    // Start the session
    session_start();
    
    // Unset and destory the session
    session_unset();
    session_destroy();
    
    // Redirect to login screen
    Header("Location: index.php");
	
 ?>	