<?php
include "valida_secao.inc";
include "conecta_mysql.inc";

$id = $_SESSION["id"];

if(isset($_GET["teacher_id"]))
{
	$teacher_id = $_GET["teacher_id"];
	$deleteChal = mysqli_query ($con, "DELETE FROM user WHERE id = '$teacher_id'") or die(mysqli_error($con));

	if($deleteChal)
		echo '<script type="text/javascript"> alert("Professor excluído com sucesso!"); </script>';
	else
		echo '<script type="text/javascript"> alert("Falha ao excliir Professor."); </script>';
}
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Piratas do Futuro</title>
		<meta name="description" content="website description" />
        <meta name="keywords" content="website keywords, website keywords" />
        <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
		<link href="http://fonts.googleapis.com/css?family=Muli" rel="stylesheet" type="text/css" />
		<link href="http://fonts.googleapis.com/css?family=Englebert" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" type="text/css" href="style/style.css" />
		<script>
			function Deletar(titulo, id)
			{
				if (confirm("Deseja deletar \n" + titulo + " ?")) {
					window.location = 'index_teacher.php?teacher_id=' + id;
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
            	<div class="adm">Administrador</div>
                <ul class="menu">
                	<li><a href="index.php">Desafios</a></li>
					<li><a href="index_missions.php">Miss&otilde;es</a></li>
                    <li><a href="index_store.php">Loja</a></li>
					<li><a href="index_teacher.php">Professor</a></li>
                    <li><a href="logout.php">Sair</a></li>
                </ul>
            </div>
			<div id="content">
				<h2 class="title">Professores</h2>
				<input type="button" class="button" value="Cadastrar Professor" id="botao" onclick="location.href='db_rg_teacher.php';">
				<?php
				include "conecta_mysql.inc";
				$sql2 = mysqli_query($con, "SELECT id, name, username, email, age, gender, cpf_rg FROM user WHERE type=2");
				$rows_challenges = mysqli_num_rows($sql2);
				?>
				<form><?php
					$i=1;
					$html = '';
					$html .= '<center><table border="0" width="800">';
					$html .= '<tr class="title2"><td width="350"><b>Nome</b></td><td width="350"><b>Nome de usu&aacute;rio</b></td><td width="50"><b>Editar</b></td><td width="50"><b>Excluir</b></td></tr>';
					
					while($row = mysqli_fetch_array($sql2)) {
						
						if($i%2 == 0)
							$html .= '<tr class="corSim"><td class="textCenter">';
						else
							$html .= '<tr class="corNao"><td class="textCenter">';
							
						$html .= '<a href="db_detail_teacher.php?teacher_id=' . $row[0] . '">' . $row[1] . '</a></td><td class="textCenter"><a href="db_detail_teacher.php?teacher_id=' . $row[0] . '">' . $row[2] . '</a></td><td class="textCenter"><a href="db_edit_teacher.php?teacher_id=' . $row[0] . '"><img src="images/edit icon.png" width="30" height="30" title="Editar"/></a></td><td class="textCenter"><a href="#"><img src="images/delete icon.png" width="30" height="30" title="Excluir" onclick="Deletar(\''.$row[1].'\', '.$row[0].')"/></a></td></tr>';
						
						$i++;
					}
					$html .= '</table>';
					echo $html;
					
					mysqli_close($con);
				?></form>
				<br>
            </div>
			<div id="footer"/>
		</div>
	</body>
</html>
