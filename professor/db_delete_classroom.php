<?php
include "valida_secao.inc";
include "conecta_mysql.inc";

//Sala de aula a ser deletada
$id_subject = $_GET["id"];

mysqli_query($con, "DELETE FROM subjects WHERE id = '$id_subject'") or die(mysqli_error($con));
mysqli_query($con, "DELETE FROM classroom WHERE subject = '$id_subject'") or die(mysqli_error($con));

//fechando conexão	
mysqli_close($con);

header("Location: classroom.php");
?>
