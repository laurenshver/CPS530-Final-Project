<?php
session_start();
// var_dump($_POST);

$id = intval($_POST['id']);
$subid = intval($_POST['subid']);
$quantity = intval($_POST['quantity']);
$index = intval($_POST['index']);
// echo "<br>";

// var_dump($_SESSION['itemID']);
// echo "<br>";

// var_dump($_SESSION['itemsubID']);
// echo "<br>";

// var_dump($_SESSION['quantity']);
// echo "<br>";


if (($key = array_search($id, $_SESSION['itemID'])) !== false){
    unset($_SESSION['itemID'][$key]);
    unset($_SESSION['itemsubID'][$key]);
    unset($_SESSION['quantity'][$index]);
}

header("Location: cart.php");
exit;

// var_dump($_SESSION['itemID']);
// echo "<br>";
// var_dump($_SESSION['itemsubID']);
// echo "<br>";
// var_dump($_SESSION['quantity']);


?>