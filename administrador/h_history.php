<?php
include "valida_secao.inc";
include "conecta_mysql.inc";

$id = $_SESSION["id"];

//Deletar desafio
if(isset($_GET["chal"]))
{
	$chal = $_GET["chal"];
	$deleteChal = mysqli_query ($con, "DELETE FROM challenge WHERE id = '$chal'") or die(mysqli_error($con));

	if($deleteChal)
		echo '<script type="text/javascript"> alert("Desafio excluído com sucesso!"); </script>';
	else
		echo '<script type="text/javascript"> alert("Falha ao excluir Desafio."); </script>';
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Piratas do Futuro</title>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
        <link href="http://fonts.googleapis.com/css?family=Englebert" rel="stylesheet" type="text/css" />
		<link href="http://fonts.googleapis.com/css?family=Muli" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" type="text/css" href="style/style.css" />
		<script>
		function Deletar(titulo, id)
		{
			if (confirm("Deseja deletar \n" + titulo + " ?")) {
				window.location = 'index.php?chal=' + id;
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
            		</div><!-- fim do header -->
			<div id="content">
				<div id="text">
					
					<p>Em contrução...</p>
                    <br>
					</div>
				<br>
			</div>
		</div>
	</body>
</html>
