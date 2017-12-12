<?php
include "valida_secao.inc";

//recebendo os dados 
$item = $_POST["item_id"];
$user_id = $_POST["user_id"];

//acesso ao bd
include "conecta_mysql.inc";

$sql = mysqli_query($con, "SELECT sale_value FROM item WHERE id = '$item'") or die(mysqli_error($con));
$item_value = mysqli_fetch_row($sql);
$sql = mysqli_query($con, "DELETE FROM character_item WHERE item_id = '$item' AND user_id = '$user_id'") or die(mysqli_error($con));
$sql = mysqli_query($con, "UPDATE characterr set money = money + $item_value[0] WHERE user_id = '$user_id'") or die(mysqli_error($con));
header("Location: fb_sell_success.php");

//fechando conexão	
mysqli_close($con);
?>
