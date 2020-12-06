<!DOCTYPE html>
<html>

<head>
    <link rel='stylesheet' href='edit-profile.css'>
    <link rel='stylesheet' href='profile.css'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <script src='https://code.jquery.com/jquery-1.12.4.js'></script>
    <script src='https://code.jquery.com/ui/1.12.1/jquery-ui.js'></script>
    <script src='https://code.jquery.com/jquery-1.10.2.js'></script>
    <title>Dash | Edit Profile</title>
    <script>
        $(function () {
            $('#menu-bar').load('menu-bar.html');
        });
        $(function () {
        $('#foot').load('foot.html');
        });
    </script>
</head>

<body>
    <?php 
        $servername = 'localhost';
        $username = 'id15411953_group13';
        $password = '^G97OWfs[(+Zv(\K';
        $dbname = 'id15411953_cpsproject';

        // Create connection
        $conn = mysqli_connect($servername, $username, $password, $dbname);

        // Check connection
        if (!$conn) {
        die('Connection failed: ' . mysqli_connect_error());
        }
    ?>
    <div id='menu-bar'></div>
    <h1 class='page-title'>Edit Profile</h1>
    <p class='edit-button' style='text-align: center;'><a id='top-link' href="profile.php">Return to Profile Summary</a></p>
    <div class='sub-section'>
        <p class='section-title'>Profile Details</p>
        <div class='section-details'>
            <form action="edit-account.php" method="post">
            <?php 
            $id =  $_COOKIE['userID'];
            $profile_sql = 'SELECT * from customers where CustomerID = ' . $id . ';';
            $result = mysqli_query($conn, $profile_sql);
            
            if (mysqli_num_rows($result) > 0){
                while ($row = mysqli_fetch_assoc($result)){
                   $code = substr($row['PhoneNumber'], 0, 3);
                   $mid = substr($row['PhoneNumber'], 3, 3);
                   $end = substr($row['PhoneNumber'], 6, 4);
                   $number = $code . ' - ' . $mid . ' - ' . $end;
                   echo "<div class='row'>
                    <div class='column-3'> 
                        <label for='fname'>First Name</label>
                        <input type='text' id='fname' name='fname' value='". $row['FirstName'] ."'><br>
                        <input type='hidden' id='fname' name='hidden-fname' value='". $row['FirstName'] ."'><br>
                    </div>
                    <div class='column-3'>
                        <label for='lname'>Last Name</label>
                        <input type='text' id='lname' name='lname' value='". $row['LastName'] ."'><br>
                        <input type='hidden' id='lname' name='hidden-lname' value='". $row['LastName'] ."'><br>
                    </div>
                    <div class='column-3'>
                        <label for='phonenum'>Phone Number</label>
                        <input type='text' id='phonenum' name='phonenum' value='". $number ."'><br>
                        <input type='hidden' id='phonenum' name='hidden-phonenum' value='". $row['PhoneNumber'] ."'><br>
                    </div>
                </div>
                <div class='row'>
                    <div class='column-3'>
                        <label for='email'>Email</label><br>
                    <input type='text' id='email' name='email' value='". $row['Email'] ."'><br>
                    <input type='hidden' id='email' name='hidden-email' value='". $row['Email'] ."'><br>
                    </div>
                    <div class='column-3'>
                        <label for='password'>Password</label>
                <input type='password' id='password' name='password' value='". $row['Password'] ."'><br>
                <input type='hidden' id='password' name='hidden-password' value='". $row['Password'] ."'><br>
                    </div>
                </div>
                <br>
                <input type='submit' value='Update Profile'>";
                }
                
            }
            
            ?>
            </form>
        </div>
    </div>
    <div class='sub-section'>
        <p class='section-title'>Addresses</p>
        <div class='section-details'>
            <!--Display Addresses-->
                <?php 
                $address_sql = 'SELECT * from customer_addresses where CustomerID = ' . $id . ' ORDER BY Primary_Address;';
                // echo $address_sql;
                $result = mysqli_query($conn, $address_sql);
                
                if (mysqli_num_rows($result) > 0){
                    while ($row = mysqli_fetch_assoc($result)){
                        $code = substr($row['PhoneNumber'], 0, 3);
                        $mid = substr($row['PhoneNumber'], 3, 3);
                        $end = substr($row['PhoneNumber'], 6, 4);
                        $number = $code . ' - ' . $mid . ' - ' . $end;
                    //   echo $row['Name'] . $row['Primary_Address'] . $row['Address'] . $row['City'] . $row['Province'] . $row['PostalCode'] . $row['PhoneNumber'];
                    if ($row["Primary_Address"] == 'YES'){
                        echo "<p class='section-title' style='color: #ba181b;'>Primary Address</p>";
                    }
                       echo "<form action='edit-address.php' method='post'>
                        <div class='row'>
                            <div class='column-3'>
                                <label for='address-name'>Address Name</label><br>
                                <input type='text' id='address-name' name='address-name' value='". $row['Name'] ."'><br>
                                <input type='hidden' name='hidden-address-name' value='". $row['Name'] ."'>
                            </div>
                            <div class='column-3'>
                                <label for='address'>Address</label><br>
                                <input type='text' id='address' name='address' value='". $row['Address'] ."'><br>
                                <input type='hidden' name='hidden-address' value='". $row['Address'] ."'>
                            </div>
                            <div class='column-3'>
                                <label for='city'>City</label><br>
                                <input type='text' id='city' name='city' value='". $row['City'] ."'><br>
                                <input type='hidden' name='hidden-city' value='". $row['City'] ."'>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='column-3'>
                                <label for='province'>Province</label><br>
                                <input type='text' id='province' name='province' value='". $row['Province'] ."'><br><br>
                                <input type='hidden' name='hidden-province' value='". $row['Province'] ."'>
                            </div>
                            <div class='column-3'>
                                <label for='postalcode'>Postal Code</label><br>
                                <input type='text' id='postalcode' name='postalcode' value='". $row['PostalCode'] ."'>
                                <input type='hidden' name='hidden-postalcode' value='". $row['PostalCode'] ."'>
                            </div>
                            <div class='column-3'>
                                <label for='phonenumber'>Phone Number</label><br>
                                <input type='text' id='phonenumber' name='phonenumber' value='". $number ."'>
                                <input type='hidden' name='hidden-phonenumber' value='". $row['PhoneNumber'] ."'>
                            </div>
                        </div>
                        <br>
                        <input type='submit' name= 'update_address'value='Update Address'>
                        <input type='submit' name='delete_address' value='Delete Address'>
                        <hr>
                        <br>
                    </form>";
                
                    }
                    
                }
                
                ?>
                <p class='section-title' style='color: #ba181b;'>Change Primary Address</p>
                <form action="edit-primary-address.php" method="post">
                <?php 
                $primary_sql = 'SELECT Name, Primary_Address from customer_addresses where CustomerID = ' . $id . ' ORDER BY Primary_Address;';
                $result = mysqli_query($conn, $primary_sql);
                
                if (mysqli_num_rows($result) > 0){
                    while ($row = mysqli_fetch_assoc($result)){ 
                        if ($row['Primary_Address'] == 'YES'){
                            echo "<label for='primary'>". $row['Name'] ."</label>";
                            echo  "<input type='radio' name='primary' id='primary' value= '".$row['Name']."' checked><br>";
                        } else {
                            echo "<label for='work'>". $row['Name'] ."</label><input type='radio' id='work' name='primary' value= '".$row['Name']."'><br> ";
                        }
                        
                        
                    }
                    
                }
                echo "<br>";
                echo "<input type='submit' value='Update Primary Address'> ";
                ?>
                </form>
        </div>
    </div>
    <div class='sub-section'>
        <p class='section-title' id="edit-cc-section">Credit Cards</p>
        <div class='section-details'>
            <?php 
                $sql = "select creditcardtype, creditcardnumber, creditcardexpiry from customer_creditcards WHERE CustomerID=" . $id . ";";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0){
                    while ($row = mysqli_fetch_assoc($result)){
                        echo "<div class='row'>
                    <div class='column-3'>
                        <p><span class='element-title'>" . strtoupper($row["creditcardtype"]) . "</span> " ."*" . substr($row["creditcardnumber"], -4) . "</p>
                        <p><span class='element-title'>Expiry </span>" . $row["creditcardexpiry"] . "</p>
                    </div>
                    <div class='column-3'>
                    <br>
                        <form action='edit-creditcard.php' method='post'>
                            <input type='hidden' name='ccnum' value='" . $row["creditcardnumber"] . "'>
                            <input type='submit' name='delete_card' value='Delete Card'>
                        </form>
                    </div>
                </div>
                <hr>";
                    }
                }
            
            ?>
        </div>
    </div>
    <br>
    <br><br>
    <div id='foot'></div>
</body>

</html>