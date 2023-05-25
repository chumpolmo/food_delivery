<?php
session_start();
include('config.php');
if (isset($_POST['submit'])) {
$name = $_POST['name'];
$id = $_POST['id'];
$Delivery = $_POST['Delivery'];
$total = $_POST['total'];
$ftid = $_POST['ftid'];
$meSql = "INSERT INTO orders (OName, Pick_Up_Time, Status, Tip_Amount, Total_Paid, Delivery, UID ,Money_Slip ,FTID) VALUES 
('{$name}',NOW(),'0','0','{$total}','{$Delivery}','{$id}','','{$ftid}') ";
$meQeury = mysqli_query($db,$meSql);
//echo $meSql;
if ($meQeury) {
$order_id = mysqli_insert_id($db);
for ($i = 0; $i < count($_POST['qty']); $i++) {
$quantity = $_POST['qty'][$i];
$price = $_POST['price'][$i];
$miid = $_POST['miid'][$i];
$mname = $_POST['mname'][$i];
$note = $_POST['note'][$i];
$lineSql = "INSERT INTO order_items (OIName, Quantity, Notes, Price, MIID, OID) ";
$lineSql .= "VALUES (";
$lineSql .= "'{$mname}',";
$lineSql .= "'{$quantity}',";
$lineSql .= "'{$note}',";
$lineSql .= "'{$price}',";
$lineSql .= "'{$miid}',";
$lineSql .= "'{$order_id}'";
$lineSql .= ") ";
mysqli_query($db,$lineSql);
}
mysqli_close($db);
unset($_SESSION['cart']);
unset($_SESSION['qty']);
header('location:main_user.php?a=order');
}else{
mysqli_close($db);
header('location:main_user.php?a=orderfail');
}
}
//}
?>