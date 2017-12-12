<?php
include "valida_secao.inc";
include "conecta_mysql.inc";

$mission_id = $_GET["id"];
$user_id = $_SESSION["id"];

/*        _ Receber dados do usuário _        */
$sql = mysqli_query($con, 'SELECT p.xp,p.hp,p.max_hp,p.energy,p.max_energy FROM characterr as p, user as u WHERE p.user_id = u.id AND u.id = '.$user_id.'') or die(mysqli_error($con));
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

//Dados da missão
$sql = mysqli_query($con, 'SELECT * FROM mission WHERE id = ' . $mission_id . '') or die(mysqli_error($con));
$row = mysqli_fetch_row($sql);

//Dados do usuário
$sql2 = mysqli_query($con, 'SELECT p.xp, p.hp, p.max_hp, p.energy, p.max_energy, p.name FROM characterr as p, user as u WHERE p.user_id = u.id AND u.id = '.$user_id.'') or die(mysqli_error($con));
$row2 = mysqli_fetch_row($sql2);

//Insere atividade do usuário
$sql3 = mysqli_query($con, 'SELECT * FROM activity_student') or die(mysqli_error($con));
$row3 = mysqli_num_rows($sql3);

mysqli_query($con, "UPDATE activity_student SET sub_activity='$row[1]', data=curdate(), hour=curtime() WHERE id = '$row3'");
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
		<script type="text/javascript">
			function submitDisableReq() {
				document.getElementById('goMission').disabled = true;
				
				alert("Você não possui todos os requerimentos para esta missão!");
			}
		</script>
    <link rel="shortcut icon" href="images/favicon.ico"/> </head>

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
				<div align="center" id="text">
					<form action="db_solve_mission.php" method="post" enctype="multipart/form-data" name="form" onSubmit="">
							<p>1 - Título da miss&atilde;o:<br>
								<input size="60" type="text" name="titulo_problema" id="titulo_problema" value="<?php echo utf8_encode($row[1]) ?>" readonly>
							</p><br>
							<p>2 - Nível:<br>
								<input type="text" name="nivel_problema" id="nivel_problema" value="<?php echo $row[2] ?>" readonly>
							</p><br>
							<p>3 - Energia necessária:<br>
								<input type="text" name="energia" id="energia" value="<?php echo $row[3] ?>" readonly>
							</p><br>
							<p>4 - Descrição:<br>
								<textarea name="resumo" id="resumo" cols="59" rows="5" readonly><?php echo utf8_encode($row[4]) ?></textarea>
							</p><br>
							<p>5 - XP:<br>
								<input type="text" name="xp" id="xp" value="<?php echo $row[5] ?>" readonly>
							</p><br>
							<p>6 - Moedas Pirata:<br>
								<input type="text" name="bp" id="bp" value="<?php echo $row[6] ?>" readonly>
							</p>
							<?php
							$sql2 = mysqli_query($con, "SELECT ext, data FROM mission WHERE id = '$mission_id'") or die(mysqli_error($con));
							while ($imagens = mysqli_fetch_array($sql2)){
									$dados['ext'] = $imagens['ext'];
									$dados['data'] = $imagens['data'];
							}
							$html2 .= '<tr class="atrV"><td><center><img src="../administrador/fotos_missoes/'.$dados['data']. '" width="200" height="210"/>';
							echo $html2;
							?>
							<br>
							<input type="hidden" name="mission_id" value="<?php echo $mission_id ?>">
							<center><p><input type="submit" value="Ir para missão" id="goMission"></p><br>
							<?php
							$find_chal = false;
							$find_equip = false;
							
							$sql = mysqli_query($con, "SELECT req_lvl, req_chal, req_equip FROM challenge WHERE id='$mission_id' ");
							$row = mysqli_fetch_array($sql);
							
							//Seleciona o id do desafio requerido
							$sql1 = mysqli_query($con, "SELECT id FROM challenge WHERE title='$row[1]' ");
							$id_req_chal = mysqli_fetch_array($sql1);
							
							//Seleciona o id do item requerido
							$sql2 = mysqli_query($con, "SELECT id FROM item WHERE name='$row[2]' ");
							$id_req_equip = mysqli_fetch_array($sql2);
							
							//Seleciona o nível do usuário
							$sql_lvl = mysqli_query($con, "SELECT lvl FROM characterr WHERE user_id='$user_id' ");
							$row_lvl = mysqli_fetch_array($sql_lvl);
							
							//Seleciona os desafios concluídos pelo usuário (id)
							$sql_chal = mysqli_query($con, "SELECT challenge_id FROM challenge_overcome WHERE user_id='$user_id' ");
							
							//Seleciona os itens do usuário (id)
							$sql_equip = mysqli_query($con, "SELECT item_id FROM character_item WHERE user_id='$user_id' ");
								
							//Se existe algum requerimento para o desafio
							if( !empty($row[0]) || !empty($row[1]) || !empty($row[2]) ){
								
								/* ______ Se o usuário não concluiu o desafio requerido ______ */
								while($row_chal = mysqli_fetch_array($sql_chal)){
									if( $row_chal[0] == $id_req_chal[0]) {
										$find_chal = true;
										break;
									}
								}
								
								/* ______ Se o usuário não possui um item requerido ______ */
								while($row_equip = mysqli_fetch_array($sql_equip)){
									if( $row_equip[0] == $id_req_equip[0]) {
										$find_equip = true;
										break;
									}
								}
								
								if( ($row_lvl[0] < $row[0]) || ( !empty($row[1]) && $find_chal == false) || ( !empty($row[2]) && $find_equip == false) ){
									?> <script>submitDisableReq(); </script> <?php
									
									echo "<br><p><b>Requerimentos pendentes:</b></p>";
									if( !empty($row[0]) && ($row_lvl[0] < $row[0]) )
										echo "<p>Nível: " . $row[0] . "</p>";
									if(!empty($row[1]) && ($find_chal == false))
										echo "<p>Missão: " . $row[1] . "</p>";
									if(!empty($row[2]) && ($find_equip == false))
										echo "<p>Item: " . $row[2] . "</p>";
								}
							}
							mysqli_close($con); ?>
						</form>
					</div>
				</div>
		</div> 
	</body>
</html>
