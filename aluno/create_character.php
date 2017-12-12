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


$sql = mysqli_query($con, 'SELECT p.xp,p.hp,p.max_hp,p.energy,p.max_energy FROM characterr as p, user as u WHERE p.user_id = u.id AND u.id = '.$id.'') or die(mysqli_error($con));
$row = mysqli_fetch_row($sql);

//verificar username criado
$sql = mysqli_query($con, "SELECT * FROM characterr") or die(mysqli_error($con));
$i = 0;

while($data = mysqli_fetch_array($sql)) {
	$name[$i] = $data['name'];
	$i = $i + 1;
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
        <script>
		//Não permite digitar letras
		function SomenteNum(e){
			var tecla=(window.event)?event.keyCode:e.which;
			if((tecla >= 48 && tecla <= 57) || (tecla == 8)){
				return true;
			}
			else{
				return false;
			}
		}

		function menuClicked()
		{
			alert("Crie seu personagem primeiro!");
			return false;
		}
		
		function validate(){
			var array_name = <?php echo json_encode($name); ?>;
			
			var username = document.getElementById('name').value;
			var soma = (form1.str.value*1) + (form1.dex.value*1) + (form1.vig.value*1) + (form1.int.value*1) + (form1.cha.value*1);
			
			if(username == ""){
				alert("Você precisa escolher um nome para seu personagem.");
				return false;
			}
			
			for(var i in array_name){
			
				if(username == array_name[i]){
					alert("Nome do personagem escolhido já está sendo utilizado por outro usuário");
					return false;
				}
			}
			
			if (( soma > 60 ) || ( soma < 60 )) {
				alert("Seus atributos devem somar 60 pontos!");
				return false
			}
		}
		</script>
    <link rel="shortcut icon" href="images/favicon.ico"/> </head>

    <body>
		<div id="main">
			<div id="header">
				<div id="top_menu">
					<?php
					$sql = mysqli_query($con, "SELECT user_id FROM characterr WHERE user_id = '$id'");

					/*        _ Verifica se é o primeiro login do Aluno _        */
					if (mysqli_num_rows($sql) != 1)
					{
						$html = '';
						$html .= '<ul>';
						$html .= '<li><a href="#" onclick="menuClicked()" >Ajuda</a></li>';
						$html .= '<li><a href="#" onclick="menuClicked()" >Créditos</a></li>';
						$html .= '<li><a href="#" onclick="menuClicked()" >Sair</a></li>';
						$html .= '</ul>';
						}
					else
					{
						$html = '';
						$html .= '<ul>';
						$html .= '<li><a href="help.php">Ajuda</a></li>';
						$html .= '<li><a href="about.php">Créditos</a></li>';
						$html .= '<li><a href="logout.php">Sair</a></li>';
						$html .= '</ul>';
					}
					echo $html;
					?>
				</div>
				<div id="user_content">
                    <div id="user_picture_bg">
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
               	    <h1>Cadastro de Personagem</h1>
               	    <form id="form1" method="post" action="db_register_character.php" onSubmit="return validate(this)" >
               	      <p>Para cadastrar seu personagem, primeiro escolha um nome:</p>
               	      <p>
               	        <input type="text" name="name" id="name" required/>
           	          </p>
               	      <br>
               	      <p class="h2">Pontos de Atributo</p>
               	      <p>Agora, distribua 60 pontos entre os atributos abaixo (tente moderar na distribui&ccedil;&atilde;o, porque todos os atributos tem sua import&acirc;ncia).</p>
					  <center><table width="350px">
						  <tr>
							<td><p>Força</p></td>
							<td><p>Destreza</p></td>
							<td><p>Vigor</p></td>
							<td><p>Intelig&ecirc;ncia</p></td>
							<td><p>Carisma</p></td>					  
						  </tr>
						  <tr>
							<td width="70px"><center><input name="str" type="text" id="str" size="5" onkeypress='return SomenteNum(event)'/></td>
							<td width="70px"><input name="dex" type="text" id="dex" size="5" onkeypress='return SomenteNum(event)'/></td>
							<td width="70px"><input name="vig" type="text" id="vig" size="5" onkeypress='return SomenteNum(event)'/></td>
							<td width="70px"><input name="int" type="text" id="int" size="5" onkeypress='return SomenteNum(event)'/></td>
							<td width="70px"><input name="cha" type="text" id="cha" size="5" onkeypress='return SomenteNum(event)'/></td>
						  </tr>
					  </table><br>
               	      <input name="user_id" id="user_id" type="hidden" value="<?php echo $_SESSION["id"]; ?> " />
               	      <center><input id="cadastrar" name="cadastrar"type="submit" value=" Salvar e continuar " onclick="validaSum()" />
           	          <br>
           	        </form>
           	      </div>
           	  </div>
		</div>
	</body>
</html>
