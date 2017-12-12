<?php
error_reporting (E_ALL & ~ E_NOTICE & ~ E_DEPRECATED);
//configurações do banco de dados
$servidor="localhost";
$usuario_bd="root";
$senha_bd="";
$banco="pirates_db";
$con=mysqli_connect($servidor,$usuario_bd,$senha_bd);
mysqli_select_db ($con, $banco);
?>
