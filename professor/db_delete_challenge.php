<?php
include "valida_secao.inc";
include "conecta_mysql.inc";

$challenge_id = $_GET["id"];

mysqli_query($con, "DELETE FROM challenge WHERE id = '$challenge_id'") or die(mysqli_error($con));

//fechando conexão	
mysqli_close($con);

header("Location: challenges.php");
?>
