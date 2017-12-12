<?php
include "valida_secao.inc";

//acesso ao bd
include "conecta_mysql.inc";

//$exp = $_POST["exp"];
$answer = $_POST["question"];
$user_id = $_SESSION["id"];
$id_question = $_SESSION["id_question"];

$sql = mysqli_query($con, "UPDATE characterr set bp = bp + 1 WHERE user_id = '$user_id'") or die(mysqli_error($con));
mysqli_query($con, "INSERT INTO ans_student ( user_id, question_id ) VALUES ( '$user_id', '$id_question[0]' ) ") or die(mysqli_error($con));
if ($answer == 1)
	$sql = mysqli_query($con, "UPDATE answers_survey set qn = qn + 1 WHERE id = '$id_question[0]'") or die(mysqli_error($con));
	
elseif ($answer == 2)
	$sql = mysqli_query($con, "UPDATE answers_survey set ra = ra + 1 WHERE id = '$id_question[0]'") or die(mysqli_error($con));
	
elseif ($answer == 3)
	$sql = mysqli_query($con, "UPDATE answers_survey set av = av + 1 WHERE id = '$id_question[0]'") or die(mysqli_error($con));
	
elseif ($answer == 4)
	$sql = mysqli_query($con, "UPDATE answers_survey set fr = fr + 1 WHERE id = '$id_question[0]'") or die(mysqli_error($con));
	
elseif ($answer == 5)
	$sql = mysqli_query($con, "UPDATE answers_survey set qs = qs + 1 WHERE id = '$id_question[0]'") or die(mysqli_error($con));

mysqli_close($con);

header("Location: index.php");
?>
