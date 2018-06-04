<?php
include "valida_secao.inc";
include "conecta_mysql.inc";//acesso ao bd
//recebendo os dados

// ------ recebendo os dados cadastrais do problema ---------------->
$id = $_POST["mensagem"];
$class_id = $_POST["class"];
$info = $_POST["info"];

setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8", "portuguese");
date_default_timezone_set('America/Sao_Paulo');

$date = date("d-m-Y"); 
	
mysqli_query($con, "UPDATE news_feed SET subject='$info', date='$date', id_class='$class_id' WHERE id='$id'") or die(mysqli_error($con));

//fechando conexão	
mysqli_close($con);

header("Location: messages.php");
?>	



