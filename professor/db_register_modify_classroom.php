<?php

	include "valida_secao.inc";
	include "conecta_mysql.inc";
	
	//recebendo os dados
	$id = $_SESSION["id"];
	$id_subject = $_POST["id_subject"];
	$users = $_POST["names"];
	$class = $_POST["name_class"];
	
	foreach ($users as $student) {
		mysqli_query($con, "INSERT into classroom (subject, student) values ('$id_subject','$student')") or die(mysqli_error($con));
	}
	
	//Altera nome da classe na tabela 'subjects'
	//Não é necessário alterá-la na tabela 'classroom', porque o id permanecerá o mesmo
	mysqli_query($con, "UPDATE subjects SET subject='$class' WHERE id='$id_subject'") or die(mysqli_error($con));
	
	//fechando conexão	
	mysqli_close($con);
	header("Location: classroom.php");

?>
