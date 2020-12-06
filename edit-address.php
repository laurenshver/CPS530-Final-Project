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

    
    $delete_sql = "DELETE FROM customer_addresses WHERE (customerID = ". $_COOKIE['userID'] ." AND Name = '". $_POST["hidden-address-name"]."' AND Address = '". $_POST["hidden-address"] ."' AND City = '". $_POST["hidden-city"] ."' AND Province = '". $_POST["hidden-province"] ."' AND PhoneNumber = '". $_POST["hidden-phonenumber"] ."' AND PostalCode = '". $_POST["hidden-postalcode"] ."');";
    
    $update_sql = "UPDATE customer_addresses SET Name = '".$_POST["address-name"]."', Address = '".$_POST["address"]."', City = '".$_POST["city"]."', Province = '".$_POST["province"]."', PhoneNumber = '".$_POST["phonenumber"]."', PostalCode = '".$_POST["postalcode"]."' WHERE (customerID = ". $_COOKIE['userID'] ." AND Name = '". $_POST["hidden-address-name"]."' AND Address = '". $_POST["hidden-address"] ."' AND City = '". $_POST["hidden-city"] ."' AND Province = '". $_POST["hidden-province"] ."' AND PhoneNumber = '". $_POST["hidden-phonenumber"] ."' AND PostalCode = '". $_POST["hidden-postalcode"] ."');";
    
    if (isset($_POST['update_address'])) {
        //update action
        if (mysqli_query($conn, $update_sql)) {
          header("Location: profile.php");
          exit;
        } else {
          echo "Error updating record: " . mysqli_error($conn);
        }
    } else if (isset($_POST['delete_address'])) {
        //delete action
            if (mysqli_query($conn, $delete_sql)){
                header("Location: profile.php");
                exit;
            } else {
                echo "Error: " . $delete_row . "<br>" . mysqli_error($conn);
            }
        
    }
?>