<?php
//recebendo os dados 
include "valida_secao.inc";
$skill = $_POST["skill"];
$user_id = $_POST["user_id"];

//acesso ao bd
include "conecta_mysql.inc";
$sql = mysqli_query($con, "INSERT into character_skill (user_id,skill_id,active) values ('$user_id','$skill',0)") or die(mysqli_error($con));

//se a skill escolhida foi memória eidética
if ($skill == 1) {
    $sql = mysqli_query($con, "UPDATE characterr set i_t = i_t + 2 WHERE user_id = '$user_id'") or die(mysqli_error($con));
}

//se a skill escolhida foi ambidestria
if ($skill == 2) {
    $sql = mysqli_query($con, "UPDATE characterr set d_t = d_t + 2 WHERE user_id = '$user_id'") or die(mysqli_error($con));
}

//se a skill escolhida foi boa aparência
if ($skill == 3) {
    $sql = mysqli_query($con, "UPDATE characterr set ch_t = ch_t + 2 WHERE user_id = '$user_id'") or die(mysqli_error($con));
}

//se a skill escolhida foi corpo atletico
if ($skill == 4) {
    $sql = mysqli_query($con, "UPDATE characterr set c_t = c_t + 2 WHERE user_id = '$user_id'") or die(mysqli_error($con));
}

//se a skill escolhida foi superforça
if ($skill == 5) {
    $sql = mysqli_query($con, "UPDATE characterr set s_t = s_t + 2 WHERE user_id = '$user_id'") or die(mysqli_error($con));
}

//fechando conexão	
mysqli_close($con);
header("Location: distribute_items.php");
?>
