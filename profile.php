<!--Lauren Shver 500776374-->
<!DOCTYPE html>
<html>
    <head>
        <title>Profile | Dash</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="profile.css">
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="profile.js"></script>
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
        <h1 class="page-title">Profile & Settings</h1>
        <p class="edit-button" style="text-align: center;"><a id ="top-link" href="order_summary.php">View Purchase History</a></p>
        <div class="sub-section">
            <p class= "section-title">Your Personal Details</p>
            <div class= "section-details">
                <p class= "edit-button"><a href="edit-profile.php">Edit Details</a></p>
                <hr>
                <?php
                $id = $_COOKIE["userID"];
                $sql = "select FirstName, LastName, PhoneNumber, Email from customers WHERE CustomerID=" . intval($id) . ";";
                $result = mysqli_query($conn, $sql);
                
                
                
                if (mysqli_num_rows($result) > 0){
                    while ($row = mysqli_fetch_assoc($result)){
                        //phone number formatting
                        $numbers = preg_replace("/[^0-9]/", "", $row["PhoneNumber"] );
                        $code = substr($numbers, 0,3);
                        $mid = substr($numbers, 3,3);
                        $end = substr($numbers, 6);
                        $pn = "(" . $code . ") " . $mid . " - " . $end;
                       echo "<p><span class='element-title'>Name: </span>" . $row["FirstName"] . " " . $row["LastName"] . "</p>";
                       echo "<p><span class='element-title'>Email: </span>" . $row["Email"] . "</p>";
                       echo "<p><span class='element-title'>Phone Number: </span>" . $pn . "</p>";
                    }
                }
                
                ?>
            </div>
        </div>
        <br><br>
        <div class="sub-section">
            <p class= "section-title">Your Delivery Addresses</p>
            <div class= "section-details">
                <p class= "edit-button"><a href="edit-profile.php">Edit Details</a></p>
                <hr>
                <?php 
                $sql = "select Name, Address, City, PostalCode, Province, PhoneNumber from customer_addresses where Primary_Address='YES' AND CustomerID=" . intval($id) . ";";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0){
                    while ($row = mysqli_fetch_assoc($result)){
                       echo "<p><span class= 'element-title' style='color: #ba181b;'>Primary</span><br><span class='element-title'>" . $row["Name"] . "</span><br>" . $row["Address"] . "<br>" . $row["City"] . ", ". $row["Province"] . "<br>" .$row["PostalCode"] . "<br>" .$row["PhoneNumber"] . "</p>";
                       echo "<hr>";
                    }
                }
                
                $sql = "select Name, Address, City, PostalCode, Province, PhoneNumber from customer_addresses where Primary_Address='NO'AND CustomerID=" . intval($id) . ";";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0){
                    while ($row = mysqli_fetch_assoc($result)){
                       echo "<p><span class='element-title'>" . $row["Name"] . "</span><br>" . $row["Address"] . "<br>" . $row["City"] . ", ". $row["Province"] . "<br>" .$row["PostalCode"] . "<br>" . $row["PhoneNumber"] . "</p>";
                       echo "<hr>";
                    }
                }
                
                ?>
                <button id="add-address" onclick="displayform('address-form')">Add Address</button>
                <div id="address-form">
                    <form action = "add-address.php" method="post">
                    <div class="row">
                        <div class="column-3">
                            <label for="address-name">Address Name</label><br>
                            <input type="text" id="address-name" name="address-name" required><br>
                        </div>
                        <div class="column-3">
                            <label for="address">Address</label><br>
                            <input type="text" id="address" name="address" required><br>
                        </div>
                        <div class="column-3">
                            <label for="city">City</label><br>
                            <input type="text" id="city" name="city" required><br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="column-3">
                            <label for="province">Province</label><br>
                            <input type="text" id="province" name="province" required><br><br>
                        </div>
                        <div class="column-3">
                            <label for="postalcode">Postal Code</label><br>
                            <input type="text" id="postalcode" name="postalcode" minlength="6" maxlength="6" required>
                        </div>
                        <div class="column-3">
                            <label for="phonenumber">Phone Number</label><br>
                            <input type="text" id="phonenumber" name="phonenumber">
                        </div>
                    </div>
                    <label for="primary" style="color: #ba181b;">Primary Address</label>
                    <input type="checkbox" id="primary" name="primary"><br>
                    <br>
                    <input type="submit" value="Add New Address">
                </form>
                </div>
            </div>
        </div>
        <br><br>
        <div class="sub-section">
            <p class= "section-title">Payment Methods</p>
            <div class= "section-details">
                <p class= "edit-button"><a href="edit-profile.php#edit-cc-section">Edit Details</a></p>
                <hr>
                <?php 
                $sql = "select creditcardtype, creditcardnumber, creditcardexpiry from customer_creditcards WHERE CustomerID=" . intval($id) . ";";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0){
                    while ($row = mysqli_fetch_assoc($result)){
                       echo "<p><span class='element-title'>" . strtoupper($row["creditcardtype"]) . "</span> " ."*" . substr($row["creditcardnumber"], -4) . "</p>";
                       echo "<p><span class='element-title'>Expiry </span>" . $row["creditcardexpiry"] . "</p>";
                       echo "<hr>";
                    }
                }
                
                ?>
                <button onclick="displayform('credit-form')">Add New Card</button>
                <div id="credit-form">
                    <br><br>
                    <form action="add-credit-card.php" method="post">
                    <label for="card-type">Card Type:</label>
                    <select id="credit-card" name="credit-card">
                        <option value="mastercard">MasterCard</option>
                        <option value="visa">Visa</option>
                        <option value="amex">American Express</option>
                    </select>
                    <br><br>
                    <div class="row">
                        <div class="column-3">
                            <label for="card-num">Card Number</label><br>
                            <input type="text" id="card-num" name="card-num" minlength="16" maxlength="16" required>
                        </div>
                        <div class="column-3">
                            <label for="expiry">Expiry Date</label><br>
                            <input type="text" id="expiry" name="expiry" placeholder="MM/YY" required>
                        </div>
                        <div class="column-3">
                            <label for="cvv">CVV</label><br>
                            <input type="text" name="cvv" maxlength="3" required><br>
                        </div>
                    </div>
                    <br><br>
                    <input type="submit" value="Add Card">
                </form>
                </div>
            </div>
        </div>
        <br><br>
        <div id="foot"></div>
    </body>
</html>