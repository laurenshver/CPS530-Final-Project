<?php session_start(); ?>
<!DOCTYPE html>
<html>

<head>
    <title>Cart | Dash</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="profile.css">
    <link rel="stylesheet" href="order_details.css">
    <link rel="stylesheet" href="cart.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(function () {
            $("#menu-bar").load("menu-bar.php");
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
    <h1 class="page-title">Your Shopping Cart</h1>
    <div class="row">
        <div class="two-thirds-column">
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
                                                    <form action='cart-remove.php' method='post'>
                                                    <input type='submit' value='Remove Item'>
                                                    <input type='hidden' value='".$x."' name='index'>
                                                    <input type='hidden' value='".$_SESSION['quantity'][$x]."' name='quantity'>
                                                    <input type='hidden' value='".$_SESSION['itemID'][$x]."' name='id'>
                                                    <input type='hidden' value='".$_SESSION['itemsubID'][$x]."' name='subid'>
                                                    </form>
                                                </div>
                                            </div>
                                            <hr>
                                        </div>
                                    </div>
                                </div>";
                            }
                            
                        }
                    }
                    $taxes = $subtotal * 0.13;
                    $est_total = $taxes + $subtotal + $delivery;
                    echo "</div>
                            <div class='one-third-column'>
                                <h2 class='section-title'>Summary</h2>
                                <div class='sub-section'>
                                    
                                    <div class='section-details'>
                                        <div class='row'>
                                        <div class='sub-column-2'>
                                            <p class='charges-names'>Subtotal</p>
                                            <p class='charges-names'>GST/HST</p>
                                            <p class='charges-names'>delivery</p>
                                            <hr>
                                            <p class='charges-names'>Estimated total</p>
                                        </div>
                                        <div class='sub-column-2'>
                                            <p class='charges-amount'>".$subtotal."</p>
                                            <p class='charges-amount'>".number_format($taxes, 2)."</p>
                                            <p class='charges-amount'> ".number_format($delivery, 2)." </p>
                                            <hr>
                                            <p class='charges-amount'>".number_format($est_total, 2)."</p>
                                        </div>
                                    </div>
                                    <div style='text-align: center;'>
                                    <h2 class='element-title'>Select Tip %</h2><br>
                                        <form action='checkout.php' method='post'>
                                            <div class='tip-buttons'>
                                                <input type='radio' id='ten' name='tip' value='0.10' checked><label for='ten'>10%</label>
                                                <input type='radio' id='fifteen' name='tip' value='0.15'><label for='fifteen'>15%</label>
                                                <input type='radio' id='twenty' name='tip' value='0.20'><label for='twenty'>20%</label>
                                            </div>
                                            <br>
                                            <input type='hidden' value='".$subtotal."' id='subtotal' name='subtotal'>
                                            <input type='hidden' value='".$taxes."' id='taxes' name='taxes'>
                                            <input type='hidden' value='".$delivery."' id='delivery' name='delivery'>
                                            <input type='hidden' value='".$est_total."' id='est' name='est'>
                                            <input type='submit' value='CHECKOUT' id='cartsubmit' name='cartsubmit'>

                                        </form>
                                    </div>
                                    
                                </div>
                                </div>
                            </div>";
                    
                    } else { echo ""; }
                    
                    ?>
        </div>
    </div>
    <div id='foot'></div>
</body>

</html>