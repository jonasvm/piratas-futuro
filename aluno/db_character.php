<?php
include "valida_secao.inc";
include "conecta_mysql.inc";

$user_id = $_SESSION["id"];
$sql = mysqli_query($con, "SELECT user_id FROM characterr WHERE user_id = '$user_id'");

if (mysqli_num_rows($sql) == 1) {
	mysqli_close($con);
	header("Location: db_managing_character.php");
} else {
	mysqli_close($con);
	header("Location: start_ch.php");
}
?>
