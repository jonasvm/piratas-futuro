<?php
include "valida_secao.inc";

$id = $_SESSION["id"];
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


$sql = mysqli_query($con, 'SELECT p.xp, p.hp, p.max_hp, p.energy, p.max_energy, p.name FROM characterr as p, user as u WHERE p.user_id = u.id AND u.id = '.$id.'') or die(mysqli_error($con));
$row = mysqli_fetch_row($sql);

//Insere atividade do aluno
mysqli_query($con, "INSERT into activity_student (name, activity, sub_activity, result, data, hour) VALUES ('$row[5]', 'Arena', '', '',curdate(), curtime())") or die(mysqli_error($con));
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
		<script src="http://code.jquery.com/jquery-latest.js"></script>
		<script type="text/javascript">
		function sigem(displayText) {
   document.getElementById('sig') = displayText;
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
        					<?php echo $row[1] ?>/<?php echo $row[2] ?>
                        </div>
                        <div id="user_energy">
        					<?php echo $row[3] ?>/<?php echo $row[4] ?>
                        </div>
                        <div id="user_xp">
    						<?php echo $row[0] ?>
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
				<div id="picture_left">
					<?php
					if (isset($_GET['idOp'])){
						$idOp = $_GET["idOp"];
						
						$query = mysqli_query($con, "SELECT ext, data, upload FROM user WHERE id='$idOp' ") or die(mysqli_error($con));
						while ($imagens = mysqli_fetch_array($query)){
							$adversario['ext'] = $imagens['ext'];
							$adversario['data'] = $imagens['data'];
							$adversario['upload'] = $imagens['upload'];
						}
						//echo '<img src="data:' . $dados['ext'] . ';base64,' . base64_encode( $dados['data'] ) . '" width="140" height="140" />';
						if($adversario['upload'] == 0)
							echo '<img src="data:image/' . $adversario['ext'] . ';base64,' . base64_encode( $adversario['data'] ) . '" width="140" height="140" /></a>';
						else
                                			echo "<img src='fotos_perfil/".$adversario['data']."' width='140' height='140' />";
					} else {
						$query = mysqli_query($con, "SELECT ext, data FROM images_base WHERE id='$id' ") or die(mysqli_error($con));
						while ($imagens = mysqli_fetch_array($query)){
							$dados['ext'] = $imagens['ext'];
							$dados['data'] = $imagens['data'];
							$dados['upload'] = $imagens['upload'];
						}
						if($dados['upload'] == 0)
							echo '<img src="data:image/' . $dados['ext'] . ';base64,' . base64_encode( $dados['data'] ) . '" width="140" height="140" /></a>';
						else
                                			echo "<img src='fotos_perfil/".$dados['data']."' width='140' height='140' />";
					}
					?>
				</div>
				
				<div id="op_status">
					<?php
					
					if(!isset($_GET['idOp'])){
						echo '<p class="h2"><center>Selecione um personagem!</p>';
					} else {
						$idOp = $_GET["idOp"];
						
						$sql = mysqli_query($con, "SELECT * FROM characterr WHERE user_id='$idOp'") or die(mysqli_error($con));
						$row = mysqli_fetch_row($sql);
						
						$html = '';
						$html .= '<center><p class="h2">Oponente</p></center><br>';
						$html .= '<p class="h3"><b>Nome: </b>' . $row[2] . '</p>';
						$html .= '<p class="h3"><b>Vida: </b>' . $row[10] . '/' . $row[11] . '</p>';
						$html .= '<p class="h3"><b>Energia: </b>' . $row[12] . '/' . $row[13] . '</p>';
						$html .= '<p class="h3"><b>Experiencia: </b>' . $row[14] . '</p>';
						
						echo $html;
					}
					?>
				</div>
				
				<div id="text_right">
					<form action="db_fb_fight.php" method="post">
						<?php
						include "conecta_mysql.inc";
						$user_id = $_SESSION["id"];
						$sql2 = mysqli_query($con, 'SELECT location FROM characterr WHERE user_id = '.$user_id.'') or die(mysqli_error($con));
						$row2 = mysqli_fetch_array($sql2);
						$html = '';
						$html .= '<center><table border="0" width="565">';

						$sql = mysqli_query($con, "SELECT id,name,user_id,location FROM characterr WHERE user_id <> '$user_id' AND location = '$row2[0]'") or die(mysqli_error($con));
						while ($row = mysqli_fetch_array($sql)) {
							$html .= '<tr><td class="atrV" width="90%"><p><a href="?idOp='.$row['user_id'].'">' . $row["name"] . '</a></p></td><td><input name="user_id" id="id_perfil" type="hidden" value="' . $user_id . '" /><input name="opponent_id" id="id_oponente" type="hidden" value="' . $row['user_id'] . '" /><input type="submit" value="Lutar" /></td></tr>';
						}
						$html .= '</table>';
						echo $html;
						?>
					</form>
			   </div>
			</div>
		</div> 
	</body>
</html>
