<?php

function redirectPage($exp) {
	header("Location: db_fb_level_up.php?exp=$exp");
}


include "valida_secao.inc";

$id = $_SESSION["id"];
$mission_id = $_GET["id"];
include "conecta_mysql.inc";

/*        _ Receber dados do usuário _        */
$sql = mysqli_query($con, 'SELECT p.xp,p.hp,p.max_hp,p.energy,p.max_energy FROM characterr as p, user as u WHERE p.user_id = u.id AND u.id = '.$id.'') or die(mysqli_error($con));
$row = mysqli_fetch_row($sql);

/*        _ Fazer update de energia/vida do usuário _        */
$sql = mysqli_query($con, "SELECT l_login_data FROM characterr WHERE user_id = '$id' ") or die(mysqli_error($con));
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
	mysqli_query($con, " UPDATE characterr SET l_login_data = '$date' WHERE user_id = '$id' ") or die(mysqli_error($con));
	
	//Se a vida dele for menor que a maxima
	if ( $row[1] < $row[2] ) {
		if( ($row[1] + $e_l) < $row[2] ) {
			mysqli_query($con, "UPDATE characterr SET hp = hp + " . $e_l . " WHERE user_id = '$id'") or die(mysqli_error($con));
		} else {
			mysqli_query($con, "UPDATE characterr SET hp = " . $row[2] . " WHERE user_id = '$id'") or die(mysqli_error($con));
		}
	}

	//Se a energia dele for menor que a máxima e a diferença
	if ( $row[3] < $row[4] ) {
		if( ($row[3] + $e_l) < $row[4] ){
			mysqli_query($con, "UPDATE characterr SET energy = energy + " . $e_l . " WHERE user_id = '$id'") or die(mysqli_error($con));
		} else {
			mysqli_query($con, "UPDATE characterr SET energy = " . $row[4] . " WHERE user_id = '$id'") or die(mysqli_error($con));
		}
	}

} else {
	mysqli_query($con, " UPDATE characterr SET l_login_data = '$cur_date' WHERE user_id = '$id' ") or die(mysqli_error($con));
}



//Dados da missão
$sql = mysqli_query($con, 'SELECT * FROM mission WHERE id = '.$mission_id.'') or die(mysqli_error($con));
$row = mysqli_fetch_row($sql);

// Dados do usuario
$sql2 = mysqli_query($con, 'SELECT p.xp, p.hp, p.max_hp, p.energy, p.max_energy, p.name FROM characterr as p, user as u WHERE p.user_id = u.id AND u.id = '.$id.'') or die(mysqli_error($con));
$row2 = mysqli_fetch_row($sql2);

//Insere atividade do usuário
$sql3 = mysqli_query($con, 'SELECT * FROM activity_student') or die(mysqli_error($con));
$row3 = mysqli_num_rows($sql3);

mysqli_query($con, "UPDATE activity_student SET result='Sucesso.', data=curdate(), hour=curtime() WHERE id = '$row3'");

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
                                $query = mysqli_query($con, "SELECT ext, data, upload FROM user WHERE id='$id' ") or die(mysqli_error($con));

                                while ($imagens = mysqli_fetch_array($query)){
                                    $dados['ext'] = $imagens['ext'];
                                    $dados['data'] = $imagens['data'];
				    $dados['upload'] = $imagens['upload'];
                                }
				if($dados['upload'] == 0)
					echo '<img src="data:image/' . $dados['ext'] . ';base64,' . base64_encode( $dados['data'] ) . '" width="110" height="125" /></a>';
				else
                                	echo "<img src='fotos_perfil/".$dados['data']."' width='140' height='145' />";
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
							<p class="h2" style="color:#008000;text-align:center;">Miss&atilde;o conclu&iacute;da com sucesso !</p class="h2"><br>
							<img src="images/bau-recompensa.png" width="20%" style="display:block; margin:auto;"/><br></br>
							<P style="color:blue;text-align:center;">Você recebeu <?php echo $row[6] ?> moedas pirata.</p>										
							<P style="color:blue;text-align:center;">Como prêmio pela missão você ganhou <?php echo $row[5] ?> pontos de experiência.</P>							
							<input type="hidden" id="mission_id" name="mission_id" value="<?php echo $mission_id ?>">
							<input type="hidden" id="exp" name="exp" value="<?php echo $row[5] ?>">
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
							$html .= '<h1>Deseja responder &agrave; nossa pesquisa?</h1>';
							$html .= '<p>&Eacute; r&aacute;pido e voc&ecirc; ainda ganha 1 battle point!</p><br><br>';
							$html .= '<p><input type="radio" name="op" value="1" checked/>Sim<br /></p>';
							$html .= '<p><input type="radio" name="op" value="2"/>Não<br /></p>';
							$html .= '<p><input type="submit" value="Enviar"/> <br /><br>';
							$html .= '<input name="exp" id="exp" type="hidden" value=" ' . $row[5] . ' " />';
							$html .= '</form>';
							
							echo $html;
						}
						
						else{
							//redirectPage($row[5]);
							header("Location: db_fb_level_up.php?exp=$row[5]");
							mysqli_close($con);
						}
						?>
					</div>
				</div>
		</div> 
	</body>
</html>
