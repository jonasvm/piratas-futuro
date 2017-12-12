<?php
include "valida_secao.inc";
include "conecta_mysql.inc";

$mission_id = $_GET["id"];

mysqli_query($con, "DELETE FROM mission WHERE id = '$mission_id'") or die(mysqli_error($con));

//fechando conexão	
mysqli_close($con);

header("Location: missions.php");
?>
