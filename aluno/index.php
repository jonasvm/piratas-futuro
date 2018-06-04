<?php
include "valida_secao.inc";

$id = $_SESSION["id"];
include "conecta_mysql.inc";

$sql = mysqli_query($con, "SELECT user_id FROM characterr WHERE user_id = '$id'");

/*        _ Verifica se é o primeiro login do Aluno _        */
if (mysqli_num_rows($sql) != 1) {
	mysqli_close($con);
	header("Location: start_ch.php");
}
 

/*        _ Receber dados do usuário _        */
$sql = mysqli_query($con,"SELECT p.xp,p.hp,p.max_hp,p.energy,p.max_energy FROM characterr as p, user as u WHERE p.user_id = u.id AND u.id ='$id'") or die(mysqli_error($con));
$row = mysqli_fetch_row($sql);

/*        _ Fazer update de energia/vida do usuário _        */
$sql = mysqli_query($con, "SELECT l_login_data FROM characterr WHERE user_id = '$id' ") or die(mysqli_error($con));
$lastLogin = mysqli_fetch_row($sql);

date_default_timezone_set("Brazil/East");

$cur_date = date('d-m-Y H:i:s') ; //data atual
$last_l = strtotime($lastLogin[0]); //data no banco de dados em formato 'numérico'
$c_hour = strtotime( $cur_date ); //data atual no formato 'numérico'
$c_hour= $c_hour+3600;
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
			mysqli_query($con, "UPDATE characterr SET energy = energy + " . $e_l . " WHERE user_id = '$id'") or die(mysqli_error());
		} else {
			mysqli_query($con, "UPDATE characterr SET energy = " . $row[4] . " WHERE user_id = '$id'") or die(mysqli_error($con));
		}
	}

} else {
	mysqli_query($con, " UPDATE characterr SET l_login_data = '$cur_date' WHERE user_id = '$id' ") or die(mysqli_error($con));
}


$sql = mysqli_query($con, 'SELECT p.xp, p.hp, p.max_hp, p.energy, p.max_energy, p.name FROM characterr as p, user as u WHERE p.user_id = u.id AND u.id = '.$id.'') or die(mysqli_error($con));
$row = mysqli_fetch_row($sql);

//Insere atividade do usuário
mysqli_query($con, "INSERT into activity_student (name, activity, data, hour) VALUES ('$row[5]', 'Login', curdate(), curtime())");
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
    <link rel="shortcut icon" href="images/favicon.ico"/> <link rel="shortcut icon" href="images/favicon.ico"/> 





	<script>
	//timer em fase de teste
	//10 minutos para recuperar 1 de vida/1 de energia
	// marca a data para q vai contar
	var y = new Date().getTime();
	var countDownDate = Math.round(y / minutes);
	var min = 1000 * 60;
	// atualiza de 1 em 1 segundo
	var x = setInterval(function() {

	    // pega a data atual
	    var aux = new Date().getTime();
	    var now = Math.round(aux / minutes);
	    
	    // faz a conta
	    var distance = countDownDate - now;
	    
	    // calcula minutos e segundos
	    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
	    var seconds = Math.floor((distance % (1000 * 60)) / 1000);
	    
	    // guarda no elemento com id=demo
	    document.getElementById("demo").innerHTML = minutes + "m " + seconds + "s ";
	    
	    // checa se deve acabar a contagem ou nao
	    if (distance < 0 && <?php echo $row[3] ?> <  <?php echo $row[4] ?>) {
		countDownDate = countDownDate + 10;
	    }
	    else{
		clearInterval(x);
	    }
	}, 1000);
	</script>

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
					<ul class="menuBar">
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
			</div> <!-- fecha o header -->
			<div id="content">
				<div id="text">
						<h1>Bem vindo ao Piratas do Futuro! </h1>
                    <p class="h2">Dicas para os iniciantes: </p><br>
						<?php
						$sql = mysqli_query($con, "SELECT id, id_teacher, id_class, subject, date FROM news_feed")  or die(mysqli_error($con));
						$sql2 = mysqli_query($con, "SELECT class FROM user WHERE id = '$id'")  or die(mysqli_error($con));
						while($row2 = mysqli_fetch_assoc($sql2)){
							$dado_t['class'] = $row2['class'];
						}
						

						setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8", "portuguese");
						date_default_timezone_set('America/Sao_Paulo');
						$html = '';
						$cont = 0;
						while($row = mysqli_fetch_assoc($sql)) {
							if($dado_t['class'] == $row['id_class'] or $row['id_class'] == 0){
								$cont += 1;
								$date = strftime("%d de %B de %Y", strtotime( $row['date'] ));	
							
								$sql1 = mysqli_query($con, 'SELECT name FROM user WHERE id = '. $row['id_teacher'] .'')  or die(mysqli_error($con));
								$row1 = mysqli_fetch_row($sql1);
							
								$html .= '<div class="balloon">';
								if($cont%2 == 0)
									$html .= '<div class="arrowLeft"></div>';
								else
									$html .= '<div class="arrowRight"></div>';
								$html .= "<p>" . utf8_encode($row['subject']) . "</p>";
								$html .= '<p class="published"><br>Publicado por ' . $row1[0] . ' em ' . $date . '</p>';
								$html .= '</div><br>';
							}
							
						}
						echo $html;
						?>
					</div>
				</div>
		</div> 
	</body>
</html>
