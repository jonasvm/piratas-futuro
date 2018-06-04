<?php
include "valida_secao.inc";
include "conecta_mysql.inc";

$id = $_SESSION["id"];

if(isset($_GET["chal"]))
{
	$chal = $_GET["chal"];
	$deleteChal = mysqli_query ($con, "DELETE FROM mission WHERE id = '$chal'") or die(mysqli_error($con));

	if($deleteChal)
		echo '<script type="text/javascript"> alert("Desafio excluído com sucesso!");</script>';
	else
		echo '<script type="text/javascript"> alert("Falha ao excliir Desafio.");</script>';
	
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
        <link href="http://fonts.googleapis.com/css?family=Englebert" rel="stylesheet" type="text/css" />
		<link href="http://fonts.googleapis.com/css?family=Muli" rel="stylesheet" type="text/css" />
		<title>Piratas do Futuro</title>
		<link rel="stylesheet" type="text/css" href="style/style.css" />
		<script type="text/javascript">
		function Deletar(titulo, id)
		{
			if (confirm("Deseja deletar \n" + titulo + " ?")) {
				window.location = 'index_missions.php?chal=' + id;
			}
		}
		</script>
	<link rel="shortcut icon" href="./aluno/images/favicon.ico" />


	<style>
		.button {
		    background-color: #708090; 
		    border: none;
		    color: white;
		    padding: 15px 32px;
		    text-align: center;
		    text-decoration: none;
		    display: inline-block;
		    margin: 4px 2px;
		    cursor: pointer;
		    font-size: 20px;
		}
	</style>
	</head>

	<body>
		<div id="main">
			<div id="header">
			<div id="top_menu">
					<ul id="top_menu">
						<li><a href="help.php">Ajuda</a></li>
						<li><a href="about.php">Créditos</a></li>
						<li><a href="contact.php">Contato</a></li>
						<li><a href="logout.php">Sair</a></li>
					</ul>
				</div>
            	<div class="adm">Administrador</div>
                <ul class="menu">
                	<li><a href="index.php">Desafios</a></li>
					<li><a href="index_missions.php">Miss&otilde;es</a></li>
                    <li><a href="index_store.php">Loja</a></li>
					<li><a href="index_teacher.php">Professor</a></li>
                </ul>
            </div>
			<div id="content">
				<h2 class="title">Miss&otilde;es</h2>
				
				<p><input type="button" class="button" value="Cadastrar Missão" id="botao" onclick="location.href='db_rg_mission.php';"></p>
				<?php
				include "conecta_mysql.inc";
				$sql2 = mysqli_query($con, 'SELECT id,level, name FROM mission ORDER BY level') or die(mysqli_error($con));
				$rows_challenges = mysqli_num_rows($sql2);
				?>
				<form><?php
					$i=1;
					$html = '';
					$html .= '<center><table border="0" width="65%">';
					$html .= '<tr class="title2"><td><b>N&iacute;vel</b></td><td><b>T&iacute;tulo</b></td>';
					
					while($row = mysqli_fetch_array($sql2)) {
						
						if($i%2 == 0)
							$html .= '<tr class="corSim"><td class="textCenter">';
						else
							$html .= '<tr class="corNao"><td class="textCenter">';
							
						$html .= '<a href="db_detail_mission.php?mission_id=' . $row[0] . '">' . $row[1] . '</a></td><td><a href="db_detail_mission.php?mission_id=' . $row[0] . '">' . utf8_encode($row[2]) . '</a></td><td><a href="db_edit_mission.php?mission_id=' . $row[0] . '"><img src="images/edit icon.png" width="30" height="30" title="Editar"/></a></td><td><a href="#"><img src="images/delete icon.png" width="30" height="30" title="Excluir" onclick="Deletar(\''.utf8_encode($row[2]).'\', '.$row[0].')"/></a></td></tr>';
						
						$i++;
					}
					$html .= '</table>';
					echo $html;
					
					mysqli_close($con);
				?></form>
				<br>
			</div>
		</div>
	</body>
</html>
