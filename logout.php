<?php
    session_start();

    //if user is not logged in
    if(!$_SESSION["loggedInUser"]){

        //send them to log in page
        header( "Location: index.php");
    }

    if(isset($_COOKIE[session_name()])){
        //empty cookie
        setcookie( session_name(), '', time()-86400,'/');

    }
    
        //clear session variables
        session_unset();

        //destroy session variables
        session_destroy();

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Client Address Book</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="js/style.css">
</head>

<body>
    <nav>
        <ul>
            <li class=""><a href="index.php">CLIENT<b>MANAGER</b></a></li>
            <li  style="float: right;"><a href="index.php">Log in</a></li>          
        </ul>
    </nav>

    <div class="container">
        <h1>Logged out</h1>
        <p class="lead">You have been logged out. See you next time!</p>
        
    </div>
    



    <script src="bootstrap.min.js"></script>
</body>
</html>