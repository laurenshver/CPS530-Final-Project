<!DOCTYPE html>
<html>

<head>
    <title>Order Summary | Dash</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="profile.css">
    <link rel="stylesheet" href="order_summary.css">
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
    <div id="menu-bar"></div>
    <h1 class="page-title">Your Orders</h1>
    <p class="edit-button" style="text-align: center;"><a id= "top-link" href="profile.php">Return to Profile</a></p>
    <br>
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
    <div class="sub-section">
        <h2 class="section-title">Current Orders</h2>
        <div class="section-details">
            <?php 
            $id =  $_COOKIE['userID'];
            $profile_sql = "SELECT OrderID, OrderStatus, OrderDate, TotalPaid from orders where CustomerID = " . $id . " AND OrderStatus <> 'Order Delivered';";
            $result = mysqli_query($conn, $profile_sql);
            
            if (mysqli_num_rows($result) > 0){
                while ($row = mysqli_fetch_assoc($result)){ 
                    // echo $row['OrderID'], $row['OrderStatus'], $row['OrderDate'], $row['TotalPaid'];
                    echo "<div class='row'>
                        <div class='column left'> ";
                        
                    if ($row['OrderStatus'] == 'Order Placed'){
                        echo "<i id='icons' class='fas fa-receipt fa-2x'></i>";
                    } elseif ($row['OrderStatus'] == 'Order Processing') {
                        echo "<i id='icons' class='fas fa-tasks fa-2x'></i>";
                    } elseif ($row['OrderStatus'] == 'Order Dispatched') {
                        echo "<i id='icons' class='fas fa-truck fa-2x'></i>";
                    } 
                       echo "</div>
                        <div class='column middle section-details'>
                            <p><span class='element-title'>Order Number: </span>" . $row['OrderID'] ."</p>
                            <p><span class='element-title'>Status: </span>" . $row['OrderStatus'] ."</p>
                            <p><span class='element-title'>Date: </span>" . $row['OrderDate'] ."</p>
                            <p><span class='element-title'>Total: </span>" . $row['TotalPaid'] ."</p>
                        </div>
                        <div class='column right'>
                            <i id='icons' class='fas fa-chevron-right fa-2x'></i>
                        </div>
                    </div>
                    <hr>";
                }
                
            } 
            ?>
        </div>
    </div>
    <br><br>
    <div class="sub-section">
        <h2 class="section-title">Past Orders</h2>
        <div class="section-details">
            <?php 
            $id =  $_COOKIE['userID'];
            $profile_sql = "SELECT OrderID, OrderStatus, OrderDate, TotalPaid from orders where CustomerID = " . $id . " AND OrderStatus = 'Order Delivered';";
            $result = mysqli_query($conn, $profile_sql);
            
            if (mysqli_num_rows($result) > 0){
                while ($row = mysqli_fetch_assoc($result)){ 
                    // echo $row['OrderID'], $row['OrderStatus'], $row['OrderDate'], $row['TotalPaid'];
                    echo "<div class='row'>
                        <div class='column left'>
                        <i id= 'icons' class='fas fa-check-circle fa-2x'></i>
                       </div>
                        <div class='column middle section-details'>
                            <p><span class='element-title'>Order Number: </span>" . $row['OrderID'] ."</p>
                            <p><span class='element-title'>Status: </span>" . $row['OrderStatus'] ."</p>
                            <p><span class='element-title'>Date: </span>" . $row['OrderDate'] ."</p>
                            <p><span class='element-title'>Total: </span>" . $row['TotalPaid'] ."</p>
                        </div>
                        <div class='column right'>
                            <a id='icons' class='fas fa-chevron-right fa-2x' href='order_details.php?order_number=" . $row['OrderID'] . "'></a>
                        </div>
                    </div>
                    <hr>";
                }
                
            } 
            ?>
        </div>
    </div>
    <div id="foot"></div>
</body>

</html>