<?php
//recebendo os dados 
include "valida_secao.inc";
$item_id = $_POST["item_id"];
$user_id = $_POST["user_id"];

//acesso ao bd
include "conecta_mysql.inc";
mysqli_query($con, "INSERT into character_item (user_id,item_id,equipped) values ('$user_id','$item_id',0)") or die(mysqli_error($con));
mysqli_query($con, "UPDATE characterr SET lvl=1 WHERE user_id = '$user_id'") or die(mysqli_error($con));
//fechando conexão	
mysqli_close($con);
header("Location: history.php");
?>
