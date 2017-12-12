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


$sql = mysqli_query($con, 'SELECT p.xp,p.hp,p.max_hp,p.energy,p.max_energy, p.lvl FROM characterr as p, user as u WHERE p.user_id = u.id AND u.id = '.$id.'') or die(mysqli_error($con));
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
		<script>
			function menuClicked()
			{
				alert("Crie seu personagem primeiro!");
				return false;
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
					<?php
				$sql = mysqli_query($con, "SELECT user_id FROM characterr WHERE user_id = '$id'");

				/*        _ Verifica se é o primeiro login do Aluno _        */
				if (mysqli_num_rows($sql) != 1)
				{
					$html = '';
					$html .= '<ul>';
					$html .= '<li><a href="index.php">In&iacute;cio</a></li>';
					$html .= '<li><a href="#" onclick="menuClicked()" >Status</a></li>';
					$html .= '<li><a href="#" onclick="menuClicked()" >Mapa</a></li>';
					$html .= '<li><a href="#" onclick="menuClicked()" >Arena</a></li>';
					$html .= '<li><a href="#" onclick="menuClicked()" >Desafios</a></li>';
					$html .= '<li><a href="#" onclick="menuClicked()" >Miss&otilde;es</a></li>';
					$html .= '<li><a href="#" onclick="menuClicked()" >Invent&aacute;rio</a></li>';
					$html .= '<li><a href="#" onclick="menuClicked()" >Loja</a></li>';
					$html .= '<li><a href="#" onclick="menuClicked()" >Ranking</a></li>';
					$html .= '</ul>';
				}
				else
				{
					$html = '';
					$html .= '<ul>';
					$html .= '<li><a href="index.php">Início</a></li>';
					$html .= '<li><a href="db_character.php">Status</a></li>';
					$html .= '<li><a href="map.php">Mapa</a></li>';
					$html .= '<li><a href="db_arena.php">Arena</a></li>';
					$html .= '<li><a href="db_challenges.php">Desafios</a></li>';
					$html .= '<li><a href="db_missions.php">Missões</a></li>';
					$html .= '<li><a href="db_inventory.php">Inventário</a></li>';
					$html .= '<li><a href="db_store.php">Loja</a></li>';
					$html .= '<li><a href="db_ranking.php">Ranking</a></li>';
					$html .= '</ul>';
				}
				echo $html;
				?>
				</div>
			</div>
			<div id="content">
				<div id="text">
							<h1>Tutorial</h1>
							
							<p>Se você chegou até aqui, é provável que o cadastro de seu personagem tenha sido efetuado com sucesso.</p>
							<p>Para confirmar, verifique sua página de <b>Status</b>. É lá que se encontram todos os dados de seu personagem.
							Todos os itens deverão estar preenchidos com os dados que você escolheu.
							Nesta página também é possível alterar sua foto, caso deseje. Ela ficará visível a outros jogadores na página
							de Ranking, ou na escolha de um personagem para a luta.</p>
							<p>Outra aba a verificar é o <b>Inventário</b>. O item que você escolheu na página de cadastro deverá estar aí.</p>
							<p>Se alguma dessas abas não estiver como descrito acima, contateo administrador para correção.</p>
							<p>Se estiver tudo certo, seu personagem já está cadastrado e pronto para as atividades!</p>
							<br>
							<p>A parte superior da página ficará sempre visível. Ela contém sua foto, a quantidade de  <img width="15px" height="15px" src="images/life.png"/>vida e   <img width="15px" height="15px" src="images/stamina.png"/>energia atual/maxima,
							e a quantidade de  <img width="30px" height="17px" src="images/exp.png"/>experiência total obtida.</p>
							<br>
							<p>Logo abaixo está a barra de menu, onde é feita toda a interação com o jogo.</p>
							<br>
							<p>A página <b>inicial</b> é onde você encontra publicações do professor e do administrador. É sempre bom verificá-la
							para obter novidades e dicas.</p>
							<br>
							<p>A página de Status, como descrita acima, é onde fica armazenada todas as informações de seu personagem.</p>
							<br>
							<p>Todas as ilhas do mundo pirata podem ser vizualizadas no <b>Mapa</b>. Cada ilha contém uma história diferente,
							com missões e desafios distintos. Você começa na Ilha dos Ocidentais, a ilha dos iniciantes. É possível conhecer
							qualquer ilha clicando nela no mapa geral, porém só poderá embarcar alcançando níveis específicos. A mudança de localização poderá 
							ser feita clicando no nome da ilha, em seu mapa. Só então você terá acesso a uma nova história, com novos desafios,
							missões e itens.</p>
							<br>
							<p>Na <b>Arena</b> você pode escolher um personagem para luta! Verifique os dados de seu adversário clicando no nome dele,
							e após escolher algum, clique em lutar. A luta será simulada. Se seu personagem for superior e ganhar, você terá sua recompensa
							em experiência e dinheiro pirata. Caso você perca, sua vida será anulada e não receberá nenhuma recompensa.</p>
							<br>
							<p>Os <b>Desafios</b> são as atividades que te dão as melhores recompensas e, em alguns, itens exclusivos. Eles contam uma história específica
							da sua ilha, e são solucionados com o envio do algoritmo correto. Leia atentamente cada um para a compreensão correta do que
							se pede. Você tem quantas chances quiser para certar um desafio, porém, após acertá-lo, não será possível refazê-lo.
							Nunca esqueça de um detalhe: não coloque o fim de linha (\n ou endl) após a impressão da saída. Isto poderá fazer com que seu código
							seja rejeitado.</p>
							<br>
							<p>O Inventário é o local onde é armazenado todos os seus itens. Para que os atributos de um item esteja ativo, é necessário
							primeiro equipá-lo, clicando em 'equipar'. Porém você estará restito a um item em cada mão, um no corpo e outro na cabeça.
							Caso tente equipar em algum lugar onde já não é possível, você será redirecionado a uma página com esta informação. Se
							isto ocorrer, desequipe um para que outro possa ser equipado.</p>
							<br>
							<p>A maioria dos itens podem ser adquiridos na <b>Loja</b>. Eles estão listados em 3 abas diferentes para fácil acesso: 'Armas brancas',
							que são armas de ataque equipadas na mão, assim como 'Armas de fogo', e 'Armaduras', que inclui escudos, capacetes e proteção
							para o corpo. Você só poderá comprar itens que tenham o nível requerido igual ou inferior ao seu nível, e que tenha um preço
							acessível a você.
							Cada item também possui um preço de venda, mas para vendê-lo na loja é preciso antes desequiquá-lo. Só assim ele ficará
							visível nesta página.</p>
							<br>
							<p>A última aba do menu é dedicada ao <b>Ranking</b>. Lá é possível ver qual é o melhor personagem!</p>
							<p>Não perca tempo, e alcance já o primeiro lugar ;)</p>
							<br>
						</div>
					</div>
		</div> 
	</body>
</html>
