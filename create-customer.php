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
    
    
    $sql = "Select MAX(CustomerID) as max from customers";
    $result = mysqli_query($conn, $sql);
    
    
    if (mysqli_num_rows($result) > 0){
        while ($row = mysqli_fetch_assoc($result)){
          $newID =  intval($row["max"]) + 1;
        }
    }
        
    $required = array('firstname', 'email' , 'signup-password');
    $error = false;
    foreach($required as $field){
        if (empty($_POST[$field])){
            $error = true;
        }
    }
    
    if ($error){
        echo "invalid input";
    } else {
        
        $insert_row = "INSERT INTO customers (CustomerID, FirstName, LastName, Email, Password, PhoneNumber) VALUES (" . $newID .", '" . $_POST["firstname"] . "', '" . $_POST["lastname"] . "', '" . $_POST["email"] . "', '" . $_POST["signup-password"] . "', '" . $_POST["phone-number"] . "')";
        
    setcookie($cookie_name, $newID, time() + (86400 * 30), "/"); //expires in 1 day
    
    if (mysqli_query($conn, $insert_row)) {
        header("Location: profile.php");
        exit;
    } else {
      echo "Error: " . $insert_row . "<br>" . mysqli_error($conn);
    }
    
    
    }


?>