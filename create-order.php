<?php 
    session_start();
    $servername = "localhost";
    $username = "id15411953_group13";
    $password = "^G97OWfs[(+Zv(\K";
    $dbname = "id15411953_cpsproject";
    // cookie variables
    $cookie_name= "userID";
    $userID= $_COOKIE[$cookie_name];
    
    
    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    
    // Check connection
    if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "Select MAX(OrderID) as max from orders";
    $result = mysqli_query($conn, $sql);
    
    // get biggest customer id and add 1 for new id
    if (mysqli_num_rows($result) > 0){
        while ($row = mysqli_fetch_assoc($result)){
          $orderID =  intval($row["max"]) + 1;
        }
    }
    
    
    // var_dump($_POST);
    $date = date("Y-m-d");
    
    $insert_row = "INSERT INTO orders (OrderID, CustomerID, OrderDate, OrderStatus, TaxesPaid, DeliveryCost, Tip, Subtotal, TotalPaid, DeliveredAddress, DeliveredCity, DeliveredPC, DeliveredProvince, CreditCardNum, DateDelivered) VALUES (".$orderID.", ".$userID.", CAST('".$date."' AS DATE) , 'Order Placed', ".$_POST['taxes'].", ".$_POST['delivery'].", ".$_POST['tip'].", ".$_POST['subtotal'].", ".$_POST['total'].", '".$_POST['address']."', '".$_POST['city']."', '".$_POST['pc']."', '".$_POST['province']."', '".$_POST['cc']."', NULL)";
    
        if (mysqli_query($conn, $insert_row)){
        
        $num_elements = count($_SESSION['itemID']);
        $subtotal = 0;
        $delivery = 0;
        
        foreach (range(0,$num_elements - 1) as $x){
            $query = "SELECT storeItems.*, stores.StoreID 
            FROM storeItems
            JOIN stores
            ON storeItems.StoreID = stores.StoreID
            WHERE ItemID = ".$_SESSION['itemID'][$x]." AND ItemSubID = ". $_SESSION['itemsubID'][$x] . " 
            ORDER BY stores.StoreName;";
            
            $result = mysqli_query($conn, $query);
                    
            if (mysqli_num_rows($result) > 0){
                while ($row = mysqli_fetch_assoc($result)){
                    $insert_items = "INSERT INTO ordered_items VALUES (".$orderID.", ".$row['StoreID'].", ".$row['ItemID'].", ".$row['ItemSubID'].", ".$_SESSION['quantity'][$x].", ".$row['ItemPrice'].");";
                    if (mysqli_query($conn, $insert_items)){
                        header("Location: order_summary.php");
                        session_destroy();
                        exit; 
                    } else {
                        echo mysqli_error($conn);
                    }
                }
                
            }
        }
        } else {
            echo date("Y-m-d");
            echo mysqli_error($conn);
        }



?>