<?php
include "valida_secao.inc";

//recebendo os dados 
$item_id = $_POST["item_id"];
$user_id = $_POST["user_id"];

//acesso ao bd
include "conecta_mysql.inc";

$sql = mysqli_query($con, "SELECT buy_value,type FROM item WHERE id = '$item_id'") or die(mysqli_error($con));
$item_value = mysqli_fetch_row($sql);


$sql = mysqli_query($con, "SELECT money, bp FROM characterr WHERE user_id = '$user_id'") or die(mysqli_error($con));
$money = mysqli_fetch_row($sql);

	

$sql = mysqli_query($con, "SELECT item_id FROM character_item WHERE user_id = '$user_id'") or die(mysqli_error($con));

while ($user_item = mysqli_fetch_assoc($sql)) {
	if ($user_item['item_id'] == $item_id)
		$find = true;
}

if( $find == true && $item_value[1] != 4)
	header("Location: fb_buy_fail_item.php");
else if($item_value[1] != 4){	
	if($money[0] >= $item_value[0]){
		$sql = mysqli_query($con, "INSERT into character_item (user_id,item_id,equipped) values ('$user_id','$item_id',0)") or die(mysqli_error($con));
		
		$sql = mysqli_query($con, "UPDATE characterr set money = money - $item_value[0] WHERE user_id = '$user_id'") or die(mysqli_error($con));
		
		header("Location: fb_buy_success.php");
	}
	else{
		header("Location: fb_buy_fail.php");
	}
}else{
	if($money[1] >= $item_value[0]){
		$sql = mysqli_query($con, "INSERT into character_item (user_id,item_id,equipped) values ('$user_id','$item_id',0)") or die(mysqli_error($con));
		
		$sql = mysqli_query($con, "UPDATE characterr set bp = bp - $item_value[0] WHERE user_id = '$user_id'") or die(mysqli_error($con));
		
		header("Location: fb_buy_success.php");
	}
	else{
		header("Location: fb_buy_fail.php");
	}
}

//fechando conexão	
mysqli_close($con);
?>
