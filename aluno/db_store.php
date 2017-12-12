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


$sql = mysqli_query($con, 'SELECT p.xp, p.hp, p.max_hp, p.energy, p.max_energy, p.name, p.lvl FROM characterr as p, user as u WHERE p.user_id = u.id AND u.id = '.$id.'') or die(mysqli_error($con));
$row = mysqli_fetch_row($sql);

//Insere atividade do usuário
mysqli_query($con, "INSERT into activity_student (name, activity, sub_activity, data, hour) VALUES ('$row[5]', 'Loja', 'Comprar', curdate(), curtime())");
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
				<div id="text">
                        	<p class="h2">Loja Pirata</p>
                            <p class="h3">Tudo que um pirata poderia desejar pelo menor preço do mercado!</p>
				<p class="h2">Seu Dinheiro</p>
				<?php
				$id = $_SESSION["id"];
				$sql = mysqli_query($con, 'SELECT money FROM characterr as p, user as u WHERE p.user_id = u.id AND u.id = ' . $id . '') or die(mysqli_error($con));
				$rown = mysqli_fetch_row($sql);
				echo "<p>" . $rown[0] . " moedas pirata</p>";
				?>
                            <br><a href="db_store.php"><p>Comprar</a> | <a href="db_store_sell.php">Vender</p></a><br>
													
								 <?php
								include "conecta_mysql.inc";
								
								$html = '';
								$html .= '<ul class="menuhorizontal">';
								$html .= '<li class="selected"><a href="db_store.php">Armas Brancas</a></li>';
								$html .= '<li><a href="armas_de_fogo.php">Armas de Fogo</a></li>';
								$html .= '<li><a href="armaduras.php">Armaduras</a></li>';
								$html .= '<li><a href="consumiveis.php">Consumíveis</a></li>';
								$html .= '</ul>';
								$html .= '<table class="tableStore" border="0" width="1200">';
								$html .= '<tr class="atr"><td><p class="title">Imagem</p></td><td><p class="title">Item</p></td>';
								$html .= '<td><p class="title">Informações</p></td><td><p class="title">Level Requerido</p></td><td><p class="title">Preço</p></td></tr>';
								$sql = mysqli_query($con, "SELECT level_required,name,description,id,buy_value,slot FROM item WHERE type='2' ORDER BY level_required ") or die(mysqli_error($con));
								
								while ($row2 = mysqli_fetch_assoc($sql)) {
									$name = $row2['name'];
									$sql2 = mysqli_query($con, "SELECT ext, data, upload FROM armas_brancas WHERE name='$name'") or die(mysqli_error($con));
									
									while ($imagens = mysqli_fetch_array($sql2)){
                                						$dados['ext'] = $imagens['ext'];
                                						$dados['data'] = $imagens['data'];
										$dados['upload'] = $imagens['upload'];
                            						}
									
									if($row2['slot'] == 1)
										$slot = "mãos";
									elseif($row2['slot'] == 2)
										$slot = "cabeça";
									elseif($row2['slot'] == 3)
										$slot = "corpo";
									else
										$slot = "não especificado";
										
									if($dados['upload'] == 0)
										$html .= '<tr class="atrV"><td><center><img src="data:image/' . $dados['ext'] . ';base64,' . base64_encode( $dados['data'] ) . '" width="92" height="102"/>' . '</td><td><center>' . utf8_encode($row2['name']) . '</td><td><center>Equipado: ' . $slot . '<br>' . utf8_encode($row2['description']) . '</td><td><center>' . $row2['level_required'] . '</td>';
									else
										$html .= '<tr class="atrV"><td><center><img src="../administrador/fotos_armas/'.$dados['data']. '" width="92" height="102"/>' . '</td><td><center>' . utf8_encode($row2['name']) . '</td><td><center>Equipado: ' . $slot . '<br>' . utf8_encode($row2['description']) . '</td><td><center>' . $row2['level_required'] . '</td>';
									$html .= '<td><form id="form1" method="post" action="db_buy.php"><center>' . $row2['buy_value'] . ' moedas pirata <br />';
									if( $row[6] < $row2['level_required'] )
										$html .= '<input type="submit" value="Comprar" disabled="disabled" /></td>';
									else 
										$html .= '<input type="submit" value="Comprar" /></td>';
									$html .= '<input name="user_id" id="user_id" type="hidden" value="' . $_SESSION["id"] . '" />';
									$html .= '<input name="item_id" id="item_id" type="hidden" value="' . $row2['id'] . '" /></form></tr>';
									
								}
								$html .= '</table>';
								echo $html;
								mysqli_close($con);?>
								<br>
						</div>
					</div>
		</div> 
	</body>
</html>
