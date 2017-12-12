<?php
include "valida_secao.inc";

//recebendo os dados
// ------ recebendo os dados cadastrais do problema ---------------->
$teacher_id = $_SESSION["id"];
$class_id = $_POST["class"];
$info = $_POST["info"];

//acesso ao bd
include "conecta_mysql.inc";

setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8", "portuguese");
date_default_timezone_set('America/Sao_Paulo');

$date = date("d-m-Y"); 
	
mysqli_query($con, "INSERT INTO news_feed (id_teacher, id_class, subject, date) values ('$teacher_id','$class_id','$info','$date')") or die(mysqli_error($con));

//fechando conexão	
mysqli_close($con);

header("Location: index.php");
?>	



