<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
        <title>Checkout | Dash</title>

</head>
<body>
<div id="menu-bar"></div>
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
    
    $id = $_COOKIE["userID"];
?>
<h1 class="page-title">Checkout</h1>
<p class="edit-button" style="text-align: center;"><a id="top-link" href="cart.php">Return To Cart</a></p>
<div class="row">
    <div class="two-thirds-column">
        <h2 class="section-title">Your Addresses</h2>
        <div class="sub-section">
            <div class="section-details">
                <form action="review.php" method="post">
            <?php 
        $sql = "select Name, Address, City, PostalCode, Province, PhoneNumber from customer_addresses where Primary_Address='YES' AND CustomerID=" . intval($id) . ";";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0){
            while ($row = mysqli_fetch_assoc($result)){
                $numbers = preg_replace("/[^0-9]/", "", $row["PhoneNumber"] );
                $code = substr($numbers, 0,3);
                $mid = substr($numbers, 3,3);
                $end = substr($numbers, 6);
                $pn = "(" . $code . ") " . $mid . " - " . $end;
                echo "<div class = 'row'><div class='column left'><input type='radio' id='address' name='address' value='".$row["Name"]."' required></div>";
               echo "<div class='column middle'><p><span class= 'element-title' style='color: #ba181b;'>Primary</span><br><span class='element-title'>" . $row["Name"] . "</span><br>" . $row["Address"] . "<br>" . $row["City"] . ", ". $row["Province"] . "<br>" .$row["PostalCode"] . "<br>" . $pn . "</p></div></div>";
               echo "<hr>";
            }
        }
        
        $sql = "select Name, Address, City, PostalCode, Province, PhoneNumber from customer_addresses where Primary_Address='NO'AND CustomerID=" . intval($id) . ";";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0){
            while ($row = mysqli_fetch_assoc($result)){
                // phone number formatting
                $numbers = preg_replace("/[^0-9]/", "", $row["PhoneNumber"] );
                $code = substr($numbers, 0,3);
                $mid = substr($numbers, 3,3);
                $end = substr($numbers, 6);
                $pn = "(" . $code . ") " . $mid . " - " . $end;
                echo "<div class = 'row'><div class='column left'><input type='radio' id='address' name='address' value='".$row["Name"]."'></div>";
               echo "<div class='column middle'><p><span class='element-title'>" . $row["Name"] . "</span><br>" . $row["Address"] . "<br>" . $row["City"] . ", ". $row["Province"] . "<br>" .$row["PostalCode"] . "<br>" . $pn . "</p></div></div>";
               echo "<hr>";
            }
        }
        
    ?>
    </div>
    </div>
    <div class="sub-section">
            <p class= "section-title">Your Payment Methods</p>
            <div class= "section-details">
                <hr>
                <?php 
                $sql = "select creditcardtype, creditcardnumber, creditcardexpiry from customer_creditcards WHERE CustomerID=" . intval($id) . ";";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0){
                    while ($row = mysqli_fetch_assoc($result)){
                        echo "<div class='row'><div class='column left'><input type='radio' id='cc' name='cc' value='".$row["creditcardnumber"]."' required></div>";
                       echo "<div class='column middle'><p><span class='element-title'>" . strtoupper($row["creditcardtype"]) . "</span> " ."*" . substr($row["creditcardnumber"], -4) . "</p>";
                       echo "<p><span class='element-title'>Expiry </span>" . $row["creditcardexpiry"] . "</p></div></div>";
                       echo "<hr>";
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
                    $total = $tip + floatval($_POST['est']);
                    
                    echo "<div class='sub-column-2'>
                        <p class='charges-amount'>".number_format($_POST['subtotal'],2)."</p>
                        <p class='charges-amount'>".number_format($_POST['taxes'],2)."</p>
                        <p class='charges-amount'>".number_format($_POST['delivery'],2)."</p>
                        <p class='charges-amount'>".number_format($tip, 2)."</p>
                        
                        <hr>
                        <p class='charges-amount'>".number_format($total, 2)."</p>
                    </div>";
                    
                    ?>
                    
                </div>
                <div style="text-align: center;">
                        
                        <input type="submit" value="Confirm Order" id="confirmation">
                        <?php 
                        
                        echo "<input type='hidden'  id='confirmation' name='subtotal' value='".$subtotal."'>";
                        echo "<input type='hidden'  id='confirmation' name='tip' value='".$tip."'>";
                        echo "<input type='hidden'  id='confirmation' name='delivery' value='".$_POST['delivery']."'>";
                        echo "<input type='hidden'  id='confirmation' name='taxes' value='".$_POST['taxes']."'>";
                        echo "<input type='hidden'  id='confirmation' name='total' value='".$total."'>";
                        ?>
                    </form>
                </div>
                
            </div>
            </div>
    </div>
</div>
<div id="foot"></div>

</body>
</html>
