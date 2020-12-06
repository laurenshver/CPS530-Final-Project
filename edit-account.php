<?php
    $servername = "localhost";
    $username = "id15411953_group13";
    $password = "^G97OWfs[(+Zv(\K";
    $dbname = "id15411953_cpsproject";
    // cookie variables
    $cookie_name= "userID";
    
    
    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    
    // Check connection
    if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
    }

    
    $update_sql = "UPDATE customers SET FirstName = '".$_POST["fname"]."', LastName = '".$_POST["lname"]."', Email = '".$_POST["email"]."', Password = '".$_POST["password"]."', PhoneNumber = '".$_POST["phonenum"]."' WHERE (customerID = ". $_COOKIE['userID'] ." AND FirstName = '". $_POST["hidden-fname"]."' AND LastName = '". $_POST["hidden-lname"] ."' AND Email = '". $_POST["hidden-email"] ."' AND Password = '". $_POST["hidden-password"] ."' AND PhoneNumber = '". $_POST["hidden-phonenum"] ."' );";
    
    
        if (mysqli_query($conn, $update_sql)) {
          header("Location: profile.php");
          exit;
        } else {
          echo "Error updating record: " . mysqli_error($conn);
        }

?>