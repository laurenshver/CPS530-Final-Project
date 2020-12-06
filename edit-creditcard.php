<?php
    $servername = "localhost";
    $username = "id15411953_group13";
    $password = "^G97OWfs[(+Zv(\K";
    $dbname = "id15411953_cpsproject";
    // cookie variables
    $cookie_name= "userID";
    $newID= $_COOKIE[$cookie_name];
    
    
    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    
    // Check connection
    if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
    }
    
    $delete_row = "DELETE FROM customer_creditcards  WHERE (customerID = " . $newID . " AND creditcardnumber = '" . $_POST['ccnum'] . "');";
    $result = mysqli_query($conn, $delete_row);
        //  header("Location: edit-profile.php");
    //   exit;
    
    if ($result) {
        header("Location: profile.php");
        exit;

     } else {
     echo "Error: " . $delete_row . "<br>" . mysqli_error($conn);
    }
    

       

        


?>