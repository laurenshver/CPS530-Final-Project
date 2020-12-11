<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="profile.css">
    <link rel="stylesheet" href="order_details.css">
    <link rel="stylesheet" href="cart.css">
    <link rel="stylesheet" href="checkout.css">
     <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
    <script>
            $(function () {
                $("#menu-bar").load("menu-bar.php");
            });
            $(function () {
            $("#foot").load("foot.html");
            });
        </script>
    <title>Review Order | Dash</title>

</head>
<body>
    <?php
        $servername = "localhost";
        $username = "id15411953_group13";
        $password = "^G97OWfs[(+Zv(\K";
        $dbname = "id15411953_cpsproject";
        $id = $_COOKIE['userID'];
        // Create connection
        $conn = mysqli_connect($servername, $username, $password, $dbname);
        $address = "";
        $city = "";
        $pc = "";
        $province = "";
        $ccnum = "";
        // Check connection
        if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
        }
    ?>
    <div id="menu-bar"></div>
    <h1 class="page-title">Place Order</h1>
    <div class="row">
        <div class="two-thirds-column">
            <div class="sub-column-2">
            <h2 class="section-title">Shipping Address</h2>
            <div class="section-details" style="height:200px;">
                <?php 
                $sql = "select Name, Address, City, PostalCode, Province, PhoneNumber from customer_addresses where Name='". $_POST['address'] ."' AND CustomerID=" . intval($id) . ";";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0){
                    while ($row = mysqli_fetch_assoc($result)){
                        $numbers = preg_replace("/[^0-9]/", "", $row["PhoneNumber"] );
                        $code = substr($numbers, 0,3);
                        $mid = substr($numbers, 3,3);
                        $end = substr($numbers, 6);
                        $pn = "(" . $code . ") " . $mid . " - " . $end;
                       echo "<p><span class='element-title'>" . $row["Name"] . "</span><br>" . $row["Address"] . "<br>" . $row["City"] . ", ". $row["Province"] . "<br>" .$row["PostalCode"] . "<br>" . $pn . "</p>";
                       $address = $row["Address"];
                       $city = $row['City'];
                       $pc = $row['PostalCode'];
                       $province = $row['Province'];
                    }
                }
            ?>
            </div>
            </div>
            <div class="sub-column-2">
                <h2 class="section-title">Credit Card</h2>
                <div class="section-details" style="height:200px;">
                <?php 
                $sql = "select creditcardtype, creditcardnumber, creditcardexpiry from customer_creditcards WHERE creditcardnumber= '". $_POST['cc']."' AND CustomerID=" . intval($id) . ";";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0){
                    while ($row = mysqli_fetch_assoc($result)){
                       echo "<p><span class='element-title'>" . strtoupper($row["creditcardtype"]) . "</span> " ."*" . substr($row["creditcardnumber"], -4) . "</p>";
                       echo "<p><span class='element-title'>Expiry </span>" . $row["creditcardexpiry"] . "</p>";
                       $ccnum = $row['creditcardnumber'];
                    }
                }
                
                ?>
                </div>
            </div>
        </div>
        <div class="one-third-column">
            <h2 class="section-title">Summary</h2>
            <div class="sub-section">
                <div class="section-details">
                    <div class="row">
                    <div class="sub-column-2">
                        <p class="charges-names">Subtotal</p>
                        <p class="charges-names">GST/HST</p>
                        <p class="charges-names">delivery</p>
                        <p class="charges-names">tip</p>
                        <hr>
                        <p class="charges-names">total</p>
                    </div>
                    <?php
                    
                    $tip_percent = floatval($_POST['tip']);
                    $subtotal = floatval($_POST['subtotal']);
                    $tip = $tip_percent * $subtotal;
                    
                    
                    echo "<div class='sub-column-2'>
                        <p class='charges-amount'>".number_format($_POST['subtotal'],2)."</p>
                        <p class='charges-amount'>".number_format($_POST['taxes'],2)."</p>
                        <p class='charges-amount'>".number_format($_POST['delivery'],2)."</p>
                        <p class='charges-amount'>".number_format($tip, 2)."</p>
                        
                        <hr>
                        <p class='charges-amount'>".number_format($_POST['total'], 2)."</p>
                    </div>";
                    
                    ?>
                    
                </div>
                <div style="text-align: center;">
                        <form action="create-order.php" method='post'>
                            <input type="submit" value="Place Order" id="confirmation">
                        
                        
                        <?php 
                        echo "<input type='hidden'  id='confirmation' name='address' value='".$address."'>";
                        echo "<input type='hidden'  id='confirmation' name='city' value='".$city."'>";
                        echo "<input type='hidden'  id='confirmation' name='province' value='".$province."'>";
                        echo "<input type='hidden'  id='confirmation' name='pc' value='".$pc."'>";
                        
                        echo "<input type='hidden'  id='confirmation' name='cc' value='".$ccnum."'>";
                        
                        
                        // $$$$$
                        echo "<input type='hidden'  id='confirmation' name='subtotal' value='".floatval($subtotal)."'>";
                        echo "<input type='hidden'  id='confirmation' name='tip' value='".floatval($tip)."'>";
                        echo "<input type='hidden'  id='confirmation' name='delivery' value='".floatval($_POST['delivery'])."'>";
                        echo "<input type='hidden'  id='confirmation' name='taxes' value='".floatval($_POST['taxes'])."'>";
                        echo "<input type='hidden'  id='confirmation' name='total' value='".floatval($_POST['total'])."'>";
                        ?>
                    </form>
                </div>
                
            </div>
            </div>
    </div>
    </div>
    <div class="row">
            <div class="two-thirds-column" style="width:100%;">
            <h2 class="section-title">Order Contents</h2>
                <?php 
                    // var_dump($_SESSION['itemID']);
                    // var_dump($_SESSION['itemsubID']);
                    // var_dump($_SESSION['quantity']);
                    $num_elements = count($_SESSION['itemID']);
                    $subtotal = 0;
                    $delivery = 0;
                    if ($num_elements > 0){
                    
                    foreach (range(0,$num_elements - 1) as $x){
                        $query = "SELECT storeItems.*, stores.StoreName, stores.DeliveryPrice 
                        FROM storeItems
                        JOIN stores
                        ON storeItems.StoreID = stores.StoreID
                        WHERE ItemID = ".$_SESSION['itemID'][$x]." AND ItemSubID = ". $_SESSION['itemsubID'][$x] . " 
                        ORDER BY stores.StoreName;";
                        
                        $result = mysqli_query($conn, $query);
                                
                        if (mysqli_num_rows($result) > 0){
                            while ($row = mysqli_fetch_assoc($result)){
                                $subtotal = $subtotal + ($row['ItemPrice'] * $_SESSION['quantity'][$x]);
                                $delivery = $delivery + $row['DeliveryPrice'];
                                echo "<div class='sub-section'>
                                    <div class='section-details'>
                                        <div class='book-item'>
                                            <p class='element-title'>".$row['StoreName']."</p>
                                            <hr>
                                            <div class='row' style='height: 200px;'>
                                                <div class='column-4';'>
                                                    <p><img alt= 'itemphoto' src = '".$row['PictureURL']."' height= 150px></p>
                                                </div>
                                                <div class='column-4' style='padding:40px 0;'>
                                                    <p><span class='element-title'>". $row['ItemName']."</span></p>";
                                                    if (isset($row["ItemAuthor"])){
                                                        echo "<p>".$row["ItemAuthor"]."</p>";
                                                    } else {
                                                        echo "<p>Colour: ".$row["ItemColour"]." <br>Size: ".$row["ItemSize"]."</p>";
                                                    }
                                                    
                                                    echo "<p><span class='element-title'>". $row['ItemPrice'] ."</span></p>
                                                </div>
                                                <div class='column-4' style='padding:70px 0;'>
                                                    <p><span class='element-title'>QTY: ". $_SESSION['quantity'][$x] ."</span></p>
                                                </div>
                                                <div class='column-4' style='padding:70px 0;'>
                                                    <p><span class='element-title'>$". floatval($row['ItemPrice']) * floatval($_SESSION['quantity'][$x]) ."</span></p>
                                                </div>
                                            </div>
                                            <hr>
                                        </div>
                                    </div>
                                </div>";
                            }
                            
                        }
                    }
                    echo "</div>";
                            
                    
                    } else { echo ""; }
                    
                    ?>
        </div>
    </div>




  <div id="foot"></div>

 </body>
</html>