<?php
    session_start();

     //if user is not logged in
     if(!$_SESSION["loggedInUser"]){

        //send them to log in page
        header( "Location: index.php");
    }

    $clientID = $alert = "";
    $clientName = $clientEmail = $clientPhone = $clientCompany = $clientAddress = $clientNote = $alertMessage = "";
    //get client id sent by get collection
    if(isset($_GET['id'])){
        $clientID = $_GET["id"];

        //connect to data base
        include("connection.php");

        
        //query database
        $query = "SELECT * FROM clients WHERE id='$clientID'";

        //get result
        $result = mysqli_query( $conn, $query);

        if(mysqli_num_rows($result) > 0){

            //we have data
            //store variables
            while( $rows = mysqli_fetch_assoc($result)){
                $clientName = $rows['name'];
                $clientEmail = $rows['email'];
                $clientPhone = $rows['phone'];
                $clientCompany = $rows['company'];
                $clientAddress = $rows['address'];
                $clientNote = $rows['notes'];
            }
          
        }

        if(isset($_POST["update"])){
        
             //validate form data
            function validate($formdata){
                $formdata = trim(stripslashes(htmlspecialchars($formdata)));
                return $formdata;
            }
            //set variables
            $clientName = validate( $_POST['name']);
            $clientEmail = validate( $_POST['email']);
            $clientPhone = validate( $_POST['phone']);
            $clientCompany = validate( $_POST['company']);
            $clientAddress = validate( $_POST['address']);
            $clientNote = validate( $_POST['notes']);

            //connect to data base
            include("connection.php");

            //query database
            $query = "UPDATE clients
                        SET name='$clientName',
                        email='$clientEmail',
                        phone='$clientPhone',
                        address='$clientAddress',
                        company='$clientCompany',
                        notes='$clientNote' WHERE id='$clientID'";

            $result = mysqli_query( $conn, $query);

            if($result){
                //client was updated
                header( "Location: client.php?alert=updatesuccess");
            }
            else{
                $alertMessage = "<div class='alert alert-warning'>Error updating client. 
                <a href='client.php'>Head back</a></div>";
                // echo "error updating client ".mysqli_error( $conn);
            }
            
            
        }

        if(isset( $_POST["delete"])){
            $alert = '<div class="alert alert-danger">
                        <p>Are you sure you want to delete this client? No take back</p>
                        <form action="' .htmlspecialchars($_SERVER["PHP_SELF"]). '?id='.$clientID.'" method="POST">
                            <input type="submit" value="Yes!, delete" name="confirm-delete" class="btn btn-danger btn-sm">
                            <a href="" type="button" class="btn btn-info btn-sm">Oops, no thanks</a>
                        </form>
                        </div>';
        }

        if(isset($_POST["confirm-delete"])){
           
            include("connection.php");

            //query database
            $query = "DELETE FROM clients WHERE id=$clientID";
            $result = mysqli_query( $conn, $query);

            if($result){
                //data has been deleted
                header("Location: client.php?alert=deleted");
            }
            else{
                $alertMessage = "<div class='alert alert-info'>No available data to delete. <a href='client.php'>Head back</a></div>";
            }
        }

        
        //close connection
        mysqli_close( $conn);
    }
    else{
        //no result
        $alertMessage = "<div class='alert alert-warning'>Nothing to see here. <a href='client.php'>Head back</a></div>";
    }
 

    

   
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Client Address Book</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <nav>
        <ul>
            <li class=""><a href="index.php">CLIENT<b>MANAGER</b></a></li>
            <li  style="float: right;"><a href="">Log in</a></li>
            
        </ul>
    </nav>

    <div class="container">
        <h2><b>Edit Client</b></h2>
       <?php echo $alertMessage; ?>

       <?php echo $alert ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>?id=<?php echo $clientID; ?>" 
                        method="POST" class="row">
        
            <div class="col-sm-6">
                    <label for="name"><b>Name</b></label>
                    
                    <input type="text" value="<?php echo $clientName; ?>" name="name" class="form-control" id="name">
                    <br>
                    <label for="phone"><b>Phone</b> </label>
                    <input type="text" value="<?php echo $clientPhone; ?>" name="phone" class="form-control" id="phone">
                    <br>
                    <label for="company"><b>Company</b> </label>
                    <input type="text" value="<?php echo $clientCompany; ?>" name="company" class="form-control" id="company">
                    <br>
                    <input type="submit"  value="Delete" name="delete" class="btn btn-danger">
            </div>
            

            <div class="col-sm-6">
                
                    <label for="email"><b>Email</b></label>
                    
                    <input type="email" value="<?php echo $clientEmail; ?>" name="email" class="form-control" id="email">
                    <br>
                    <label for="address"><b>Address</b> </label>
                    <input type="text" value="<?php echo $clientAddress; ?>"  name="address" class="form-control" id="address">
                    <br>
                    <label for="notes"><b>Notes</b> </label>
                   <textarea name="notes" id="notes" cols="10" class="form-control" rows="3" style="resize: none;">
                   <?php echo $clientNote; ?> </textarea>
                    <br>
                    <input type="submit" value="Update" name="update" 
                    class="btn btn-success" style="float: right;">
                    
                    <input type="submit" value="Cancel" name="cancel" formaction="client.php" 
                    class="btn btn-default" style="float: right; border:solid 1px #ccc;">

            </div>

        </form>
        
    </div>
    



    <script src="js/bootstrap.min.js"></script>
</body>
</html>