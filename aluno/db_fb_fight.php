<?php
include "valida_secao.inc";

$id = $_SESSION["id"];

//acesso ao banco de dados
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


//Recebendo dados do usuário
$sql2 = mysqli_query($con, 'SELECT p.xp,p.hp,p.max_hp,p.energy,p.max_energy FROM characterr as p, user as u WHERE p.user_id = u.id AND u.id = '.$id.'') or die(mysqli_error($con));
$row2 = mysqli_fetch_row($sql2);

// recebendo os dados
$opponent_id = $_POST["opponent_id"];
$user_id = $_POST["user_id"];

//declarando vetor de log e variavel auxiliar
$log;
$i = 0;
$fight = false;

//testando se o personagem tem energia para lutar
$sql = mysqli_query($con, "SELECT energy,hp FROM characterr WHERE user_id = '$user_id'") or die(mysqli_error($con));
$user = mysqli_fetch_row($sql);

$life_limit = $user[1] / 2;

if ( ($user[0] < 10) || ($life_limit > $user[1] || $user[1] == 0) ) {
	if ($user[0] < 10)
		header("Location: fb_fight_fail_lowenergy.php");

	if ($life_limit > $user[1] || $user[1] == 0)
		header("Location: fb_fight_fail_lowlife.php");
}

else {
	$fight = true;
	
	//carregando dados do desafiante
	$sql = mysqli_query($con, "SELECT s_t,d_t,c_t,i_t,ch_t,atk_t,ip_t,hp FROM characterr WHERE user_id = '$user_id'") or die(mysqli_error($con));
	$user = mysqli_fetch_row($sql);

	//carregando dados do oponente
	$sql1 = mysqli_query($con, "SELECT s_t,d_t,c_t,i_t,ch_t,atk_t,ip_t,hp FROM characterr WHERE user_id = '$opponent_id'") or die(mysqli_error($con));
	$opponent = mysqli_fetch_row($sql1);

	//calculando ataque do desafiante
	$atk_u = $user[1] + $user[5];

	//calculando ataque do oponente
	$atk_o = $opponent[1] + $opponent[5];

	//calculando ip do desafiante
	$ip_u = $user[1] + $user[6] + 10;

	//calculando ip do oponente 
	$ip_o = $opponent[1] + $opponent[6] + 10;

	//carregando pontos de vida do desafiante
	$hp_u = $user[7];

	//carregando pontos de vida do oponente
	$hp_o = $opponent[7];

	//carregando iniciativa do desafiante
	$ini_u = $user[1];

	//carregando iniciativa do oponente
	$ini_o = $opponent[1];

	//tirando a iniciativa para ver quem começa o combate
	if ($ini_u > $ini_o) {
		$ini_atk = "desafiante";
		$log[$i] = "O desafiante inicia o combate.";
		$i = $i + 1;
	} else {
		$ini_atk = "oponente";
		$log[$i] = "O oponente toma iniciativa e inicia o combate.";
		$i = $i + 1;
	}

	while (($hp_u > 0) && ($hp_o > 0)) {
		///////////////////////////////////////
		//  rotina de ataque do desafiante  //
		//////////////////////////////////////
		if ($ini_atk == "desafiante") {
			$rand_atk = rand(1, 20);
			//se número aleatório gerado for 1, o oponente da um ataque de oportunidade devido a uma falha crítica
			if ($rand_atk == 1) {
				//no ataque de oportunidade um novo número aleatório é gerado, desta vez para o oponente
				$rand_atkOp = rand(1, 20);
				//no ataque de oportunidade, a condição também é testada, mas ataque de oportunidade não gera ataque de oportunidade.
				   //neste caso o ataque de oportunidade falhou
				if ($rand_atkOp == 1) {
					$log[$i] = "Você foi atacar mas seu oponente conseguiu uma grande oportunidade e atacou primeiro, porém ele perdeu a oportunidade.";
					$i = $i + 1;
				}
				//neste ponto é testado se o ataque de oportunidade foi um acerto crítico
				if ($rand_atkOp == 20) {
					$damage = 10;
					if($hp_u <= $damage)
						$hp_u = 0;
					else
						$hp_u = $hp_u - $damage;
						
					$log[$i] = "No seu ataque seu oponente te contragolpeou em um ponto crítico lhe causando '$damage' de dano.";
					$i = $i + 1;
				}
				//neste caso o ataque de oportunidade não foi uma falha crítica nem um acerto crítico, então o ataque é testado
				$atk = $atk_o + $rand_atkOp;
				//neste caso o oponente acerta o ataque de oportunidade
				if ($atk > $ip_u) {
					$damage = rand(1, 5);
					if($hp_u <= $damage)
						$hp_u = 0;
					else
						$hp_u = $hp_u - $damage;
						
					$log[$i] = "Você foi atacar mas seu oponente conseguiu uma grande oportunidade e atacou primeiro, causando '$damage' de dano.";
					$i = $i + 1;
				}
				//neste caso o oponente erra o ataque de oportunidade
				if ($atk < $ip_u) {
					$log[$i] = "Você foi atacar mas seu oponente conseguiu uma grande oportunidade e atacou primeiro, porém ele errou o ataque.";
					$i = $i + 1;
				}
			} //esta chave fecha if($rand_atk == 1)
			
			//o ataque do desafiante não gerou um ataque de oportunidade.
			//É testado então se o ataque foi um acerto crítico, se for o caso, o dano máximo é dobrado sem testes
			if ($rand_atk == 20) {
				$damage = 10;
				
				if($hp_o <= $damage)
					$hp_o = 0;
				else
					$hp_o = $hp_o - $damage;
						
				$log[$i] = "No seu ataque você conseguiu uma vantagem muito grande e golpeou seu oponente em um ponto fraco conseguindo um acerto crítico, causando '$damage' de dano.";
				$i = $i + 1;
			}
			//se o ataque não foi nem uma falha crítica e nem um acerto crítico, um teste simples é realizado
			$atk = $atk_u + $rand_atk;
			//testa se o ataque acertou
			if ($atk > $ip_o) {
				$damage = rand(1, 5);
				if($hp_o <= $damage)
					$hp_o = 0;
				else
					$hp_o = $hp_o - $damage;
					
				$log[$i] = "Você acertou um ataque em seu oponente causando '$damage' de dano.";
				$i = $i + 1;
			}
			//testa se o ataque falhou
			if ($atk < $ip_o) {
				$log[$i] = "Você tentou atacar seu oponente mas ele conseguiu se esquivar.";
				$i = $i + 1;
			}

			//muda a flag de ataque para oponente
			$ini_atk = "oponente";
		} //esta chave fecha o if($flag_atk == "desafiante")
		
		/*************************************
		**   rotina de ataque do oponente   **
		*************************************/
		if ($ini_atk == "oponente") {
			$rand_atk = rand(1, 20);
			//se número aleatório gerado for 1, o desafiante da um ataque de oportunidade devido a uma falha crítica
			if ($rand_atk == 1) {
				//no ataque de oportunidade um novo número aleatório é gerado, desta vez para o desafiante
				$rand_atkOp = rand(1, 20);
				//no ataque de oportunidade, a condição também é testada, mas ataque de oportunidade não gera ataque de oportunidade
				//neste caso o ataque de oportunidade falhou */
				if ($rand_atkOp == 1) {
					$log[$i] = "Seu oponente foi atacar mas você conseguiu uma grande oportunidade e atacou primeiro, porém a oportunidade foi perdida.";
					$i = $i + 1;
				}
				//neste ponto é testado se o ataque de oportunidade foi um acerto crítico
				if ($rand_atkOp == 20) {
					$damage = 10;
					if($hp_o <= $damage)
						$hp_o = 0;
					else
						$hp_o = $hp_o - $damage;
						
					$log[$i] = "Seu oponente foi lhe atacar mas antes que isto acontecesse você lhe acertou em um ponto crítico causando '$damage' de dano.";
					$i = $i + 1;
				}
				//neste caso o ataque de oportunidade não foi uma falha crítica nem um acerto crítico, então o ataque é testado
				$atk = $atk_u + $rand_atkOp;
				//neste caso o desafiante acerta o ataque de oportunidade
				if ($atk > $ip_o) {
					$damage = rand(1, 5);
					if($hp_o <= $damage)
						$hp_o = 0;
					else
						$hp_o = $hp_o - $damage;
						
					$log[$i] = "Seu oponente foi lhe atacar mas você conseguiu uma grande oportunidade e atacou primeiro, causando '$damage' de dano.";
					$i = $i + 1;
				}
				//neste caso o oponente erra o ataque de oportunidade
				if ($atk < $ip_o) {
					$log[$i] = "Seu oponente foi lhe atacar mas você conseguiu uma grande oportunidade e atacou primeiro, porém você errou o ataque.";
					$i = $i + 1;
				}
			}
			//o ataque do oponente não gerou um ataque de oportunidade
			//é testado então se o ataque foi um acerto crítico, se for o caso, o dano máximo é dobrado sem testes
			if ($rand_atk == 20) {
				$damage = 10;
				
				if($hp_o <= $damage)
					$hp_u = 0;
				else
					$hp_u = $hp_u - $damage;
					
				$log[$i] = "Seu oponente lhe atacou com uma vantagem muito grande e lhe golpeou em um ponto fraco conseguindo um acerto crítico, causando '$damage' de dano.";
				$i = $i + 1;
			}
			//se o ataque não foi nem uma falha crítica e nem um acerto crítico, um teste simples é realizado
			$atk = $atk_o + $rand_atk;
			//testa se o ataque acertou
			if ($atk > $ip_u) {
				$damage = rand(1, 5);
				if($hp_u <= $damage)
					$hp_u = 0;
				else
					$hp_u = $hp_u - $damage;
					
				$log[$i] = "Seu oponente acertou um ataque lhe causando '$damage' de dano.";
				$i = $i + 1;
			}
			//testa se o ataque falhou
			if ($atk < $ip_u) {
				$log[$i] = "Seu oponente tentou lhe atacar mas você conseguiu se esquivar.";
				$i = $i + 1;
			}
			//muda a flag de ataque para desafiante
			$ini_atk = "desafiante";
		} //esta chave fecha if($flag_atk == "oponente")
	}//esta chave fecha o while

	//testando o vencedor da luta
	if ($hp_u > $hp_o) {
		$coins = rand(1, 5);
		$log[$i] = "Você venceu a luta e ganhou 5 pontos de experiência. Além disso você ganhou '$coins' moedas piratas.";
		
		//atualizando a experiência,xp e money do desafiante
		if($row2[3] <= 10)
			$sql = mysqli_query($con, "UPDATE characterr set hp = '$hp_u', money = money + '$coins', energy = 0 WHERE user_id = '$user_id'") or die(mysqli_error($con));
		else
			$sql = mysqli_query($con, "UPDATE characterr set hp = '$hp_u', money = money + '$coins', energy = energy - 10 WHERE user_id = '$user_id'") or die(mysqli_error($con));

		//Insere atividade do usuário
		$sqll = mysqli_query($con, 'SELECT * FROM activity_student') or die(mysqli_error($con));
		$row_sql = mysqli_num_rows($sqll);
		
		mysqli_query($con, "UPDATE activity_student SET sub_activity='Luta', result='Venceu', data=curdate(), hour=curtime() WHERE id = '$row_sql'");
			
		$exp = 5;
	} else {
		$log[$i] = "Você perdeu a luta.";
		
		//atualizando os pontos de vida do personagem. no caso de derrota vai a zero.
		if($row2[3] <= 10)
			$sql = mysqli_query($con, "UPDATE characterr set hp = '0', energy = 0 WHERE user_id = '$user_id'") or die(mysqli_error($con));
		else
			$sql = mysqli_query($con, "UPDATE characterr set hp = '0', energy = energy - 10 WHERE user_id = '$user_id'") or die(mysqli_error($con));
		
		//Insere atividade do usuário
		$sqll = mysqli_query($con, 'SELECT * FROM activity_student') or die(mysqli_error($con));
		$row_sql = mysqli_num_rows($sqll);
		
		mysqli_query($con, "UPDATE activity_student SET sub_activity='Luta', result='Perdeu', data=curdate(), hour=curtime() WHERE id = '$row_sql'");
		
		$exp = 0;
	}

	//$_SESSION["exp"]=$exp;
}
//fechando conexão
//mysqli_close($con);
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
                	      <p class="h2">Combate realizado com sucesso!</p><br>
                	      <p>Veja o log abaixo com o resultado da luta.</p>
                	      <br>
                	      <?php
							if($fight == true)
								for ($j = 0; $j <= $i; $j++) {
									echo "<p>" . $log[$j] . "</p>";
								}
							?>
                	      <br />
                	    <form name="formSurvey" action="db_survey.php" method="post" class="survey">
                	        <h3>Deseja responder &agrave; nossa pesquisa?</h3>
                	        <h3>&Eacute; r&aacute;pido e voc&ecirc; ainda ganha 1 battle point!</h3>
                	        <br>
                	        <br>
                	        <p><input type="radio" name="op" value="1" checked/>Sim</p>
                	        <p><input type="radio" name="op" value="2"/>Não</p>
                	        <input type="submit" value="Enviar"/>
							<?php echo '<input name="exp" id="exp" type="hidden" value="' . $exp . '"  /><br>';
mysqli_close($con);?>
              	        </form>
              	      </div>
				</div>
		</div> 
	</body>
</html>
