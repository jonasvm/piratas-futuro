<?php
include "valida_secao.inc";

$id = $_SESSION["id"];
include "conecta_mysql.inc";

$item_id = $_GET["item_id"];
$item_type = $_GET["item_type"];

$sql = mysqli_query($con, "SELECT * FROM item WHERE id = '$item_id' ") or die(mysqli_error($con));
$row = mysqli_fetch_row($sql);
$old_name = $row[1];

$sql1 = mysqli_query($con, "SELECT * FROM item WHERE id <> '$item_id' ") or die(mysqli_error($con));
$i = 0;

$sql2 = mysqli_query($con, "SELECT value, field_sheet FROM benefit WHERE id = '$item_id' ") or die(mysqli_error($con));
$benefit = mysqli_fetch_row($sql2);

while($data = mysqli_fetch_array($sql1)) {
	$title[$i] = $data['name'];
	$i = $i + 1;
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
				var array_title = <?php echo json_encode($title); ?>;
				
				name = document.getElementById('title').value;
				desc = document.getElementById('subject').value;
				valorCompra = document.getElementById('buyValue').value;
				valorVenda = document.getElementById('sellValue').value;
				req = document.getElementById('levelReq').value;
				img = document.getElementById('image').value;
			
				for(var i in array_title){
					if(name == array_title[i]){
						alert("Nome já cadastrado");
						return false;
					}
				}
				
				if(name == ""){
					alert("Você deve preencher o campo Nome.");
					return false;
				}
				if(!isNaN(name)){
					alert("Preencha o campo Nome corretamente");
					return false;
				}
				
				if(desc == ""){
					alert("Você deve preencher o campo Resumo.");
					return false;
				}
				if(!isNaN(desc)){
					alert("Preencha o campo Resumo corretamente");
					return false;
				}
				
				if(valorCompra == ""){
					alert("Você deve preencher o campo Valor de Compra.");
					return false;
				}
				
				if(valorVenda == ""){
					alert("Você deve preencher o campo Valor de Venda.");
					return false;
				}
				
				if(req == ""){
					alert("Você deve preencher o campo Nível.");
					return false;
				}
				if(req < 1 || req > 5){
					alert("O campo Nível deve conter um valor de 1 a 5.");
					return false;
				}
				
				if(img != "")
				{
					imgSize = document.getElementById('image').files[0].size;
					
					if(imgSize > 500000000)
					{
						alert("Imagem muito grande. Por favor, escolha outra.");
						return false
					}
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
				<h2 class="title">Editar Item</h2>
				<form  accept-charset="latin1" enctype="multipart/form-data" name="form" method="post" action="db_rg_edit_item.php" onSubmit="return validate(this)">
				<input type="hidden" name="item_id" id="item_id" value="<?php echo $item_id ?>"/>
				<input type="hidden" name="item_type" id="item_type" value="<?php echo $item_type ?>"/>
				<input type="hidden" name="old_name" id="old_name" value="<?php echo $old_name ?>"/>

					<table align="center">
					<td class="col3" width="450px">
						<?php
						$name = $row[1];
						
						if($item_type == 1)
							$sql2 = mysqli_query($con, "SELECT ext, data, upload FROM armas_de_fogo WHERE name = '$name'") or die(mysqli_error($con));
						else if ($item_type == 2)
							$sql2 = mysqli_query($con, "SELECT ext, data, upload FROM armas_brancas WHERE name = '$name'") or die(mysqli_error($con));
						else if($item_type == 3)
							$sql2 = mysqli_query($con, "SELECT ext, data, upload FROM armaduras WHERE name = '$name'") or die(mysqli_error($con));
						else
							$sql2 = mysqli_query($con, "SELECT ext, data, upload FROM consumiveis WHERE name = '$name'") or die(mysqli_error($con));

	
						while ($imagens = mysqli_fetch_array($sql2)){
							$dados['ext'] = $imagens['ext'];
							$dados['data'] = $imagens['data'];
							$dados['upload'] = $imagens['upload'];
						}
						if($dados['upload'] == 0)
							$html .= '<tr class="atrV"><td><center><img src="data:image/' . $dados['ext'] . ';base64,' . base64_encode( $dados['data'] ) . '" width="92" height="102"/>';
						else
							$html .= '<tr class="atrV"><td><center><img src="../administrador/fotos_armas/'.$dados['data']. '" width="92" height="102"/>';
							
							
						
						
						echo $html;
						?>
						
						<p class="h2">Trocar imagem</p>
						<input type="file" name="image" id="image">
						<?php 	$sql3 = mysqli_query($con, "SELECT quant FROM consumiveis WHERE name = '$name'") or die(mysqli_error($con));	
							$row3 = mysqli_fetch_row($sql3);
							mysqli_close($con); ?>	
					</td>
					<td class="col4" width="300px">
						<p>Nome:<br />
						<input name="title" type="text" id="title" value="<?php echo utf8_encode($row[1]) ?>"></p>
						<p>Descri&ccedil;&atilde;o:<br />
						<textarea name="subject" id="subject" cols="30" rows="3"><?php echo utf8_encode($row[2]) ?></textarea></p>
						<p>Benef&iacute;cio:<br>
						<input type="text" size="7" name="benValue" id="benValue" value="<?php if($item_type != 4) echo $benefit[0]; else echo $row3[0]; ?>"/>
						<?php
						//Beneficio do item
						if($item_type != 4)
							$benefits = array("Pontos de vida atual", "Pontos de vida m&aacute;xima", "Energia atual", "Energia m&aacute;xima", "Ataque base</option>",
										"Ataque tempor&aacute;rio", "&Iacute;ndice de prote&ccedil;&atilde;o base", "&Iacute;ndice de prote&ccedil;&atilde;o tempor&aacute;rio",
										"For&ccedil;a base", "For&ccedil;a tempor&aacute;ria", "Destreza base", "Destreza tempor&aacute;ria", "Constitui&ccedil;&atilde;o base",
										"Constitui&ccedil;&atilde;o tempor&aacute;ria","Intelig&ecirc;ncia base", "Intelig&ecirc;ncia tempor&aacute;ria","Carisma base",
										"Carisma tempor&aacute;ria");
						else
							$benefits = array("Vida", "Energia"); 
										
						$html = '';
						
						$html .= '<select id="benType" name="benType">';
						$j = 0;
						if($item_type != 4)
							while($j<18)
							{
								if($benefit[1] == ($j+1))
									$html .= '<option value="'. ($j + 1) .'" selected >'. $benefits[$j] .'</option>';
								else
									$html .= '<option value="'. ($j + 1) .'">'. $benefits[$j] .'</option>';
								
								 $j++;
							}
						else
							while($j<2)
							{
								if($benefit[1] == ($j+1))
									$html .= '<option value="'. ($j + 1) .'" selected >'. $benefits[$j] .'</option>';
								else
									$html .= '<option value="'. ($j + 1) .'">'. $benefits[$j] .'</option>';
								
								 $j++;
							}
						$html .= '</select></p>';
						
						echo $html;
						?>
						
						<p>Valor de Compra:<br />
						<input name="buyValue" type="text" id="buyValue" value="<?php echo  $row[5] ?>" onkeypress='return onlyNum(event)' ></p>
						<p>Valor de Venda:<br />
						<input name="sellValue" type="text" id="sellValue" value="<?php echo  $row[4] ?>" onkeypress='return onlyNum(event)' ></p>					
						<p>N&iacute;vel:<br />
						<input name="levelReq" type="text" id="levelReq" value="<?php echo  $row[6] ?>" onkeypress='return onlyNum(event)' ></p>
					</td></table>
					<center><input class="reg" type="submit" value="Editar" id="cadastrar" name="cadastrar" ></center><br>
				</form>
			</div>
		</div>
	</body>
</html>
