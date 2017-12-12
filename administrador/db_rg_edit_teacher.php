<?php
include "valida_secao.inc";

//recebendo os dados
// ------ recebendo os dados cadastrais do problema ---------------->
$teacher_id = $_POST["teacher_id"];

$name = $_POST["nome"];
$pass = $_POST["senha"];
$cpf = $_POST["cpf_rg"];
$age = $_POST["idade"];
$username = $_POST["username"];
$email = $_POST["email"];
$gender = $_POST["sexo"];

//acesso ao bd
include "conecta_mysql.inc";

$sql = mysqli_query($con, "UPDATE user SET username = '$username', password = '$pass', name = '$name', email = '$email', age = '$age', gender = '$gender', cpf_rg = '$cpf' WHERE id = '$teacher_id' ") or die(mysqli_error($con));

header("Location: db_detail_teacher.php?teacher_id=" .$teacher_id);

//fechando conex&atilde;o	
mysqli_close($con);
?>
