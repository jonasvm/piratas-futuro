<?php
include "valida_secao.inc";
include "conecta_mysql.inc";

$mission_id = $_GET["id"];

$sql = mysqli_query($con, "SELECT * FROM mission WHERE id = '$mission_id '") or die(mysqli_error($con));
$row = mysqli_fetch_row($sql);

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
				
				title = document.getElementById('titulo').value;
				energy = document.getElementById('energia').value;
				subject = document.getElementById('descricao').value;
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
						<li class="top_help"><a href="help.php"></a></li>
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
                   <ul class="menuBar">
						<li class="bar_main"><a href="index.php"><font size="5" color="white">Principal</font></a></li>
						<li class="bar_classes"><a href="classroom.php"><font size="5" color="white">Classes</font></a></li>
						<li class="bar_students"><a href="missions.php"><font size="5" color="white">Missões</font></a></li>
                        			<li class="bar_challenges"><a href="challenges.php"><font size="5" color="white">Desafios</font></a></li>
						<li class="bar_ranking"><a href="db_ranking.php"><font size="5" color="white">Ranking</font></a></li>
						<li class="bar_messages"><a href="messages.php"><font size="5" color="white">Mensagens</font></a></li>
						
					</ul>
                    <div id="bar_side4"></div>
                </div>
			</div>
            <div id="site_content">
            	<div id="space1"></div>
            	<div id="space2"></div>
				<div id="left_content"></div>
                <div id="content">
                	<div id="text">
                    <form accept-charset="latin1" enctype="multipart/form-data" name="form" method="post" action="db_rg_edit_mission.php" onSubmit="return validate(this)">
				<input type="hidden" name="mission_id" id="mission_id" value="<?php echo $mission_id ?>"/>
					<table align="center">
							<p>1 - T&iacute;tulo da miss&atilde;o:<br>
								<input type="text" name="title" id="title" value="<?php echo utf8_encode($row[1]) ?>">
							</p>
							<p>2 - Energia:<br>
								<input type="text" name="energy" id="energy" value="<?php echo $row[3] ?>" onkeypress='return onlyNum(event)'>
							</p>
							<p>3 - Resumo:<br>
								<textarea name="subject" id="subject" cols="30" rows="3"><?php echo utf8_encode($row[4]) ?></textarea>
							</p>
							<p>4 - Experi&ecirc;ncia<br>
								<input type="text" name="xp" id="xp" value="<?php echo $row[5] ?>" onkeypress='return onlyNum(event)'>
							</p>
							<p>5 - Dinheiro:<br>
								<input type="text" name="money" id="money" value="<?php echo $row[6] ?>" onkeypress='return onlyNum(event)'>
							</p>
							<p>6 - Localiza&ccedil;&atilde;o:<br>
							<?php
							//Beneficio do item
							$locations = array("N&iacute;vel 1 - Ilha dos Ocidentais", "N&iacute;vel 2 - Ilha dos Orientais", "N&iacute;vel 3 - Ilha das Na&ccedil;&otilde;es",
											"N&iacute;vel 4 - Nova &aacute;frica", "N&iacute;vel 5 - Ilha dos Rebeldes");
											
							$html = '';
							
							$html .= '<select id="location" name="location">';
							$j = 0;
							while($j<5)
							{
								if($row[7] == ($j+1))
									$html .= '<option value="'. ($j + 1) .'" selected >'. $locations[$j] .'</option>';
								else
									$html .= '<option value="'. ($j + 1) .'">'. $locations[$j] .'</option>';
									
								 $j++;
							}
							$html .= '</select></p>';
							
							echo $html;
							?>
							<p>
								7 - Requerimentos:<br>
							<?php
								//Requerimento de Desafio
								if($row[9] != ''){
									$html = '';
									
									$html .= '<p><input type="checkbox" name="requeriments[]" id="req_chal" value="chal" onclick="habilitar_chal();" checked="true" /> Desafio(s) necess&aacute;rio(s)';
									
									//Requerimento de desafio
									$html .= '<br><select id="label_req_chal" name="label_req_chal" size="5" >';
									
									//Lista de Desafios
									$sql5 = mysqli_query($con, "SELECT title FROM challenge ") or die(mysqli_error($con));
									
									while ($row5 = mysqli_fetch_assoc($sql5)) {
										if($row5['title'] == $row[9])
											$html .= '<option value="'.utf8_encode($row5['title']).'" selected="true" >'.utf8_encode($row5['title']).'</option>';
										else
											$html .= '<option value="'.utf8_encode($row5['title']).'">'.utf8_encode($row5['title']).'</option>';
									}
									$html .= '</select></p>';
									
									echo $html;
								}
								else {
									$html = '';
									
									$html .= '<p><input type="checkbox" name="requeriments[]" id="req_chal" value="chal" onclick="habilitar_chal();" /> Desafio(s) necess&aacute;rio(s)';
									
									//Requerimento de desafio
									$html .= '<br><select id="label_req_chal" name="label_req_chal" size="5" disabled="disabled" >';
									
									//Lista de Desafios
									$sql5 = mysqli_query($con, "SELECT title FROM challenge ") or die(mysqli_error($con));
									
									while ($row5 = mysqli_fetch_assoc($sql5)) {
										$html .= '<option value="'.utf8_encode($row5['title']).'">'.utf8_encode($row5['title']).'</option>';
									}
									$html .= '</select></p>';
									
									echo $html;
								}
									
									
								//Requerimento de Item
								if($row[10] != ''){
									$html = '';
									
									$html .= '<p><input type="checkbox" name="requeriments[]" id="req_equip" value="equip" onclick="habilitar_equip();" checked="true" /> Equipamento(s) necess&aacute;rio(s)';
									
									//Requerimento de desafio
									$html .= '<br><select id="label_req_equip" name="label_req_equip" size="7">';
									
									//Lista de Desafios
									$sql5 = mysqli_query($con, "SELECT name FROM item ") or die(mysqli_error($con));
									
									while ($row5 = mysqli_fetch_assoc($sql5)) {
										if($row5['name'] == $row[10])
											$html .= '<option value="'.utf8_encode($row5['name']).'" selected="true" >'.utf8_encode($row5['name']).'</option>';
										else
											$html .= '<option value="'.utf8_encode($row5['name']).'">'.utf8_encode($row5['name']).'</option>';
									}
									$html .= '</select></p>';
									
									echo $html;
								}
								else {
									$html = '';
									
									$html .= '<p><input type="checkbox" name="requeriments[]" id="req_equip" value="equip" onclick="habilitar_equip();" /> Equipamento(s) necess&aacute;rio(s)';
									
									//Requerimento de item 
									$html .= '<br><select id="label_req_equip" name="label_req_equip" size="7" disabled="disabled" >';

									//Lista de Itens
									$sql5 = mysqli_query($con, "SELECT name FROM item ") or die(mysqli_error($con));
									
									while ($row5 = mysqli_fetch_assoc($sql5)) {
										$html .= '<option value="'.utf8_encode($row5['name']).'">'.utf8_encode($row5['name']).'</option>';
									}
									$html .= '</select></p>';
									
									echo $html;
								}
									
									
							?>
							</p><br>
							<div class="user_picture">
							<?php
							$sql2 = mysqli_query($con, "SELECT ext, data FROM mission WHERE id = '$mission_id'") or die(mysqli_error($con));
							while ($imagens = mysqli_fetch_array($sql2)){
								$dados['ext'] = $imagens['ext'];
								$dados['data'] = $imagens['data'];
							}
							echo '<td><center><img src="../administrador/fotos_missoes/'.$dados['data']. '" width="92" height="102"/>';
							
							?>
							</div>
							<p>Atualizar imagem:</p>
							<input type="file" name="image" id="image">
					</table>
					<center><input class="reg" type="submit" value="Editar" id="cadastrar" name="cadastrar" ></center><br>
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
