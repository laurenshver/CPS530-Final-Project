<!DOCTYPE html>
<html>

<head>
    <title>Order Details | Dash</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="profile.css">
    <link rel="stylesheet" href="order_summary.css">
    <link rel="stylesheet" href="order_details.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <script src="https://kit.fontawesome.com/08e9ccd70e.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
    <script>
        $(function () {
            $("#menu-bar").load("menu-bar.html");
        });
        $(function () {
        $("#foot").load("foot.html");
        });
    </script>
</head>

<body>
    <?php 
        $servername = "localhost";
        $username = "id15411953_group13";
        $password = "^G97OWfs[(+Zv(\K";
        $dbname = "id15411953_cpsproject";
    
        // Create connection
        $conn = mysqli_connect($servername, $username, $password, $dbname);
    
        // Check connection
        if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
        }
    ?>
    <div id="menu-bar"></div>
    <h1 class="page-title">Purchase Details</h1>
    <p class="edit-button" style="text-align: center;"><a href="order_summary.php">Return to Your Orders</a></p>
    <div class="sub-section">
        <?php
        $x = array();
        parse_str($_SERVER['QUERY_STRING'], $x);
        $num = $x['order_number'];
        $id =  $_COOKIE['userID'];
        
        echo "<h2 class='section-title'>Order Number: ". $num ."</h2>" ;
            
        $order_sql = "SELECT * from orders where CustomerID = " . $id . " AND OrderID = " . $num . ";";
        $items = "SELECT SUM(quantity_ordered) as NumItems from ordered_items where OrderID = ".$num.";";
        $result = mysqli_query($conn, $order_sql);
        $num_items = mysqli_query($conn, $items);
        $r = mysqli_fetch_assoc($num_items);
        $sum = $r['NumItems'];
        
        if (mysqli_num_rows($result) > 0){
            while ($row = mysqli_fetch_assoc($result)){
                echo "<div class='section-details'>
            <p class='tracking-button'><a >Order Tracking</a></p>            
            <hr>
            <div class='row' style='height: 100px;'>
                <div class='column-4'>
                    <p><span class='element-title'>Order Status: </span></p>
                    <p class='order-status'>". $row['OrderStatus']  ."</p> ";
                    
                    if ($row['OrderStatus'] == 'Order Placed'){
                        echo "<i id='icons' class='fas fa-receipt fa-2x'></i>";
                    } elseif ($row['OrderStatus'] == 'Order Processing') {
                        echo "<i id='icons' class='fas fa-tasks fa-2x'></i>";
                    } elseif ($row['OrderStatus'] == 'Order Dispatched') {
                        echo "<i id='icons' class='fas fa-truck fa-2x'></i>";
                    } elseif ($row['OrderStatus'] == 'Order Delivered'){
                        echo "<i id = 'icons' class='fas fa-check-circle fa-lg'></i>";
                    }
                    
                
                echo "</div>
                <div class='column-4'>
                    <p><span class='element-title'>Order Date: </span><br>". $row['OrderDate']  ."</p>
                </div>
                <div class='column-4'>
                    <p><span class='element-title'># of Items: </span><br>".$sum."</p>
                </div>
                <div class='column-4'>
                    <p><span class='element-title'>Date Delivered: </span><br>".$row['DateDelivered']."</p>
                </div>
            </div>
            <hr>
            <div class='row'>
                <div class='column-3'>
                    <p><span class='element-title'>Shipped To:</span><br>".$row['DeliveredAddress']." <br> ".$row['DeliveredCity'].", ".$row['DeliveredProvince']." <br> ".$row['DeliveredPC']." </p>
                </div>
                <div class='column-3'>
                    <p><span class='element-title'>Payment Method:<br><br> Credit Card Ending In </span><br>*".substr($row['CreditCardNum'], -4, 4)."</p>
                    
                </div>
                <div class='column-3'>
                    <p><span class='element-title'>Summary of Charges:</span></p>
                    <div class='sub-column-2'>
                        <p class='charges-names'>Subtotal</p>
                        <p class='charges-names'>GST/HST</p>
                        <p class='charges-names'>delivery</p>
                        <p class='charges-names'>tip</p>
                        <hr>
                        <p class='charges-names'>order total</p>
                    </div>
                    <div class='sub-column-2'>
                        <p class='charges-amount'>".$row['Subtotal']."</p>
                        <p class='charges-amount'>".$row['TaxesPaid']."</p>
                        <p class='charges-amount'>".$row['DeliveryCost']."</p>
                        <p class='charges-amount'>".$row['Tip']."</p>
                        <hr>
                        <p class='charges-amount'>".$row['TotalPaid']."</p>
                    </div>
                </div>
            </div>
        </div>
    </div>";
    
            }
            
        }
        
        
        ?>
    <br><br>
    <div class="sub-section">
        <h2 class="section-title">Order Contents</h2>
        <div class="section-details">
                <?php 
                $items_sql = "SELECT * 
                FROM ordered_items 
                LEFT JOIN storeItems ON ordered_items.ItemID = storeItems.ItemID AND ordered_items.ItemSubID = storeItems.ItemSubID
                LEFT JOIN stores ON ordered_items.StoreID = stores.StoreID
                WHERE OrderID = " . $num . ";";
                $result = mysqli_query($conn, $items_sql);
                
                if (mysqli_num_rows($result) > 0){
                    while ($row = mysqli_fetch_assoc($result)){
                        echo "<p class='element-title'>".$row["StoreName"]."</p>
                                <hr>
                                <div class='row' style='height: 200px;'>
                                    <div class='column-4'>
                                        <p><img height='150px' alt='item-picture' src='".$row["PictureURL"]."'></p>
                                    </div>
                                    <div class='column-4' style='padding:40px 0;'>
                                        <p><span class='element-title'>".$row["ItemName"]."</span></p>";
                                        
                                        if (isset($row["ItemAuthor"])){
                                            echo "<p>".$row["ItemAuthor"]."</p>";
                                        } else {
                                            echo "<p>Colour: ".$row["ItemColour"]." <br>Size: ".$row["ItemSize"]."</p>";
                                        }
                
                                        echo "<p><span class='element-title'>$". $row["ItemPrice"]."</span></p>
                                    </div>
                                    <div class='column-4' style='padding:70px 0;'>
                                        <p><span class='element-title' >QTY: ".$row["quantity_ordered"]."</span></p>
                                    </div>
                                    <div class='column-4' style='padding:70px 0;'>
                                        <p><span class='element-title'>$". floatval($row["ItemPrice"]) * floatval($row["quantity_ordered"]) ."</span></p>
                                    </div>
                                </div><br><br>";
                    }
                    
                }
                
                
                
                
                
                ?>
            </div>
        </div>
    </div>
    <div id="foot"></div>
</body>

</html>