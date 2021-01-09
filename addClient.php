<?php
    session_start();

    if(!$_SESSION["loggedInUser"]){

        //send them to loggged in page
        header( "Location: index.php");
    }

    $nameErr = $emailErr = $clientName ="";
    //if add button was clicked
    if(isset( $_POST["addClient"])){
        //set variables to default
        
        //check to see if inputs are empty
        //create variable with form data
        //validate form data
        function validate($formdata){
            $formdata = trim(stripslashes(htmlspecialchars($formdata)));
            return $formdata;
        }

        if(!$_POST["name"]){
            $nameErr = "required field";
        }else{
            $clientName = validate($_POST["name"]);
        }
        if(!$_POST["email"]){
            $emailErr = "required field";
        }else{
            $clientEmail = validate($_POST["email"]);
        }
        $clientPhone = validate($_POST["phone"]);
        $clientCompany = validate($_POST['company']);
        $clientAddress = validate($_POST["address"]);
        $clientNote = validate($_POST['notes']);

            //if required fields have data
            if( !empty($clientName && $clientEmail)){
                include ("connection.php");

                $query = "INSERT INTO clients (id, name, email, phone, address, company, notes, date_addedd)
                            VALUES (NULL, '$clientName', '$clientEmail', '$clientPhone', '$clientAddress',
                             '$clientCompany','$clientNote', CURRENT_TIMESTAMP)";

                //if query was successful
                if(mysqli_query( $conn, $query)){

                    //refresh page
                    // $alert =  "<div class='alert alert-success'>Client successfully added
                    //         <a href='' class='close' data-dismiss='alert'>&times;</a></div>";
                    header("Location: client.php?alert=success");
                }
                else{
                    //something went wrong
                    echo "Error ".$query."<br>".mysqli_error($conn);
                }
                mysqli_close($conn);
            }
            
           
    }

    if(isset($_POST["cancel"])){
        // cancel buuton was clicked
        header("Location: addClient.php");
    }
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Client Address Book</title>
    <link rel="stylesheet" href="bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <nav>
        <ul>
            <li class=""><a href="index.php">CLIENT<b>MANAGER</b></a></li>
            <li class=""><a href="client.php">My Clients</a></li>
            <li class=""><a href="addClient.php">Add Clients</a></li>
            <li  style="float: right;"><a href="">Log out</a></li>
            <li  style="float: right;" ><a id="user" href=""><?php echo $_SESSION["loggedInUser"]; ?></a></li>
            
            
        </ul>
    </nav>

    <div class="container">
        <h2><b>Add Client</b></h2>
        <p class="lead">Add Clients To Database</p>

        <form action="<?php echo htmlspecialchars( $_SERVER["PHP_SELF"]); ?>" method="POST" class="row">

            
            <div class="col-sm-6">
                    <label for="name"><b>Name* <small class="text-danger"><?php echo $nameErr; ?></small></b></label>
                    
                    <input type="text" name="name" class="form-control" id="name">
                    <br>
                    <label for="phone"><b>Phone</b> </label>
                    <input type="text"  name="phone" class="form-control" id="phone">
                    <br>
                    <label for="company"><b>Company</b> </label>
                    <input type="text" name="company" class="form-control" id="company">
                    <br>
                    <input type="submit"  value="Cancel" name="cancel" class="btn btn-danger">
            </div>
            

            <div class="col-sm-6">
                
                    <label for="email"><b>Email* <small class="text-danger"><?php echo $emailErr; ?></small></b></label>
                    
                    <input type="email" name="email" class="form-control" id="email">
                    <br>
                    <label for="address"><b>Address</b> </label>
                    <input type="text"  name="address" class="form-control" id="address">
                    <br>
                    <label for="notes"><b>Notes</b> </label>
                   <textarea name="notes" id="notes" cols="" class="form-control" rows="3" style="resize: none;"></textarea>
                    <br>
                    <input type="submit" value="Add Client" name="addClient" 
                    class="btn btn-success" style="float: right;">

            </div>

        </form>
        
    </div>
    



    <script src="bootstrap.min.js"></script>
</body>
</html>