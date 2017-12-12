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

$sql = mysqli_query($con, 'SELECT p.name,p.xp,p.hp,p.max_hp,p.energy,p.max_energy,p.strength,p.dexterity,p.constitution,p.intelligence,p.charism,p.s_t,p.d_t,p.c_t,p.i_t,p.ch_t,p.atk,p.ip,p.atk_t,p.ip_t,p.money,p.lvl,p.location,p.bp  FROM characterr as p, user as u WHERE p.user_id = u.id AND u.id = '.$id.'') or die(mysqli_error($con));
$row = mysqli_fetch_row($sql);

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
                                //echo $id;
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
        					<?php echo $row[2] ?>/<?php echo $row[3] ?>
                        </div>
                        <div id="user_energy">
        					<?php echo $row[4] ?>/<?php echo $row[5] ?>
                        </div>
                        <div id="user_xp">
    						<?php echo $row[1] ?>
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
						<table class="char" width="900">
							<td class="col1" width="50%">
								<p class="h2">Personagem</p>
								<p>	Nome: <?php echo $row[0] ?> <br />
									Status: <?php
									if ($row[1] < 1000) {
										echo "Bixo";
									}
									if ($row[1] >= 1000 && $row[1] < 6000) {
										echo "Bixo";
									}
									if ($row[1] >= 6000 && $row[1] < 15000) {
										echo "Mutante";
									}
									if ($row[1] >= 15000 && $row[1] < 28000) {
										echo "Noob";
									}
									if ($row[1] >= 28000 && $row[1] < 45000) {
										echo "8";
									}
									if ($row[1] >= 45000 && $row[1] < 66000) {
										echo "10";
									}
									if ($row[1] >= 66000 && $row[1] < 91000) {
										echo "12";
									}
									if ($row[1] >= 91000 && $row[1] < 120000) {
										echo "14";
									}
									if ($row[1] >= 120000 && $row[1] < 153000) {
										echo "16";
									}
									if ($row[1] >= 153000 && $row[1] < 190000) {
										echo "18";
									}
									if ($row[1] > 190000) {
										echo "20";
									}
									?><br />
									Nivel:  <?php echo $row[21]; ?><br />
									Localização: <?php
									switch($row[22]){
										case 1:
											echo "Ilha dos Ocientais";
											break;
										case 2:
											echo "Ilha dos Orientais";
											break;

										case 3:
											echo "Ilha das Nações";
											break;

										case 4:
											echo "Nova África";
											break;

										case 5:
											echo "Ilha dos Rebeldes";
											break;
									}?>
								</p><br>
									<p class="h2">Pontos de vida/Energia</p>
									<p>	Atual: <?php echo $row[2] ?>/<?php echo $row[4] ?><br /> MAX: <?php echo $row[3] ?>/<?php echo $row[5] ?></p><br>
									<p class="h2">Ataque/Índice de Proteção</p>
									<p>	Base: <?php echo $row[16] ?>/<?php echo $row[17] ?><br /> Temporário: <?php echo $row[18] ?>/<?php echo $row[19] ?></p><br>
									<p class="h2">Dinheiro</p>
									<p>Dinheiro Pirata: <?php echo $row[20] ?></p>
									<p>Battle Points: <?php echo $row[23] ?></p>
							</td>
							<td class="col2" width="50%">
								<p class="h2">Atributos</p>
							<table width="320">
								<tr><td class="atr" width="100px"><p class="title">Atributo</p></td><td width="100px" class="atr"><p class="title">Valor Base</p></td><td class="atr"><p class="title">Valor Temporário</p></td></tr>
								<tr class="atrV"><td>Força</td><td><?php echo $row[6] ?></td><td><?php echo $row[11] ?></td></tr>
								<tr class="atrV"><td>Destreza</td><td><?php echo $row[7] ?></td><td><?php echo $row[12] ?></td></tr>
								<tr class="atrV"><td>Vigor</td><td><?php echo $row[8] ?></td><td><?php echo $row[13] ?></td></tr>
								<tr class="atrV"><td>Inteligência</td><td><?php echo $row[9] ?></td><td><?php echo $row[14] ?></td></tr>
								<tr class="atrV"><td>Carisma</td><td><?php echo $row[10] ?></td><td><?php echo $row[15] ?></td></tr>
							</table>

							<div class="user_picture">
							<?php
						        $query = mysqli_query($con, "SELECT ext, data, upload FROM user WHERE id='$id' ") or die(mysqli_error($con));

						        while ($imagens = mysqli_fetch_array($query)){
						            $dados['ext'] = $imagens['ext'];
						            $dados['data'] = $imagens['data'];
							    $dados['upload'] = $imagens['upload'];
						        }
						        //echo $id;
							if($dados['upload'] == 0)
								echo '<img src="data:image/' . $dados['ext'] . ';base64,' . base64_encode( $dados['data'] ) . '" width="110" height="125" /></a>';
							else
						        	echo "<img src='fotos_perfil/".$dados['data']."' width='180' height='185' />";
						        ?>
						 	</div>

							<br>
							<p class="h2">Atualizar imagem do perfil</p>
							<form action="db_managing_character.php" enctype="multipart/form-data"  method="post" >
								<input type="file" name="foto" >
								<input type="submit" name="upload" value="Upload">
							</form>
							
                                
                                <!-- Faz upload da imagem no Banco de Dados -->
				
				<?php       
                                // Se o usuário clicou no botão cadastrar efetua as ações 
                                if(isset($_POST['upload'])) {

                                    // Recupera os dados do campo
                                    $foto = $_FILES["foto"]; 
                                        
                                    if (!empty($foto["name"])) {   

                                    // Largura máxima em pixels
                                    $largura = 1000; 
                                    // Altura máxima em pixels 
                                    $altura = 1000; 
                                    // Tamanho máximo do arquivo em bytes 
                                    $tamanho = 300000;   

                                    $erro=0;
                                    $error="";

                                    // Verifica se o arquivo é uma imagem 

                                    if(!preg_match("/^image\/(pjpeg|jpeg|png|gif|bmp)$/", $foto["type"])){ 
                                        $error = "Isso não é uma imagem.";
                                        $erro = 1;
                                    }

                                    // Pega as dimensões da imagem 
                                    $dimensoes = getimagesize($foto["tmp_name"]);   

                                    // Verifica se a largura da imagem é maior que a largura permitida 
                                    if($dimensoes[0] > $largura) { 
                                        $error = "A largura da imagem não deve ultrapassar ".$largura." pixels";
                                        $erro = 1;
                                    }   

                                    // Verifica se a altura da imagem é maior que a altura permitida 
                                    if($dimensoes[1] > $altura) { 
                                        $error = "Altura da imagem não deve ultrapassar ".$altura." pixels"; 
                                        $erro = 1;
                                    }   

                                    // Verifica se o tamanho da imagem é maior que o tamanho permitido 
                                    if($foto["size"] > $tamanho) { 
                                        $error = "A imagem deve ter no máximo ".$tamanho." bytes";
                                        $erro = 1;
                                    }   

                                    // Se não houver nenhum erro 

                                    if ($erro == 0) {

                                        // Pega extensão da imagem 
                                        preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $foto["name"], $ext);   

                                        // Gera um nome único para a imagem 
                                        $nome_imagem = md5(uniqid(time())) . "." . $ext[1];   

                                        // Caminho de onde ficará a imagem 
                                        $caminho_imagem = "fotos_perfil/" . $nome_imagem;   

                                        // Faz o upload da imagem para seu respectivo caminho 
                                        move_uploaded_file($foto["tmp_name"], $caminho_imagem); 
                                        
                                        $imgUp = mysqli_query($con, "UPDATE user SET data='$nome_imagem' WHERE id ='$id'");
                                        
                                        if( !$imgUp )
											echo "<p><center>Erro ao carregar!</p>";
										else
										{
											echo "<center><p>Imagem carregada com sucesso!</p>";  
											
										
                                            
                                            // Seleciona todos os usuários 
                                            
                                            
                                            $query = mysqli_query($con, "SELECT data,upload FROM user WHERE id='$id' ") or die(mysqli_error($con));
					    while ($imagens = mysqli_fetch_array($query)){
					    	$dados['data'] = $imagens['data'];// Exibimos a foto
                                            }
                                            //echo "Teste: ".$dados['data'];
					    mysqli_query($con, "UPDATE user SET upload='1' WHERE id ='$id'"); //altera variável upload sinalizando q o usuário colocou uma foto de perfil
                                            echo "<center><img src='fotos_perfil/".$dados['data']."' alt='Foto de perfil' width='200' height='210' /></center><br />";
                                            echo "Redirecionando para a página inicial!";
                                            ?>
                                            
                                
                                            <META HTTP-EQUIV="REFRESH" CONTENT="3; URL=index.php">
                                
                                <?php
                                            
									}

                                        
                                    }   

                                    // Se houver mensagens de erro, exibe-as 
                                    if ($erro == 1) {
                                            echo $error . "<br />"; 
                                    }
                                }
                                        
                                
                                        
							/**
                            if (!empty($_FILES['image']['tmp_name']) ){
								$file = $_FILES['image']['tmp_name'];
								
								if( !isset($file) )
									echo "<center><p>Por favor, selecione uma imagem!</p>";
									
								else
								{
									
                                  
                            
                            //Lendo o arquivo temporário
									$fp = fopen($file, 'r');
									$data = fread($fp, filesize($file));
									$data = addslashes($data);
									$imgSize = $_FILES['image']['size'];
									$imgType = $_FILES['image']['type'];
									fclose($fp);
		  
		  
									if($imgSize == FALSE)
										echo "<center><p>Isto não é uma imagem!</p>";
									else
									{
                                    **/
                                        
									
								}								
							
							?>
								<?php mysqli_close($con); ?>
							<br><br><br><br><br></td>
						</table>
						
				</div>
			</div>
		</div> 
	</body>
</html>
