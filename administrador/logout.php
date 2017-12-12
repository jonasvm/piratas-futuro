<?php
include "valida_secao.inc";

$id = $_SESSION["id"];
include "conecta_mysql.inc";

$sql = mysqli_query($con, "SELECT name FROM characterr WHERE user_id = '$id'") or die(mysqli_error($con));
$row = mysqli_fetch_row($sql);

session_start();
$_SESSION = array();
session_destroy();
header("Location: ../index.php");
?>
