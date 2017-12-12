<?php
//session_start();
include "valida_secao.inc";
include "conecta_mysql.inc";

$mission_id = $_POST["mission_id"];
$user_id = $_SESSION["id"];

//verifica o n�vel do usu�rio (antes da atualiza��o do xp), a quantidade de experiencia e energia
$sql = mysqli_query($con, 'SELECT energy, xp, lvl FROM characterr WHERE user_id = ' . $user_id . '') or die(mysqli_error($con));
$row_c = mysqli_fetch_row($sql);

//seleciona recompensas da miss�o
$sql = mysqli_query($con, 'SELECT energy, money, xp FROM mission WHERE id = ' . $mission_id . '') or die(mysqli_error($con));
$row_m = mysqli_fetch_row($sql);
	
$exp = $row_m[2];

//quantidade de linhas da tabela de n�veis
$sql = mysqli_query($con, "SELECT * FROM xp_lvl") or die(mysqli_error($con));
$total = mysqli_affected_rows($con); //adicionado $con

//encontra o maximo xp do nivel atual do usu�rio
$sql = mysqli_query($con, "SELECT xp_max FROM xp_lvl WHERE id = '$row_c[2]'") or die(mysqli_error($con));
$xp_max = mysqli_fetch_row($sql);

//maior n�vel
$sql = mysqli_query($con, "SELECT id, xp_max FROM xp_lvl WHERE id = '$total'-1 ") or die(mysqli_error($con));
$last_lvl = mysqli_fetch_array($sql);


if ($row_c[1] <  $last_lvl[1]) {
	$new_xp = ($row_c[1] + $exp);
	

	//mostra uma mensagem ao usu�rio, caso n�o tenha passado de lvl
	if( $new_xp <= $xp_max[0]){
		//atualizando a experi�ncia
		echo "$new_xp</br>";
		echo "$xp_max[0]</br>";
		mysqli_query($con, "UPDATE characterr set xp = '$new_xp' WHERE user_id = '$user_id'") or die(mysqli_error($con));
	}
	//se ganhar mais experi�ncia que o n�vel m�ximo
	else if($new_xp >= $last_lvl[1]){
		//echo "<p>Parab�ns! Voc� chegou ao n�vel m�ximo!</p>";
		//atualizando a experi�ncia e o n�vel
		mysqli_query($con, "UPDATE characterr set xp = '$last_lvl[1]', lvl = '$last_lvl[0]' WHERE user_id = '$user_id'") or die(mysqli_error($con));
	}
	
	//senao, calcula qual ser� o pr�ximo lvl
	else {
		$new_xp = ($row_c[1] + $exp);
		
		//echo "<p>Parab�ns! Voc� ganhou " . $exp . " de experencia e passou para o n�vel " . $current_lvl . ".</p>";
		//atualizando a experi�ncia e o n�vel
		mysqli_query($con, "UPDATE characterr set xp = '$new_xp', lvl = lvl + 1 WHERE user_id = '$user_id'") or die(mysqli_error($con));
	}
}

if ($row_c[0] >= $row_m[0]) {
	if ((( $row_c[0] > 0) && ( $row_c[0] > $row_m[0])) || ( $row_c[0] > $row_m[0]))
		$sql = mysqli_query($con, "UPDATE characterr set energy = energy - " . $row_m[0] . ", money = money + ".$row_m[1]. ", xp = xp + ".$row_m[2]." WHERE user_id = '$user_id'") or die(mysqli_error($con));
	else
		$sql = mysqli_query($con, "UPDATE characterr set energy = 0, money = money + " . $row_m[1] . " WHERE user_id = '$user_id'") or die(mysqli_error($con));
		
	mysqli_close($con);
    header("Location: db_fb_mission_success.php?id='$mission_id'");
	
} else {
    echo "deu fracasso";
	mysqli_close($con);
    header("Location: fb_mission_fail.php");
}
?>
