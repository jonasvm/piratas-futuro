<?php
include "valida_secao.inc";

$user_id = $_SESSION["id"];
$id = $_GET["id"];

include "conecta_mysql.inc";

/*        _ Receber dados do usuário _        */
$sql = mysqli_query($con, "SELECT p.xp,p.hp,p.max_hp,p.energy,p.max_energy FROM characterr as p, user as u WHERE p.user_id = u.id AND u.id = '$user_id'") or die(mysqli_error($con));
$row = mysqli_fetch_row($sql);

/*        _ Fazer update de energia/vida do usuário _        */
$sql = mysqli_query($con, "SELECT l_login_data FROM characterr WHERE user_id = '$user_id' ") or die(mysqli_error($con));
$lastLogin = mysqli_fetch_row($sql);

date_default_timezone_set("Brazil/East");

$cur_date = date('d-m-Y H:i:s') ; //data atual
$last_l = strtotime($lastLogin[0]); //data no banco de dados em formato 'numérico'
$c_hour = strtotime( $cur_date ); //data atual no formato 'numérico'

$e_l = floor((($c_hour - $last_l)/60)/10); //quantidade de vida/energia a aumentar

$total = (($c_hour - $last_l)/60); //diferença entre a data atual e a data do banco de dados (min + seg)
$min = ($total - (10*$e_l)); //apenas os minutos decorridos desde a ultima atualização (formato 'numérico')
$dif = $min*60; //diferença em segundos
$date = $c_hour - $dif; //horário com o resto
$date = date("d-m-Y H:i:s",$date); //data com o resto da ultima atualização
//Se vida ou energia ainda nao estao no máximo, a hora no BD é atualizada contando o 'resto' da hora anterior
if( ( $row[1] < $row[2] ) || ( $row[3] < $row[4] ) ) {
	mysqli_query($con, " UPDATE characterr SET l_login_data = '$date' WHERE user_id = '$user_id' ") or die(mysqli_error($con));
	
	//Se a vida dele for menor que a maxima
	if ( $row[1] < $row[2] ) {
		if( ($row[1] + $e_l) < $row[2] ) {
			mysqli_query($con, "UPDATE characterr SET hp = hp + " . $e_l . " WHERE user_id = '$user_id'") or die(mysqli_error($con));
		} else {
			mysqli_query($con, "UPDATE characterr SET hp = " . $row[2] . " WHERE user_id = '$user_id'") or die(mysqli_error($con));
		}
	}

	//Se a energia dele for menor que a máxima e a diferença
	if ( $row[3] < $row[4] ) {
		if( ($row[3] + $e_l) < $row[4] ){
			mysqli_query($con, "UPDATE characterr SET energy = energy + " . $e_l . " WHERE user_id = '$user_id'") or die(mysqli_error($con));
		} else {
			mysqli_query($con, "UPDATE characterr SET energy = " . $row[4] . " WHERE user_id = '$user_id'") or die(mysqli_error($con));
		}
	}

} else {
	mysqli_query($con, " UPDATE characterr SET l_login_data = '$cur_date' WHERE user_id = '$user_id' ") or die(mysqli_error($con));
}



//Dados do desafio
$sql = mysqli_query($con, "SELECT * FROM challenge WHERE id = '$id'") or die(mysqli_error($con));
$row = mysqli_fetch_row($sql);

// Dados do usuário
$sql2 = mysqli_query($con, 'SELECT p.xp, p.hp, p.max_hp, p.energy, p.max_energy, p.name FROM characterr as p, user as u WHERE p.user_id = u.id AND u.id = '.$user_id.'') or die(mysqli_error($con));
$row2 = mysqli_fetch_row($sql2);

//Insere atividade do usuário
$sql3 = mysqli_query($con, 'SELECT * FROM activity_student') or die(mysqli_error($con));
$row3 = mysqli_num_rows($sql3);

mysqli_query($con, "UPDATE activity_student SET sub_activity='$row[1]', result='Sucesso.', data=curdate(), hour=curtime() WHERE id = '$row3'");


//atualiza XP do usuário

//verifica o nível do usuário (antes da atualização do xp)
$sql = mysqli_query($con, "SELECT lvl, xp FROM characterr WHERE user_id = '$user_id'") or die(mysqli_error($con));
$current_lvl = mysqli_fetch_row($sql);
	
//quantidade de linhas da tabela de níveis
$sql = mysqli_query($con, "SELECT * FROM xp_lvl") or die(mysqli_error($con));
$total = mysqli_affected_rows($con);

//encontra o maximo xp do nivel atual do usuário
$sql = mysqli_query($con, "SELECT xp_max FROM xp_lvl WHERE id = '$current_lvl[0]'") or die(mysqli_error($con));
$xp_max = mysqli_fetch_row($sql);

//maior nível
$sql = mysqli_query($con, "SELECT id, xp_max FROM xp_lvl WHERE id = '$total'-1 ") or die(mysqli_error($con));
$last_lvl = mysqli_fetch_array($sql);

$html = "";

if ( $current_lvl[1] >=  $last_lvl[1]) {
	echo "<p>Você não ganhou experiência pois já está no nível máximo!</p>";
	echo "<p>Ainda assim, as missões e desafios continuam disponíveis.</p>";
	//mysqli_close($con);
}
else {
	$new_xp = ($current_lvl[1] + $exp);
	//mostra uma mensagem ao usuário, caso não tenha passado de lvl
	if( $new_xp <= $xp_max[0]){
		//atualizando a experiência
		mysqli_query($con, "UPDATE characterr set xp = '$new_xp' WHERE user_id = '$user_id'") or die(mysqli_error($con));
	}
	//se ganhar mais experiência que o nível máximo
	elseif($new_xp >= $last_lvl[1]){
		//atualizando a experiência e o nível
		mysqli_query($con, "UPDATE characterr set xp = '$last_lvl[1]', lvl = '$last_lvl[0]' WHERE user_id = '$user_id'") or die(mysqli_error($con));
	}
	
	//senao, calcula qual será o próximo lvl
	else {
		$new_xp = ($current_lvl[1] + $exp) . "<br>";
		
		//maior nível
		$sql = mysqli_query($con, "SELECT id, xp_max FROM xp_lvl WHERE xp_max < '$new_xp' ") or die(mysqli_error($con));
		$new_lvl = mysqli_affected_rows($con);
		
		$current_lvl = $new_lvl;
		$html = "<p>Parabéns! Você passou para o nível " . $current_lvl . ".</p>";
		//atualizando a experiência e o nível
		mysqli_query($con, "UPDATE characterr set xp = '$new_xp', lvl = '$current_lvl' WHERE user_id = '$user_id'") or die(mysqli_error($con));
	}
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
    <head>
        <title>Piratas do Futuro</title>
        <meta name="description" content="website description" />
        <meta name="keywords" content="website keywords, website keywords" />
        <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
		<link href="http://fonts.googleapis.com/css?family=Muli" rel="stylesheet" type="text/css" />
		<link href="http://fonts.googleapis.com/css?family=Englebert" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="style/style1024.css" media="only screen and (max-width:1245px)"/>
        <link rel="stylesheet" type="text/css" href="style/style1280.css" media="only screen and (min-width: 1246px) and (max-width:1315px)"/>
		<link rel="stylesheet" type="text/css" href="style/style1920.css" media="only screen and (min-width: 1446px) and (max-width:1920px)"/>
        <link rel="stylesheet" type="text/css" href="style/style.css" media="only screen and (min-width:1116px) and (max-width:1445px)"/>
		
    <link rel="shortcut icon" href="images/favicon.ico"/> 



    </head>

    <body>
		<div id="main">
			<div id="header">
				<div id="top_menu">
					<ul>
						<li><a href="help.php">Ajuda</a></li>
						<li><a href="about.php">Créditos</a></li>
						<li><a href="logout.php">Sair</a></li>
					</ul>
				</div>
				<div id="user_content">
                    <div id="user_picture_bg">
                    	<div class="user_picture">
				<?php
                                $query = mysqli_query($con, "SELECT ext, data, upload FROM user WHERE id='$user_id' ") or die(mysqli_error($con));

                                while ($imagens = mysqli_fetch_array($query)){
                                    $dados['ext'] = $imagens['ext'];
                                    $dados['data'] = $imagens['data'];
				    $dados['upload'] = $imagens['upload'];
                                }
                                if($dados['upload'] != 0)
                                	echo "<img src='fotos_perfil/".$dados['data']."' width='140' height='145' />";
				else
					echo '<img src="data:image/' . $dados['ext'] . ';base64,' . base64_encode( $dados['data'] ) . '" width="110" height="125" /></a>';
				?>
                         </div>
					</div>
					<div id="user_data">
						<div id="user_data_images">
								<img src="images/life.png" width="80%" height="30%" />
								<img src="images/energy.png" width="80%" height="30%" />
								<img src="images/exp.png" width="85%" height="30%" />
						</div>
                        <div id="user_life">
        					<?php echo $row2[1] ?>/<?php echo $row2[2] ?>
                        </div>
                        <div id="user_energy">
        					<?php echo $row2[3] ?>/<?php echo $row2[4] ?>
                        </div>
                        <div id="user_xp">
    						<?php echo $row2[0] ?>
                        </div>
                    </div>
				</div>
				<div id="menubar">
					<ul>
						<li><a href="index.php">Início</a></li>
						<li><a href="db_character.php">Status</a></li>
						<li><a href="map.php">Mapa</a></li>
						<li><a href="db_arena.php">Arena</a></li>
						<li><a href="db_challenges.php">Desafios</a></li>
						<li><a href="db_missions.php">Missões</a></li>
						<li><a href="db_inventory.php">Inventário</a></li>
						<li><a href="db_store.php">Loja</a></li>
						<li><a href="db_ranking.php">Ranking</a></li>
					</ul>
				</div>
			</div>
			<div id="content">
				<div id="text">
						<form action="" method="post" enctype="multipart/form-data" name="form" onSubmit="">		
							<br><p class="h2" style="color:#008000;text-align:center;">Parabéns, sua reposta está correta!</p class="h2"></br>
							<img src="images/bau-recompensa.png" width="20%" style="display:block; margin:auto;"/><br></br>
							<p style="color:blue;text-align:center;">Como prêmio pela solução você ganhou <?php echo $row[7] ?> pontos de experiência.</p>
							<p style="color:blue;text-align:center;">Além dos pontos de experiência, você recebeu <?php echo $row[8] ?> battle points. </p><br>
							<input type="hidden" id="problema" name="problema" value="<?php echo $id ?>">							
						</form>
						<br>
						<?php
						
							/*               _SURVAY_               */
							//Quantidade de questões respondidas do aluno
							$sql3 = mysqli_query($con, "SELECT * FROM ans_student WHERE user_id = '$id'") or die(mysqli_error($con));
							$rows_ans = mysqli_num_rows($sql3);
							//Quantidade de perguntas no banco de dados
							$sql4 = mysqli_query($con, "SELECT * FROM survey") or die(mysqli_error($con));
							$rows_survey = mysqli_num_rows($sql4);
							if ($rows_ans < $rows_survey){
						
								$html = '';
								$html .= '<center><form id="formSurvey" method="post" action="db_survey.php" class="survey">';
								$html .= '<h1 style="text-align:center;">Deseja responder &agrave; nossa pesquisa?</h1>';
								$html .= '<p>&Eacute; r&aacute;pido e voc&ecirc; ainda ganha 1 battle point!</p><br><br>';
								$html .= '<p><input type="radio" name="op" value="1" checked/>Sim<br /></p>';
								$html .= '<p><input type="radio" name="op" value="2"/>Não<br /></p>';
								$html .= '<p><input type="submit" value="Enviar"/> <br /><br>';
								$html .= '<input name="exp" id="exp" type="hidden" value=" ' . $row[7] . ' " />';
								$html .= '</form>';
							
								echo $html;
							}
						
							else{
								header("Location: db_fb_level_up.php?exp=$row[7]");
								mysqli_close($con);
							}
						?>
					</div>
				</div>
		</div> 
	</body>
</html>
