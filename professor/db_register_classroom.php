<?php

	include "valida_secao.inc";

	//recebendo os dados
	$id = $_SESSION["id"];
	$users = $_POST["names"];
	$class = $_POST["name_class"];

	include "conecta_mysql.inc";
	mysqli_query($con, "INSERT into subjects (subject, teacher) values ('$class','$id')") or die(mysqli_error($con));
	
	$sql = mysqli_query($con, "SELECT id FROM subjects WHERE subject = '$class'") or die(mysqli_error($con));
	$row = mysqli_fetch_array($sql);
	
	foreach ($users as $student) {
		mysqli_query($con, "INSERT into classroom (subject, student) values ('$row[0]','$student')") or die(mysqli_error($con));
		mysqli_query($con, "UPDATE user SET class = '$row[0]' WHERE id ='$student'"); 
	}
	
	//fechando conexão	
	mysqli_close($con);
	header("Location: classroom.php");

?>
