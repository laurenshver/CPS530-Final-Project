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
    
    // var_dump($_POST);
    
    $insert_row = "INSERT INTO customer_creditcards (CustomerID, creditcardtype, creditcardnumber, creditcardexpiry, creditcardcvv) VALUES (" . $newID . ", '" . $_POST['credit-card'] . "', '" . $_POST['card-num'] . "', '" . $_POST["expiry"] . "', '". $_POST["cvv"] . "');";
    
    if (mysqli_query($conn, $insert_row)) {
      header("Location: profile.php");
      exit;
    } else {
      echo "Error: " . $insert_row . "<br>" . mysqli_error($conn);
    }
    

       

        


?>