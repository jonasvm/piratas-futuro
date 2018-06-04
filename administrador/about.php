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
                    			<h1 style="font-size:20px">Cr&eacute;ditos</h1>
					
                    <p class="h2">Idealizadores</p><br>
                    
                    <div style="height:170px; background-color:#D3DFEE">
                    <img src="images/about/ynogutti.jpg" height="150" style="margin-top:10px; margin-left:20px;"/>
                    <h3 style="padding-left:300px; margin-top:-90px; font-size:15px">Prof. Carlos Alberto Ynoguti</h3>
                    </div>
                    
		    <div style="height:170px;">
                    <img src="images/about/jonas.jpg" height="150" style="margin-top:10px; margin-left:20px;"/>
                    <h3 style="padding-left:300px; margin-top:-90px; font-size:15px">Eng. Jonas Vilas Boas Moreira</h3>
                    </div>
                    <br>

                    <p class="h2">Orientadores</p><br>
                    <div style="height:170px;background-color:#D3DFEE"">
                    <img src="images/about/rosimara.jpg" height="150" style="margin-top:10px; margin-left:20px;"/>
                    <h3 style="padding-left:300px; margin-top:-90px; font-size:15px">Profa. Rosimara Beatriz Arci Salgado</h3>
                    </div>
                    

                    <p class="h2">Programadores</p><br>
                    
                    <div style="height:170px;">
                    <img src="images/about/carol.jpg" height="150" style="margin-top:10px; margin-left:20px;"/>
                    <h3 style="padding-left:300px; margin-top:-90px; font-size:15px">Caroline Tenório Ribeiro</h3>
                    </div>
                    
                    <div style="height:170px;background-color:#D3DFEE"">
                    <img src="images/about/rodrigo.jpg" height="150" style="margin-top:10px; margin-left:20px;"/>
                    <h3 style="padding-left:300px; margin-top:-90px; font-size:15px">Rodrigo Carlos Brezolin Martins</h3>
                    </div>
                    <br>
					
					<div style="height:170px;">
                    <img src="images/about/danilo.jpg" height="150" style="margin-top:10px; margin-left:20px;"/>
                    <h3 style="padding-left:300px; margin-top:-90px; font-size:15px">Danilo Germiniani Virginio</h3>
                    </div>
                    <br>

			<div style="height:170px;background-color:#D3DFEE"">
                    <img src="images/about/lucas.jpg" height="150" style="margin-top:10px; margin-left:20px;"/>
                    <h3 style="padding-left:300px; margin-top:-90px; font-size:15px">Lucas Riboli Freire</h3>
                    </div>
                    <br>
		    
                    
                    <p class="h2">Designers gráficos</p><br>
                    
                    <div style="height:170px;">
                    <img src="images/about/leandro.jpg" height="150" style="margin-top:10px; margin-left:20px;"/>
                    <h3 style="padding-left:300px; margin-top:-90px; font-size:15px">Leandro Mendes Borelli Magalhães</h3>
                    </div>
                    
                    <div style="height:170px;background-color:#D3DFEE">
                    <img src="images/about/eduardo.jpg" height="150" style="margin-top:10px; margin-left:20px;"/>
                    <h3 style="padding-left:300px; margin-top:-90px; font-size:15px">Eduardo Heluany Duarte</h3>
                    </div>
                    <br>
                    
                    <p class="h2">Criador dos desafios</p><br>
                    
                    <div style="height:170px; ">
                    <img src="images/about/mateus.jpg" height="150" style="margin-top:10px; margin-left:20px;"/>
                    <h3 style="padding-left:300px; margin-top:-90px; font-size:15px">Mateus Madeira Mendes</h3>
                    </div>
					<br>
                    
                    <p class="h2">Apoio</p><br>
                    <center><img src="images/about/inatel.jpg" style="width:240px; height:90px;"/>
                  	  	<img src="images/about/FAPEMIG.jpg" style="width:240px; height:90px; margin-left:40px;"/>
                   		 <img src="images/about/cnpq.jpg" style="width:240px; height:90px; margin-left:40px;"/><br/><br/>
                    </center>
			
					</div>
				<br>
			</div>
		</div>
	</body>
</html>
