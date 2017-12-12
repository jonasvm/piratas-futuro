<?php
//recebendo os dados 
include "valida_secao.inc";
$name = $_POST["name"];
$user_id = $_POST["user_id"];
$str = $_POST["str"]; //strength
$dex = $_POST["dex"]; //dexterity
$vig = $_POST["vig"]; //vigor
$int = $_POST["int"]; //intelligence
$cha = $_POST["cha"]; //charism
$hp = $vig * 2;
$energy = $vig + $int;
if ($dex <= 10) {
    $ip = 10;
}
if (($dex == 11) || ($dex == 12)) {
    $ip = 11;
}
if (($dex == 13) || ($dex == 14)) {
    $ip = 12;
}
if (($dex == 15) || ($dex == 16)) {
    $ip = 13;
}
if (($dex == 17) || ($dex == 17)) {
    $ip = 14;
}
if (($dex == 19) || ($dex == 20)) {
    $ip = 15;
}

//attack
if ($str <= 10) {
    $atk = 10;
}
if (($str == 11) || ($str == 12)) {
    $atk = 11;
}
if (($str == 13) || ($str == 14)) {
    $atk = 12;
}
if (($str == 15) || ($str == 16)) {
    $atk = 13;
}
if (($str == 17) || ($str == 17)) {
    $atk = 14;
}
if (($str == 19) || ($str == 20)) {
    $atk = 15;
}

//aramazena data e hora de login
$data_hora = date("Y-m-d H:i:s");

//acesso ao bd
include "conecta_mysql.inc";
$sql = mysqli_query($con, "INSERT into characterr (user_id, name, strength, dexterity, constitution, intelligence, charism, location, bp, hp, max_hp, energy, max_energy, xp, ip, atk, money, s_t, d_t, c_t, i_t, ch_t, atk_t, ip_t, lvl, l_login_data, slot1, slot2, slot3, slot4) values ('$user_id','$name','$str','$dex','$vig','$int','$cha',1,0,'$hp','$hp','$energy','$energy',0,'$ip','$atk',0,'$str','$dex','$vig','$int','$cha','$atk','$ip',1, '$data_hora', 0, 0, 0, 0)") or die(mysqli_error($con));

//fechando conexão	
mysqli_close($con);
header("Location: distribute_skills.php");
?>
