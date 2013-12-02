<?php
    session_start();

    if (isset($_SESSION['privilege'])) 
    {
    	if (intval($_SESSION['privilege']) > 1) 
    	{
    		header("Location: inventory.php");
    	} 
    	else 
    	{
    		header("Location: customerInventory.php");
    	}
    } else {
?>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="style.css">
        <h2 class="div-padding">A & G Company</h2>
        <title>New User</title>
    </head>
    
    <body>
        <?php include "message.php"?>
        <br> <br> <br>
        <div class="box">
            <form method="POST" action="register.php">
                Username: * <br><input type="text" name="username"><br><br>
                Password: * <br><input type="text" name="password"><br><br>
                First Name: * <br><input type="text" name="firstName"><br><br>
                Last Name: <br><input type="text" name="lastName"><br><br>
                Street: <br><input type="text" name="street"><br><br>
                City: <br><input type="text" name="city"><br><br>
                State: <br><select name="state">
                    <option value=""></option>
                    <option value="AL">Alabama</option>
                    <option value="AK">Alaska</option>
                    <option value="AZ">Arizona</option>
                    <option value="AR">Arkansas</option>
                    <option value="CA">California</option>
                    <option value="CO">Colorado</option>
                    <option value="CT">Connecticut</option>
                    <option value="DE">Delaware</option>
                    <option value="DC">District of Columbia</option>
                    <option value="FL">Florida</option>
                    <option value="GA">Georgia</option>
                    <option value="HI">Hawaii</option>
                    <option value="ID">Idaho</option>
                    <option value="IL">Illinois</option>
                    <option value="IN">Indiana</option>
                    <option value="IA">Iowa</option>
                    <option value="KS">Kansas</option>
                    <option value="KY">Kentucky</option>
                    <option value="LA">Louisiana</option>
                    <option value="ME">Maine</option>
                    <option value="MD">Maryland</option>
                    <option value="MA">Massachusetts</option>
                    <option value="MI">Michigan</option>
                    <option value="MN">Minnesota</option>
                    <option value="MS">Mississippi</option>
                    <option value="MO">Missouri</option>
                    <option value="MT">Montana</option>
                    <option value="NE">Nebraska</option>
                    <option value="NV">Nevada</option>
                    <option value="NH">New Hampshire</option>
                    <option value="NJ">New Jersey</option>
                    <option value="NM">New Mexico</option>
                    <option value="NY">New York</option>
                    <option value="NC">North Carolina</option>
                    <option value="ND">North Dakota</option>
                    <option value="OH">Ohio</option>
                    <option value="OK">Oklahoma</option>
                    <option value="OR">Oregon</option>
                    <option value="PA">Pennsylvania</option>
                    <option value="RI">Rhode Island</option>
                    <option value="SC">South Carolina</option>
                    <option value="SD">South Dakota</option>
                    <option value="TN">Tennessee</option>
                    <option value="TX">Texas</option>
                    <option value="UT">Utah</option>
                    <option value="VT">Vermont</option>
                    <option value="VA">Virginia</option>
                    <option value="WA">Washington</option>
                    <option value="WV">West Virginia</option>
                    <option value="WI">Wisconsin</option>
                    <option value="WY">Wyoming</option>
                </select><br><br>
                Zip: <br><input type="text" name="zip"><br><br>
                <input type="submit" value="Register"><br>
            </form>
        </div>
        
        <h4 align="center">
            <a align="center" href="index.php">Go back</a>
        </h4> 
        
    </body>
    
</html>

<?php } ?>