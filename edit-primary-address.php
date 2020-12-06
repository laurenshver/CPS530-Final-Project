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
    
    $update1_sql = "UPDATE customer_addresses SET Primary_Address = 'NO' WHERE (CustomerID = ".$_COOKIE["userID"].");";
    $update2_sql = "UPDATE customer_addresses SET Primary_Address = 'YES' WHERE (CustomerID = ".$_COOKIE["userID"]." AND Name = '".$_POST["primary"]."');";
    
        if (mysqli_query($conn, $update1_sql)) {
            mysqli_query($conn, $update2_sql);
            header("Location: profile.php");
            exit;
        } else {
          echo "Error updating record: " . mysqli_error($conn);
        }

?>