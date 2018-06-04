<?php
include "valida_secao.inc";

$id = $_SESSION["id"];
include "conecta_mysql.inc";

$sql = mysqli_query($con, "SELECT * FROM challenge") or die(mysqli_error($con));
$i = 0;

while($data = mysqli_fetch_array($sql)) {
	$title[$i] = $data['title'];
	$i = $i + 1;
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
		<script type="text/javascript">
		
			function habilitar_chal(){  
				if(document.getElementById('req_chal').checked){  
					document.getElementById('label_req_chal').disabled = false;  
				} else {  
					document.getElementById('label_req_chal').disabled = true; 
				}  
			}
			
			function habilitar_equip(){  
				if(document.getElementById('req_equip').checked){  
					document.getElementById('label_req_equip').disabled = false;  
				} else {  
					document.getElementById('label_req_equip').disabled = true;  
				}  
			}
			
			function onlyNum(e){
				var tecla=(window.event)?event.keyCode:e.which;
				
				if((tecla >= 48 && tecla <= 57) || (tecla == 8)){
					return true;
				}
				else{
					return false;
				}
			}
				
			//verifica se todos os campos foram preenchidos
			function validate(){
				//var array_title = <?php echo json_encode($title); ?>; //esta com problema
				
				title = document.getElementById('title').value;
				energy = document.getElementById('energy').value;
				subject = document.getElementById('subject').value;
				input = document.getElementById('input').value;
				output = document.getElementById('output').value;
				xp = document.getElementById('xp').value;
				bp = document.getElementById('bp').value;
				
				/*for(var i in array_title){
					if(title == array_title[i]){
						alert("Título já cadastrado");
						return false;
					}
				}*/
				
				if(title == ""){
					alert("Você deve preencher o campo Título.");
					return false;
				}
				
				if(!isNaN(title)){
					alert("Preencha o campo Título corretamente");
					return false;
				}
				
				if(energy == ""){
					alert("Você deve preencher o campo Energia.");
					return false;
				}
				
				if(subject == ""){
					alert("Você deve preencher o campo Resumo.");
					return false;
				}				
				if(!isNaN(subject)){
					alert("Preencha o campo Resumo corretamente");
					return false;
				}
				
				if(input == ""){
					alert("Você deve preencher o campo Entrada.");
					return false;
				}
				if(output == ""){
					alert("Você deve preencher o campo Saída.");
					return false;
				}
				if(xp == ""){
					alert("Você deve preencher o campo Experiência.");
					return false;
				}
				if(bp == ""){
					alert("Você deve preencher o campo Battle Points.");
					return false;
				}
				
			}

		</script>
	<link rel="shortcut icon" href="./aluno/images/favicon.ico" /> </head>

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
				<h2 class="title">Cadastro de Miss&otilde;es</h2>
				<form name="form" enctype="multipart/form-data" method="post" action="register_mission.php" onSubmit="return validate(this)" >
					<table align="center">
						<td class="col1" width="30%">
							<p>1 - T&iacute;tulo:<br>
								<input type="text" name="title" id="title">
							</p>
							<p>2 - Energia:<br>
								<input type="text" name="energy" id="energy" onkeypress='return onlyNum(event)'>
							</p>
							<p>3 - Resumo:<br>
								<textarea name="subject" id="subject" cols="30" rows="3"></textarea>
							</p>
							
							<p>4 - Experi&ecirc;ncia<br>
								<input type="text" name="xp" id="xp" onkeypress='return onlyNum(event)' >
							</p>
							<p>5 - Dinheiro:<br>
								<input type="text" name="money" id="money" onkeypress='return onlyNum(event)' >
							</p>
						</td>
						<td class="col2" width="35%">
							
							<p>6 - Localiza&ccedil;&atilde;o:<br>
								<select id="location" name="location">
									<option value=1>N&iacute;vel 1 - Ilha dos Ocidentais</option>';
									<option value=2>N&iacute;vel 2 - Ilha dos Orientais</option>';
									<option value=3>N&iacute;vel 3 - Ilha das Na&ccedil;&otilde;es</option>';
									<option value=4>N&iacute;vel 4 - Nova &aacute;frica</option>';
									<option value=5>N&iacute;vel 5 - Ilha dos Rebeldes</option>';
								</select>
							</p>
							<p>
								7 - Requerimentos:<br>
							<p><input type="checkbox" name="requeriments[]" id="req_chal" value="chal" onclick="habilitar_chal();" /> Miss&atilde;o necess&aacute;ria
							<!-- Requerimento de desafio -->
							<br><select id="label_req_chal" name="label_req_chal" size="5" disabled="disabled" >
								<?php
								include "conecta_mysql.inc";

								//Lista de Missões
								$sql = mysqli_query($con, "SELECT name FROM mission ") or die(mysqli_error($con));
								$html = '';
								
								while ($row = mysqli_fetch_assoc($sql)) {
									$html .= '<option value="'.$row['name'].'">'.$row['name'].'</option>';
								}
								
								echo $html;
								?>
							</select></p>
							<!-- Requerimento de item -->
							<p><input type="checkbox" name="requeriments[]" id="req_equip" value="equip" onclick="habilitar_equip()" /> Equipamento(s) necess&aacute;rio(s)
							<br><select id="label_req_equip" name="label_req_equip" size="7" disabled="disabled" >
								<?php
								include "conecta_mysql.inc";

								//Lista de Itens
								$sql = mysqli_query($con, "SELECT name FROM item ") or die(mysqli_error($con));
								$html = '';
								
								while ($row = mysqli_fetch_assoc($sql)) {
									$html .= '<option value="'.$row['name'].'">'.$row['name'].'</option>';
								}
								
								echo $html;
								?>
							</select></p>
							</p><br>

						</td>
						<td class="col3" width="30%">
							<p>8 - Imagem:<br>
								<input type="file" name="image" id="image" required>
							</p>
						</td>
					</table>
					<center><input class="reg" type="submit" value="Cadastrar" id="cadastrar" name="cadastrar" ></center><br>
				</form>
			</div>
		</div>
		<!--<div id="footer"></div>-->
	</body>
</html>
