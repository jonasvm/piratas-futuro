<?php
include "valida_secao.inc";
include "conecta_mysql.inc";//acesso ao bd
//recebendo os dados

// ------ recebendo os dados cadastrais do problema ---------------->
$id = $_GET["id"];

mysqli_query($con, "DELETE FROM news_feed WHERE id='$id'") or die(mysqli_error($con));

//fechando conexão	
mysqli_close($con);

header("Location: messages.php");
?>	



