<?php
include "valida_secao.inc";

//recebendo os dados
$item_id = $_GET["item_id"];
$user_id = $_GET["user_id"];

//acesso ao bd
include "conecta_mysql.inc";


	$sql = mysqli_query($con, "SELECT name FROM item WHERE id = '$item_id'") or die(mysqli_error($con));
	$row = mysqli_fetch_row($sql);
	$name = $row[0];
	$sql2 = mysqli_query($con, "SELECT quant,tipo FROM consumiveis WHERE name = '$name'") or die(mysqli_error($con));
	$row2 = mysqli_fetch_row($sql2);

	if($row2[1] == 1){
		$sql = mysqli_query($con, "UPDATE characterr SET hp = hp + '$row2[0]' WHERE user_id = '$user_id'") or die(mysqli_error($con));
	}
	else{
		$sql = mysqli_query($con, "UPDATE characterr SET energy = energy + '$row2[0]' WHERE user_id = '$user_id'") or die(mysqli_error($con));	
	}
	mysqli_query ($con, "DELETE FROM character_item WHERE item_id = '$item_id'") or die(mysqli_error($con));
	header("Location: db_managing_character.php");
	
	//header("Location: fb_equip_success.php");


//fechando conexão	
mysqli_close($con);
?>
