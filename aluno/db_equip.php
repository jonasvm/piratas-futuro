<?php
include "valida_secao.inc";

//recebendo os dados
$item_id = $_GET["item_id"];
$user_id = $_GET["user_id"];
$equip_id = $_GET['equip'];
$equiped = 0;

//acesso ao bd
include "conecta_mysql.inc";

$sql1 = mysqli_query($con, "SELECT slot1,slot2,slot3,slot4 FROM characterr WHERE user_id = '$user_id'") or die(mysqli_error($con));
$row1 = mysqli_fetch_row($sql1);

if($equip_id == 1)
{
	if(($row1[0] == true) && ($row1[1] == true))
		$equiped = 1;
}
		
else if($equip_id == 2)
{
	if($row1[2] == true)
		$equiped = 1;
}
		
else if($equip_id == 3)
{
	if($row1[3] == true)
		$equiped = 1;
}
		
//Se houver o maximo de item equipado para aquela parte		
if($equiped == 1)
{
	header("Location: fb_cant_equip.php");
}
else
{
	
	mysqli_query($con, "UPDATE character_item SET equipped = 1 WHERE user_id = " . $user_id . " AND item_id = " . $item_id . "") or die(mysqli_error($con));
	
	if($equip_id == 2)
		mysqli_query($con, "UPDATE characterr SET slot3 = 1 WHERE user_id = " . $user_id . "") or die(mysqli_error($con));
	elseif($equip_id == 3)
		mysqli_query($con, "UPDATE characterr SET slot4 = 1 WHERE user_id = " . $user_id . "") or die(mysqli_error($con));
	elseif($equip_id == 1) {
		if($row1[0] == 0)
			mysqli_query($con, "UPDATE characterr SET slot1 = 1 WHERE user_id = " . $user_id . "") or die(mysqli_error($con));
		elseif($row1[1] == 0)
			mysqli_query($con, "UPDATE characterr SET slot2 = 1 WHERE user_id = " . $user_id . "") or die(mysqli_error($con));
		else "Erro";
	}
	else "Erro";

	$sql = mysqli_query($con, "SELECT value, field_sheet FROM benefit WHERE id = '$item_id'") or die(mysqli_error($con));
	$row = mysqli_fetch_row($sql);


	echo $row[1];
	//pv atual
	if ($row[1] == 1) {
		$sql = mysqli_query($con, "UPDATE characterr SET hp = hp + '$row[0]' WHERE user_id = '$user_id'") or die(mysqli_error($con));
		header("Location: fb_equip_success.php");
	}

	//pv max
	if ($row[1] == 2) {
		$sql = mysqli_query($con, "UPDATE characterr SET max_hp = max_hp + '$row[0]' WHERE user_id = '$user_id'") or die(mysqli_error($con));
		header("Location: fb_equip_success.php");
	}

	//energia atual
	if ($row[1] == 3) {
		$sql = mysqli_query($con, "UPDATE characterr SET energy = energy + '$row[0]' WHERE user_id = '$user_id'") or die(mysqli_error($con));
	    header("Location: fb_equip_success.php");
	}

	//energia  max
	if ($row[1] == 4) {
		$sql = mysqli_query($con, "UPDATE characterr SET max_energy = max_energy + '$row[0]' WHERE user_id = '$user_id'") or die(mysqli_error($con));
		header("Location: fb_equip_success.php");
	}

	//atk base
	if ($row[1] == 5) {
		$sql = mysqli_query($con, "UPDATE characterr SET atk = atk + '$row[0]' WHERE user_id = '$user_id'") or die(mysqli_error($con));
		header("Location: fb_equip_success.php");
	}

	//atk  temp
	if ($row[1] == 6) {
		$sql = mysqli_query($con, "UPDATE characterr SET atk_t = atk_t + '$row[0]' WHERE user_id = '$user_id'") or die(mysqli_error($con));
	    header("Location: fb_equip_success.php");
	}

	//ip base
	if ($row[1] == 7) {
		$sql = mysqli_query($con, "UPDATE characterr SET ip = ip + '$row[0]' WHERE user_id = '$user_id'") or die(mysqli_error($con));
		header("Location: fb_equip_success.php");
	}

	//ip  temp
	if ($row[1] == 8) {
		$sql = mysqli_query($con, "UPDATE characterr SET ip_t = ip_t + '$row[0]' WHERE user_id = '$user_id'") or die(mysqli_error($con));
	    header("Location: fb_equip_success.php");
	}

	//força base
	if ($row[1] == 9) {
		$sql = mysqli_query($con, "UPDATE characterr SET strength = strength + '$row[0]' WHERE user_id = '$user_id'") or die(mysqli_error($con));
		header("Location: fb_equip_success.php");
	}

	//força  temp
	if ($row[1] == 10) {
		$sql = mysqli_query($con, "UPDATE characterr SET s_t = s_t + '$row[0]' WHERE user_id = '$user_id'") or die(mysqli_error($con));
		header("Location: fb_equip_success.php");
	}

	//destreza base
	if ($row[1] == 11) {
		$sql = mysqli_query($con, "UPDATE characterr SET dexterity = dexterity + '$row[0]' WHERE user_id = '$user_id'") or die(mysqli_error($con));
		header("Location: fb_equip_success.php");
	}

	//destreza  temp
	if ($row[1] == 12) {
		$sql = mysqli_query($con, "UPDATE characterr SET d_t = d_t + '$row[0]' WHERE user_id = '$user_id'") or die(mysqli_error($con));
		header("Location: fb_equip_success.php");
	}

	//constituição base
	if ($row[1] == 13) {
		$sql = mysqli_query($con, "UPDATE characterr SET constitution = constitution + '$row[0]' WHERE user_id = '$user_id'") or die(mysqli_error($con));
		header("Location: fb_equip_success.php");
	}

	//constituição temp
	if ($row[1] == 14) {
		$sql = mysqli_query($con, "UPDATE characterr SET c_t = c_t + '$row[0]' WHERE user_id = '$user_id'") or die(mysqli_error($con));
		header("Location: fb_equip_success.php");
	}

	//inteligencia base
	if ($row[1] == 15) {
		$sql = mysqli_query($con, "UPDATE characterr SET intelligence = intelligence + '$row[0]' WHERE user_id = '$user_id'") or die(mysqli_error($con));
		header("Location: fb_equip_success.php");
	}

	//inteligencia temp
	if ($row[1] == 16) {
		$sql = mysqli_query($con, "UPDATE characterr SET i_t = i_t + '$row[0]' WHERE user_id = '$user_id'") or die(mysqli_error($con));
		header("Location: fb_equip_success.php");
	}

	//carisma base
	if ($row[1] == 17) {
		$sql = mysqli_query($con, "UPDATE characterr SET charism = charism + '$row[0]' WHERE user_id = '$user_id'") or die(mysqli_error($con));
		header("Location: fb_equip_success.php");
	}

	//carisma temp
	if ($row[1] == 18) {
		$sql = mysqli_query($con, "UPDATE characterr SET ch_t = ch_t + '$row[0]' WHERE user_id = '$user_id'") or die(mysqli_error($con));
		header("Location: fb_equip_success.php");
	}
	//header("Location: fb_equip_success.php");
}

//fechando conexão	
mysqli_close($con);
?>
