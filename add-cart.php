<?php 
session_start();

// $_SESSION['itemID'] = array();

if (isset($_SESSION['itemID'])){
    array_push($_SESSION['itemID'], intval($_POST['itemID']));
    array_push($_SESSION['itemsubID'], intval($_POST['subID']));
    array_push($_SESSION['quantity'], intval($_POST['quantity']));
    header("Location: cart.php");
    exit;
} else {
    header("Location: login.php");
    exit;
}




// var_dump($_SESSION['itemID']);
// var_dump($_SESSION['itemsubID']);
// var_dump($_SESSION['quantity']);


?>