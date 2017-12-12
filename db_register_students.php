<?php
//recebendo os dados 
$nome = $_POST["nome"];
$username = $_POST["username"];
$senha = $_POST["senha"];
$email = $_POST["email"];
$idade = $_POST["idade"];
$sexo = $_POST["sexo"];
$cpf_rg = $_POST["cpf_rg"];

//imagem do avatar padrão
$file = "aluno/images/avatar.png";
$fp = fopen($file, 'r');
$data = fread($fp, filesize($file));
$data = addslashes($data);
$imgType = "image/png";
fclose($fp);

//acesso ao bd
include "conecta_mysql.inc";

mysqli_query($con, "INSERT into user (username,password,name,type,email,age,gender,cpf_rg,ext,data) VALUES ('$username','$senha','$nome',3,'$email','$idade','$sexo','$cpf_rg','$imgType','$data')") or die(mysqli_error($con));
echo $lastID = mysqli_insert_id($con);

//fechando conexão	
mysqli_close($con);
header("Location: fb_register_success.php");
?>
