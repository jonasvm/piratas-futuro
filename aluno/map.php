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
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
    <head>
        <title>Piratas do Futuro</title>
        <meta name="description" content="website description" />
        <meta name="keywords" content="website keywords, website keywords" />
        <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
		<link href="http://fonts.googleapis.com/css?family=Englebert" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" type="text/css" href="style/style1024.css" media="only screen and (max-width:1245px)"/>
        <link rel="stylesheet" type="text/css" href="style/style1280.css" media="only screen and (min-width: 1246px) and (max-width:1315px)"/>
		<link rel="stylesheet" type="text/css" href="style/style1920.css" media="only screen and (min-width: 1446px) and (max-width:1920px)"/>
        <link rel="stylesheet" type="text/css" href="style/style.css" media="only screen and (min-width:1116px) and (max-width:1445px)"/>
    <link rel="shortcut icon" href="images/favicon.ico"/> </head>

    <body>
		<div id="mainOverlay">
			<div id="allOpacity">
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
			</div>
			<div id="map">
				<a href="index.php"><img class="cancel" src="images/cancel.png" width="20" height="20" title="Sair"/></a>
				<p><img src="images/Mapa Geral.png" alt="" height="580" usemap="#Map" border="0" />
                  <map name="Map">
                    <area shape="poly" coords="306,175,316,188,325,183,332,177,343,174,349,174,359,173,361,167,361,159,363,153,363,145,354,138,345,133,344,127,342,124,333,120,322,120,313,120,306,123,297,129,293,130,287,137,286,140,282,143,292,146,301,154,302,156,304,161,309,167,311,175,321,196" href="map_rebeldes.php">
                    <area shape="poly" coords="243,284,231,293,231,304,224,309,220,315,213,319,205,324,202,328,197,338,207,343,217,349,232,349,239,349,247,339,256,333,255,324,252,318,249,306,250,302,252,296,251,291" href="map_nacoes.php">
                    <area shape="poly" coords="380,265,376,283,377,303,373,311,367,317,375,328,384,334,385,347,389,352,396,360,406,359,415,357,424,355,437,354,446,350,456,350,466,343,476,349,485,360,498,366,507,357,516,352,531,346,536,343,542,340,555,333,560,325,567,317,563,306,567,298,563,292,554,285,550,281,554,278,565,275,583,277,590,281,602,282,612,286,621,286,628,280,635,271,635,260,638,248,659,242,653,231,659,224,657,215,654,200,655,192,656,172,661,165,673,154,665,142,654,132,648,127,639,118,628,110,627,100,628,87,616,88,611,100,598,107,591,111,587,124,588,132,596,141,596,146,595,158,587,165,581,166,568,170,559,176,559,187,546,190,538,184,525,178,517,178,509,187,505,198,501,207,496,214,493,223,484,224,478,223,461,224,449,227,441,231,435,231,430,231,423,239,423,249,417,258,410,262,401,264,395,270,390,269" href="map_africa.php">
                    <area shape="poly" coords="97,442,111,449,124,457,136,457,151,456,161,452,171,452,184,459,194,463,205,461,219,466,231,466,241,463,257,458,273,457,289,455,266,460,258,468,247,476,239,481,233,486,231,494,236,499,241,507,245,514,230,519,218,522,211,524,196,524,187,524,179,524,175,522,166,520,157,513,150,511,144,508,138,503,134,503,120,503,112,500,106,487,106,477,108,468,108,465,102,454" href="map_ocidentais.php">
                    <area shape="poly" coords="413,494,426,498,438,497,445,495,453,492,461,485,466,480,469,470,467,456,474,455,479,445,486,438,488,431,497,418,509,418,527,419,535,417,540,423,546,427,557,436,558,441,569,451,576,451,579,456,582,460,584,466,584,474,584,479,586,484,592,491,595,495,589,500,582,505,578,508,572,511,567,515,557,521,550,523,545,527,529,529,513,525,507,523,496,523,485,522,477,522,468,523,457,527,450,531,444,533,435,538,432,541,420,541,414,539,404,531,404,524,413,514,413,509,405,502,406,498" href="map_orientais.php">
                    <area shape="poly" coords="559,155,554,153" href="#">
                    <area shape="poly" coords="565,159,573,157" href="#">
                  </map>
			  </p>
				<?php
				$sql = mysqli_query($con, "SELECT location FROM characterr WHERE user_id = $id") or die(mysqli_error($con));
				$row = mysqli_fetch_row($sql);

				if(isset($row[0])) {
					//Ilha dos Ocidentais
					if( $row[0] == 1) {
						$html = '<img style="position: absolute; margin-left: 145px; margin-top: -132px;" src="images/bola.png" width="15" height="15" title="Sua Localização"/>';
					}

					//Ilha dos Orientais
					else if( $row[0] == 2) {
						$html = '<img src="images/bola.png" style="position: absolute; margin-left: 545px; margin-top: -170px;" width="15" height="15" title="Sua Localização"/>';
					}
					
					//Ilha das Nações
					else if( $row[0] == 3) {
						$html = '<img style="position: absolute;margin-left: 235px; margin-top: -300px;" src="images/bola.png" width="15" height="15" title="Sua Localização"/>';
					}
						
					//Nova África
					else if( $row[0] == 4) {
						$html = '<img style="position: absolute;margin-left: 475px; margin-top: -330px;" src="images/bola.png" width="15" height="15" title="Sua Localização"/>';
					}
					
					//Ilha dos Rebeldes
					else if( $row[0] == 5) {
						$html = '<img style="position: absolute;margin-left:345px; margin-top: -450px;" src="images/bola.png" width="15" height="15" title="Sua Localização"/>';
					}
						
					echo $html;
				}
				?>
	  </div>
		</div> 
	</body>
</html>
