<?php
    session_start();

    //if form was submitted
    $logginErr = "";
    if( isset($_POST["login"])){
        //validate form data
        function validate($formdata){
            $formdata = trim(stripslashes(htmlspecialchars($formdata)));
            return $formdata;
        }

        $formEmail = validate($_POST["email"]);
        $formPassword = validate($_POST["password"]);

        //connect to database
        include("connection.php");

        //create query
        $query = "SELECT name, password FROM users WHERE email='$formEmail'";
        //store result
        $result = mysqli_query( $conn, $query);
       
        //verify if result is returned
        if(mysqli_num_rows( $result) > 0){

            //store basic user variable
            while( $rows = mysqli_fetch_assoc( $result)){
                $name = $rows["name"];
                $hashedPassword = $rows["password"];
            }
            
            //verify hashed password with submitted password
            if( password_verify( $formPassword, $hashedPassword)){
                //correct login details
                //store session variables

                $_SESSION["loggedInUser"] = $name;

                //redirect user
                header( "Location: client.php" );
            }
            else{
                //if password don't match
                $logginErr = "<div class='alert alert-danger'>Wrong username/ password combination. Try again
                            <a href='' class='close' data-dismiss='alert'>&times;</a></div>";
            }
        }
        else{
            //no result in database
            $logginErr = "<div class='alert alert-danger'>No such user in database. Try again
                         <a href='' class='close' data-dismiss='alert'>&times;</a></div>";
        }

        mysqli_close($conn);
    }
    
    
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Client Address Book</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
  
<style>
    *{
    margin:0;
    padding: 0;
}

ul {
   
    margin:0;
    padding:0;
    background-color: #333;
    overflow:hidden;
    list-style-type: none;
    box-shadow: 1px 2px 0px 3px rgba(0,0,0,0.2);
}

li a{
    display:block;
    padding:20px;
    text-decoration: none;
    color:grey;
}

li{float:left;}

li a:hover{
    color:#ccc;
    text-decoration: none;;
}

nav{
    margin-bottom: 50px;
}

</style>
</head>

<body>
    <nav>
        <ul>
            <li class=""><a href="index.php">CLIENT<b>MANAGER</b></a></li>
            
        </ul>
    </nav>

    <div class="container">
        <h2><b>Client Address Book</b></h2>
        <p class="lead">Log in to your account</p>
        <?php echo $logginErr; ?>

        <div class="row">
            <div class="col-sm-8">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="form-inline" method="POST">
                    <input type="email" class="form-control" placeholder="email" name="email">
                    <input type="password" class="form-control" placeholder="password" name="password">
                    <input type="submit" value="Log in" name="login" class="btn btn-primary">
                </form>
            </div>
        </div>
        
    </div>
    



    <script src="js/bootstrap.min.js"></script>
</body>
</html>