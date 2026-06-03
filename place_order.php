<?php
include "config/connect.php";
session_start();

$cart_ids = $_POST['cart_ids'];
$contact = $_POST['contact'];
$address = $_POST['address'];
$shipping = $_POST['shipping'];
$subtotal = $_POST['subtotal'];

$total = $subtotal + $shipping;

$clientid = $_SESSION['user_id']; 

$orderdate = date("Y-m-d H:i:s");

mysqli_query($con, "
    INSERT INTO transactions (clientid, subtotal, fee, total, status, orderdate)
    VALUES ('$clientid', '$subtotal', '$shipping', '$total', 'Pending', '$orderdate')
");

for ($i = 0; $i < count($cart_ids); $i++) {

    $id = $cart_ids[$i];

    $query = mysqli_query($con, "
        SELECT * FROM cart WHERE id = '$id'
    ");

    $row = mysqli_fetch_array($query);

    $itemid = $row['itemid'];
    $qty = $row['quantity'];
    $price = $row['price'];



    mysqli_query($con, "
        UPDATE items
        SET quantity = quantity - $qty
        WHERE id = '$itemid'
    ");

    mysqli_query($con, "
        DELETE FROM cart WHERE id = '$id'
    ");
}

echo "Order placed successfully (Pending)";
?>