<?php
	if(isset($_POST['cadastrar'])){
	//recebendo os dados 
	$nome = $_POST["nome"];
	$username = $_POST["username"];
	$senha = $_POST["senha"];
	$email = $_POST["email"];
	$idade = $_POST["idade"];
	$sexo = $_POST["sexo"];
	$cpf_rg = $_POST["cpf_rg"];
	//acesso ao bd
	include "conecta_mysql.inc";
							
	$sql = mysqli_query($con, "INSERT into user (username,password,name,type,email,age,gender,cpf_rg, data, ext) values ('$username','$senha','$nome',2,'$email','$idade','$sexo','$cpf_rg', '', '')") or die(mysqli_error($con));						
	//fechando conex&atilde;£o	
	mysqli_close($con);

	header("Location: index_teacher.php");
	}
?>
