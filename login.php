<!DOCTYPE html>
<html>

<head>
    <title>Dash | Login</title>
    <link rel="stylesheet" href="login.css">
    <link rel="stylesheet" href="profile.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Monoton&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
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
    <br><br>
    <img src="logo_transparent.png" alt="logo_transparent" height="200">
    <p class="title">Dash</p>

    <div class="row">
        <p class="instructions">Login or Sign Up</p>
        <div class="column-2">
            <h2>Login</h2>
            <form action="system-login.php" method="post">
                <label for="email">Email</label><br>
                <input type="email" name="email"
                    pattern="[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?"
                    required>
                <label for="password">Password</label><br>
                <input type="password" id="password" name="signin-password" required><br>
                <input type="submit" value="LOGIN">
            </form>
        </div>
        <div class="column-2">
            <h2>Sign Up</h2>
            <form action="create-customer.php" method="post">
                <div class="row">
                    <div class="column-2">
                        <label for="firstname">First Name</label><br>
                        <input type="text"name="firstname" required><br>
                    </div>
                    <div class="column-2">
                        <label for="lastname">Last Name</label><br>
                        <input type="text" name="lastname" ><br>
                    </div>
                </div>
                <div class="row">
                    <div class="column-2">
                        <label for="email">Email</label><br>
                        <input type="email" name="email"
                            pattern="[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?"
                            required>
                    </div>
                    <div class="column-2">
                        <label for="phone-number">Phone Number</label><br>
                        <input type="text" id="phone-number" name="phone-number"><br>
                    </div>
                </div>
                <div class="row">
                    <div class="column-2">
                        <label for="password">Password</label><br>
                        <input type="password" id="password" name="signup-password" required><br>
                    </div>
                    <div class="column-2">
                        <label for="confirm-password">Confirm Password</label><br>
                        <input type="password" id="confirm-password" name="confirm-password" required><br>
                    </div>
                </div>
                <input type="submit" value="SIGN UP">
            </form>

        </div>
    </div>
    <div id="foot"></div>
</body>

</html>