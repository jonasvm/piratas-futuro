<?php
include "valida_secao.inc";
include "conecta_mysql.inc";

//Aluno a ser deletada
$student = $_GET["id"];
$id_subject = $_GET["id_subject"];

$sql = mysqli_query($con, "SELECT id FROM user WHERE name='$student'") or die(mysqli_error($con));
$row = mysqli_fetch_array($sql);

echo $row[0];
echo $id_subject;

mysqli_query($con, "DELETE FROM classroom WHERE (student='$row[0]') AND (subject = '$id_subject')") or die(mysqli_error($con));

//fechando conexão	
mysqli_close($con);

header("Location: classroom.php");
?>
