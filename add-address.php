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
    
    
    $insert_row = "INSERT INTO customer_addresses (CustomerID, Primary_Address, Name, Address, City, Province, PostalCode, PhoneNumber) VALUES (" . $newID .", 'NO', '" . $_POST["address-name"] . "', '" . $_POST["address"] . "', '" . $_POST["city"] . "', '" . $_POST["province"] . "', '" . $_POST["postalcode"] . "', '" . $_POST["phonenumber"] . "')";
    
    $insert_primary_row = "INSERT INTO customer_addresses (CustomerID, Primary_Address, Name, Address, City, Province, PostalCode, PhoneNumber) VALUES (" . $newID .", 'YES', '" . $_POST["address-name"] . "', '" . $_POST["address"] . "', '" . $_POST["city"] . "', '" . $_POST["province"] . "', '" . $_POST["postalcode"] . "', '" . $_POST["phonenumber"] . "')";
    
    $set_primary = "UPDATE customer_addresses SET Primary_Address = 'NO' WHERE CustomerID = '" . $newID . "'; ";
    
    if (isset($_POST["primary"])){
        mysqli_query($conn, $set_primary);
        if (mysqli_query($conn, $insert_primary_row)) {
            header("Location: profile.php");
            exit;
        } else {
          echo "Error: " . $insert_primary_row . "<br>" . mysqli_error($conn);
        }
    } else {
        if (mysqli_query($conn, $insert_row)) {
          header("Location: profile.php");
          exit;
        } else {
          echo "Error: " . $insert_row . "<br>" . mysqli_error($conn);
        }
        
    }
       

        


?>