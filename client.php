<?php
    session_start();

    //if user is not logged in
    if(!$_SESSION["loggedInUser"]){

        //send them to loggged in page
        header( "Location: index.php");
    }

    //check for query string -- if user was added
    $alert ="";
    if(isset($_GET["alert"])){
        //if new user is added
        if($_GET["alert"] == "success"){
            // added client
            $alert =  "<div class='alert alert-success'>New client successfully added
                    <a href='' class='close' data-dismiss='alert'></a></div>";
        }
        elseif ($_GET["alert"] == "updatesuccess") {
            //updated client
            $alert =  "<div class='alert alert-success'>A Client has been successfully updated
                    <a href='' class='close' data-dismiss='alert'></a></div>";
        }
        elseif( $_GET["alert"]=="deleted") {
            $alert = "<div class='alert alert-success'>Record successfully deleted<a href='' class='close' 
                        data-dismiss='alert'></a></div>";
        }
    }

    //connect to database
    include("connection.php");

    //query and result
    $query = "SELECT * FROM clients";
    $result = mysqli_query( $conn, $query);


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
            <li class=""><a href="client.php">My Clients</a></li>
            <li class=""><a href="addClient.php">Add Clients</a></li>
            <li  style="float: right;"><a href="logout.php">Log out</a></li>
            <li   style="float: right;" ><a id="user" href=""><?php echo $_SESSION["loggedInUser"]; ?></a></li>
            
            
        </ul>
    </nav>

    <div class="container">
        <h1>Client Address Book</h1>
        <?php echo $alert; ?>

        
        
        
        
        <table  class="table table-striped table-bordered table-hover table-responsive">
          <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Address</th>
            <th>Company</th>
            <th>Notes</th>
            <th>Edit</th>
          </tr>

            <?php

                if(mysqli_num_rows( $result) > 0){
                    //we have data
                    //output data

                    while( $rows = mysqli_fetch_assoc( $result)){
                        echo "<tr>";
                        echo "<td>".$rows["name"]."</td><td>".$rows["email"]."</td><td>".$rows["phone"].
                            "</td><td>".$rows["address"]."</td><td>".$rows["company"]."</td><td>".$rows["notes"]."</td>";
                        echo "<td><a href='edit.php?id=".$rows["id"]." ' type='button' class='btn btn-default btn-danger btn-sm'>
                        edit</a></td>";

                        echo "</tr>";
                            
                    }
                }
                else{
                    echo "<div class='alert alert-warning'>You have no client</div>";
                }
                //close connection
                mysqli_close( $conn);
            ?>

            
            <tr><td colspan="7"><div class="text-center"><a href="addClient.php" class="btn btn-success">+Add Client

            </a></div></td></tr>
        </table>
        
    </div>
    



    <script src="js/bootstrap.min.js"></script>
</body>
</html>