<?php
//recebendo os dados 
include "valida_secao.inc";
$item_id = $_GET["item_id"];
$user_id = $_GET["user_id"];
$equip_id = $_GET['equip'];

//acesso ao bd
include "conecta_mysql.inc";

$sqlSlots = mysqli_query($con, "SELECT slot1,slot2,slot3,slot4 FROM characterr WHERE user_id = '$user_id'") or die(mysqli_error($con));
$rowSlots = mysqli_fetch_row($sqlSlots);

mysqli_query($con, "UPDATE character_item set equipped = 0 WHERE user_id = " . $user_id . " AND item_id = " . $item_id . "") or die(mysqli_error($con));
	
if($equip_id == 2)
	mysqli_query($con, "UPDATE characterr set slot3 = 0 WHERE user_id = " . $user_id . "") or die(mysqli_error($con));
elseif($equip_id == 3)
	mysqli_query($con, "UPDATE characterr set slot4 = 0 WHERE user_id = " . $user_id . "") or die(mysqli_error($con));
elseif($equip_id == 1) {
	if($rowSlots[0] == 1)
		mysqli_query($con, "UPDATE characterr set slot1 = 0 WHERE user_id = " . $user_id . "") or die(mysqli_error($con));
	elseif($rowSlots[1] == 1)
		mysqli_query($con, "UPDATE characterr set slot2 = 0 WHERE user_id = " . $user_id . "") or die(mysqli_error($con));
	else "Erro";
}
else "Erro";

$sql = mysqli_query($con, "SELECT value,field_sheet FROM benefit WHERE id = '$item_id'") or die(mysqli_error($con));
$row = mysqli_fetch_row($sql);

$sql1 = mysqli_query($con, "SELECT energy FROM characterr WHERE user_id = '$user_id' ") or die(mysqli_error($con));
$row1 = mysqli_fetch_row($sql1);

//pv atual
if ($row[1] == 1) {
    $sql = mysqli_query($con, "UPDATE characterr set hp = hp - '$row[0]' WHERE user_id = '$user_id'") or die(mysqli_error($con));
    header("Location: fb_unequip_success.php");
}

//pv max
if ($row[1] == 2) {
    $sql = mysqli_query($con, "UPDATE characterr set max_hp = max_hp - '$row[0]' WHERE user_id = '$user_id'") or die(mysqli_error($con));
    header("Location: fb_unequip_success.php");
}

//energia atual
if ($row[1] == 3) {
	// Se o que ele tem é maior que zero e maior que o que ele vai perder
	if ((( $row1[0] > 0) && ( $row1[0] > $row[0])) || ( $row1[0] > $row[0]))
		$sql = mysqli_query($con, "UPDATE characterr set energy = energy - '$row[0]' WHERE user_id = '$user_id'") or die(mysqli_error($con));
	else
		$sql = mysqli_query($con, "UPDATE characterr set energy = 0 WHERE user_id = '$user_id'") or die(mysqli_error($con));
		
    header("Location: fb_unequip_success.php");
}

//energia  max
if ($row[1] == 4) {
	if ((( $row1[0] > 0) && ( $row1[0] > $row[0])) || ( $row1[0] > $row[0]))
		$sql = mysqli_query($con, "UPDATE characterr set max_energy = max_energy - '$row[0]' WHERE user_id = '$user_id'") or die(mysqli_error($con));
	else
		$sql = mysqli_query($con, "UPDATE characterr set max_energy = 0 WHERE user_id = '$user_id'") or die(mysqli_error($con));
		
    header("Location: fb_unequip_success.php");
}

//atk base
if ($row[1] == 5) {
    $sql = mysqli_query($con, "UPDATE characterr set atk = atk - '$row[0]' WHERE user_id = '$user_id'") or die(mysqli_error($con));
    header("Location: fb_unequip_success.php");
}

//atk  temp
if ($row[1] == 6) {
    $sql = mysqli_query($con, "UPDATE characterr set atk_t = atk_t - '$row[0]' WHERE user_id = '$user_id'") or die(mysqli_error($con));
    header("Location: fb_unequip_success.php");
}

//ip base
if ($row[1] == 7) {
    $sql = mysqli_query($con, "UPDATE characterr set ip = ip - '$row[0]' WHERE user_id = '$user_id'") or die(mysqli_error($con));
    header("Location: fb_unequip_success.php");
}

//ip  temp
if ($row[1] == 8) {
    $sql = mysqli_query($con, "UPDATE characterr set ip_t = ip_t - '$row[0]' WHERE user_id = '$user_id'") or die(mysqli_error($con));
    header("Location: fb_unequip_success.php");
}

//força base
if ($row[1] == 9) {
    $sql = mysqli_query($con, "UPDATE characterr set strength = strength - '$row[0]' WHERE user_id = '$user_id'") or die(mysqli_error($con));
    header("Location: fb_unequip_success.php");
}

//força  temp
if ($row[1] == 10) {
    $sql = mysqli_query($con, "UPDATE characterr set s_t = s_t - '$row[0]' WHERE user_id = '$user_id'") or die(mysqli_error($con));
    header("Location: fb_unequip_success.php");
}

//destreza base
if ($row[1] == 11) {
    $sql = mysqli_query($con, "UPDATE characterr set dexterity = dexterity - '$row[0]' WHERE user_id = '$user_id'") or die(mysqli_error($con));
    header("Location: fb_unequip_success.php");
}

//destreza  temp
if ($row[1] == 12) {
    $sql = mysqli_query($con, "UPDATE characterr set d_t = d_t - '$row[0]' WHERE user_id = '$user_id'") or die(mysqli_error($con));
    header("Location: fb_unequip_success.php");
}

//constituição base
if ($row[1] == 13) {
    $sql = mysqli_query($con, "UPDATE characterr set constitution = constitution - '$row[0]' WHERE user_id = '$user_id'") or die(mysqli_error($con));
    header("Location: fb_unequip_success.php");
}

//constituição temp
if ($row[1] == 14) {
    $sql = mysqli_query($con, "UPDATE characterr set c_t = c_t - '$row[0]' WHERE user_id = '$user_id'") or die(mysqli_error($con));
    header("Location: fb_unequip_success.php");
}

//inteligencia base
if ($row[1] == 15) {
    $sql = mysqli_query($con, "UPDATE characterr set intelligence = intelligence - '$row[0]' WHERE user_id = '$user_id'") or die(mysqli_error($con));
    header("Location: fb_unequip_success.php");
}

//inteligencia temp
if ($row[1] == 16) {
    $sql = mysqli_query($con, "UPDATE characterr set i_t = i_t - '$row[0]' WHERE user_id = '$user_id'") or die(mysqli_error($con));
    header("Location: fb_unequip_success.php");
}

//carisma base
if ($row[1] == 17) {
    $sql = mysqli_query($con, "UPDATE characterr set charism = charism - '$row[0]' WHERE user_id = '$user_id'") or die(mysqli_error($con));
    header("Location: fb_unequip_success.php");
}

//carisma temp
if ($row[1] == 18) {
    $sql = mysqli_query($con, "UPDATE characterr set ch_t = ch_t - '$row[0]' WHERE user_id = '$user_id'") or die(mysqli_error($con));
    header("Location: fb_unequip_success.php");
}
header("Location: fb_unequip_success.php");
//fechando conexão	
mysqli_close($con);
?>
