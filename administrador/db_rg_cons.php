<?php
include "valida_secao.inc";

$id = $_SESSION["id"];
include "conecta_mysql.inc";

$sql1 = mysqli_query($con, "SELECT * FROM item") or die(mysqli_error($con));
$i = 0;

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
		function onlyNum(e){  //inutiliza
			var tecla=(window.event)?event.keyCode:e.which;
			
			if((tecla >= 48 && tecla <= 57) || (tecla == 8)){
				return true;
			}
			else{
				return false;
			}
		}
			
		function register(){
			//var array_title = <?php echo json_encode($title); ?>;
			
			//validando o campo nome do usuario
			nome = document.getElementById('name').value;
			desc = document.getElementById('subject').value;
			valorCompra = document.getElementById('buyValue').value;
			valorVenda = document.getElementById('sellValue').value;
			req = document.getElementById('levelReq').value;
			img = document.getElementById('image').value;
			
			
			
			/*for(var i in array_title){
				if(nome == array_title[i]){
					alert("Nome já cadastrado");
					return false;
				}
			}*/
				
			if(nome == ""){
				alert("Você deve preencher o campo Nome.");
				return false;
			}
			if(!isNaN(nome)){
				alert("Preencha o campo Nome corretamente");
				return false;
			}
			if(desc == ""){
				alert("Você deve preencher o campo Descrição.");
				return false;
			}
			if(!isNaN(desc)){
				alert("Preencha o campo Descrição corretamente");
				return false;
			}
				
			if(valorCompra == ""){
				alert("Você deve preencher o valor de compra do item.");
				return false;
			}
			if(valorCompra <= 0){
				alert("O valor deve ser superior à zero!");
				return false;
			}
			if(valorVenda == ""){
				alert("Você deve preencher o valor de venda do item.");
				return false;
			}
			if(valorVenda <= 0){
				alert("O valor deve ser superior à zero!");
				return false;
			}
			if(req == ""){
				alert("Você deve preencher o nível requerido para o item.");
				return false;
			}
			if(req < 1 || req > 5){
				alert("Você deve preencher o campo Nível com um valor de 1 a 5.");
				return false;
			}
			if(img == ""){
				alert("Você deve inserir uma imagem.");
				return false;
			}
			
			imgSize = document.getElementById('image').files[0].size;
			
			
		}
		function imageOk(){
			alert("Imagem carregada com sucesso!");
			return false;
		}
		function imageErr(){
			alert("Erro ao carregar a imagem!");
			return false;
		}
		function notAnImg(){
			alert("Erro: arquivo não é uma imagem!");
			return false;
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
						<h2 class="title">Cadastro de Itens Consumíveis</h2>
						<form name="form" enctype="multipart/form-data" method="post" action="db_reg_store_c.php" onSubmit="return register(this)">
							<table align="center">
							<td class="col1" width="400px">
							
							<p>1 - Nome:<br>
								<input type="text" name="name" id="name" required>
							</p>
							<p>2 - Descri&ccedil;&atilde;o:<br>
								<textarea name="subject" id="subject" cols="30" rows="3" required></textarea>
							</p><br>
                            </td>
                            <td class="col2" width="400px">
							<p>3 - Benef&iacute;cio:<br>
							<input type="text" size="7" name="benValue" id="benValue" pattern="[0-9]{1,}" oninvalid="this.setCustomValidity('Use apenas numeros.')" oninput="this.setCustomValidity('')" required>
                            <select id="benType" name="benType">
								<option value=1>Vida</option>';
								<option value=2>Energia</option>';
							</select>
							</p>
							<p>4 - Valor de compra (Battle Points):<br>
								<input type="text" name="buyValue" id="buyValue" pattern="[0-9]{1,}" oninvalid="this.setCustomValidity('Use apenas numeros.')" oninput="this.setCustomValidity('')" required>
							</p>						
							<p>5 - Imagem:<br>
								<input type="file" name="image" id="image" required>
						    </p><br>
                            </td></table>
                        <center><p><input class="reg" type="submit" value="Cadastrar" name="cadastrar"></p>
						</form>
					</div>
		</div>
	</body>
</html>
