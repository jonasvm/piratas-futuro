<?php
include "valida_secao.inc";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">

    <head>
        <title>Piratas do Futuro</title>
        <meta name="description" content="website description" />
        <meta name="keywords" content="website keywords, website keywords" />
        <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
        <link rel="stylesheet" type="text/css" href="style/style.css" />
		<script type="text/javascript">  
		function habilitar_lvl(){  
			if(document.getElementById('req_lvl').checked){  
				document.getElementById('label_req_lvl').disabled = false;  
			} else {  
				document.getElementById('label_req_lvl').disabled = true; 
			}  
		}

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
                	<ul>
						<li class="top_help"><a href="#"></a></li>
						<li class="top_credits"><a href="about.php"></a></li>
                        <li class="top_space"></li>
						<li class="top_logout"><a href="logout.php"></a></li>
					</ul>
                </div>
				<div id="user_content">
                    <div id="sup1"></div>
                    <div id="sup2"></div>
                    <div id="sup3"></div>
                    <div id="sup4"></div>
				</div>
				<div id="menubar">
                	<div id="bar_side1"></div>
                    <div id="bar_side2"></div>
                	<ul>
						<li class="bar_main"><a href="index.php"><font size="5" color="white">Principal</font></a></li>
						<li class="bar_classes"><a href="classroom.php"><font size="5" color="white">Classes</font></a></li>
						<li class="bar_students"><a href="missions.php"><font size="5" color="white">Missões</font></a></li>
                        			<li class="bar_challenges"><a href="challenges.php"><font size="5" color="white">Desafios</font></a></li>
						<li class="bar_ranking"><a href="db_ranking.php"><font size="5" color="white">Ranking</font></a></li>
					</ul>
                    <div id="bar_side3"></div>
                    <div id="bar_side4"></div>
                </div>
			</div>
            <div id="site_content">
            	<div id="space1"></div>
            	<div id="space2"></div>
				<div id="left_content"></div>
                <div id="content">
                	<div id="text">
                    <form name="form" enctype="multipart/form-data" method="post" action="db_rg_challenges.php" onSubmit="return validate(this)">
                        <p>1 - Título do desafio:<br>
                            <input type="text" name="titulo_problema" id="titulo_problema">
                        </p>
                        <p>2 - Nivel:<br>
                            <input type="text" name="nivel" id="nivel" onkeypress='return onlyNum(event)'>
                        </p>
                        <p>3 - Energia:<br>
                            <input type="text" name="energia" id="energia" onkeypress='return onlyNum(event)'>
                        </p>
                        <p>4 - Resumo:<br>
                            <textarea name="resumo" id="resumo" cols="59" rows="5"></textarea>
                        </p>
                        <p>5 - Entrada:<br>
                            <input type="text" name="entrada" id="entrada">
                        </p>
                        <p>6 - Saída:<br>
                            <input type="text" name="saida" id="saida">
                        </p>
                        <p>7 - Experiência<br>
                            <input type="text" name="xp" id="xp" onkeypress='return onlyNum(event)'>
                        </p>
                        <p>8 - Battle Points:<br>
                            <input type="text" name="bp" id="bp" onkeypress='return onlyNum(event)'>
                        </p>
                        <p>9 - Localização:<br>
                        	<select id="location" name="location">
				<option value=1>1 - Ilha dos Ocidentais</option>';
				<option value=2>2 - Ilha dos Orientais</option>';
				<option value=3>3 - Ilha das Na&ccedil;&otilde;es</option>';
				<option value=4>4 - Nova &aacute;frica</option>';
				<option value=5>5 - Ilha dos Rebeldes</option>';
				</select>
							
                        </p>
						<p>10 - Requerimentos:<br>
							<center><table class="requeriments" width="700">
								<tr>
									<td><center><p><input type="checkbox" name="requeriments[]" id="req_lvl" value="lvl" onclick="habilitar_lvl();" > Level mínimo </td>
									<td><center><p><input type="checkbox" name="requeriments[]" id="req_chal" value="chal" onclick="habilitar_chal();" > Desafio(s) necessário(s) </p></td>
									<td><center><p><input type="checkbox" name="requeriments[]" id="req_equip" value="equip" onclick="habilitar_equip();" > Equipamento(s) necessário(s) </p></td>										
								</tr>
								<tr>
									<td><center><input type="text" name="label_req_lvl" id="label_req_lvl" disabled="disabled" onkeypress='return onlyNum(event)'></p></td>
									<td><center>
										<select id="label_req_chal" name="label_req_chal" size="5" disabled="disabled" >
											<?php
											include "conecta_mysql.inc";

											//Lista de Desafios
											$sql = mysqli_query($con, "SELECT title FROM challenge ") or die(mysqli_error($con));
											$html = '';
											
											while ($row = mysqli_fetch_assoc($sql)) {
												$html .= '<option value="'.$row['title'].'">'.$row['title'].'</option>';
											}
											
											echo $html;
											?>
										</select>
									</td>
									<td><center><select id="label_req_equip" name="label_req_equip" size="7" disabled="disabled" >
										<?php
										include "conecta_mysql.inc";

										//Lista de Itens
										$sql = mysqli_query($con, "SELECT name FROM item ") or die(mysqli_error($con));
										$html = '';
										
										while ($row = mysqli_fetch_assoc($sql)) {
											$html .= '<option value="'.$row['name'].'">'.$row['name'].'</option>';
										}
										
										echo $html;
										?></select>
									</td>
								</tr>
								<td>
									<p>11 - Imagem:<br>
									<input type="file" name="image" id="image">
									</p>
								</td>
							</table>
                        </p><br>
                        <p><input type="submit" value="Cadastrar"></p>
                    </form> 
                </div>
                </div>
                <div id="right_content"></div>
            </div>
            <div id="footer">
				<div id="footer_1"></div>
				<div id="footer_2">TODOS OS DIREITOS RESERVADOS</div>
				<div id="footer_3"></div>
			</div>
        </div>
    </body>
</html>
