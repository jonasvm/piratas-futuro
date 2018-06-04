<?php
include "valida_secao.inc";

$id = $_SESSION["id"];
include "conecta_mysql.inc";

$teacher_id = $_GET["teacher_id"];
$sql = mysqli_query($con, "SELECT name, password, username, email, age, cpf_rg, gender FROM user WHERE id = '$teacher_id'") or die(mysqli_error($con));
$row = mysqli_fetch_row($sql);

$sql = mysqli_query($con, "SELECT * FROM user WHERE type='2' AND id <> '$teacher_id'") or die(mysqli_error($con));
$i = 0;

while($data = mysqli_fetch_array($sql)) {
	$user[$i] = $data['username'];
	$name[$i] = $data['name'];
	$email[$i] = $data['email'];
	$cpf_rg[$i] = $data['cpf_rg'];
	$i = $i + 1;
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />
        <link href="http://fonts.googleapis.com/css?family=Englebert" rel="stylesheet" type="text/css" />
		<link href="http://fonts.googleapis.com/css?family=Muli" rel="stylesheet" type="text/css" />
		<title>Piratas do Futuro</title>
		<link rel="stylesheet" type="text/css" href="style/style.css" />
			<script type="text/javascript">
			function validaCPF(a,b,c,d,e,f,g,h,i,j,k){
			
				var sumJ = (10*a) + (9*b) + (8*c) + (7*d) + (6*e) + (5*f) + (4*g) + (3*h) + (2*i);
				var sumK = (11*a) + (10*b) + (9*c) + (8*d) + (7*e) + (6*f) + (5*g) + (4*h) + (3*i) + (2*j);
				
				var modJ = sumJ%11;
				var modK = sumK%11;
				
				//valores de j
				if((modJ == 0) || (modJ == 1)){
					var rightJ = 0;
				}
				else{
					var rightJ = 11 - modJ;
				}
				
				//valores de k
				if((modK == 0) || (modK == 1)){
					var rightK = 0;
				}
				else{
					var rightK = 11 - modK;
				}
				
				//validando
				if((rightJ == j) && (rightK == k)){
					return true;
				} else {
					return false;
				}
			}
		
			function isEmail(email){
				var exclude=/[^@\-\.\w]|^[_@\.\-]|[\._\-]{2}|[@\.]{2}|(@)[^@]*\1/;
				var check=/@[\w\-]+\./;
				var checkend=/\.[a-zA-Z]{2,3}$/;
				if(((email.search(exclude) != -1)||(email.search(check)) == -1)||(email.search(checkend) == -1)){return false;}
				else {return true;}
			}

			function onlyAlpha(e){
				var tecla=(window.event)?event.keyCode:e.which;
				
				if(tecla >= 48 && tecla <= 57){
					return false;
				}
				else{
					return true;
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
			
			function valida(){
			
				var array_user = <?php echo json_encode($user); ?>;
				var array_name = <?php echo json_encode($name); ?>;
				var array_email = <?php echo json_encode($email); ?>;
				var array_cpf = <?php echo json_encode($cpf_rg); ?>;
				
				//validando o campo nome do usuario
				nome = document.getElementById('nome').value;
				if(nome == ""){
					alert("Voc� deve preencher o campo Nome.");
					return false;
				}
				for(var i in array_name){
					if(nome == array_name[i]){
						alert("Nome escolhido j� est� sendo utilizado.");
						return false;
					}
				}
				
				//validando o username
				username = document.getElementById('username').value;
				if(username == ""){
					alert("Voc� deve preencher o campo Username.");
					return false;
				}
				for(var i in array_user){
					if(username == array_user[i]){
						alert("Username escolhido j� est� sendo utilizado por outro usu�rio");
						return false;
					}
				}
				
				//validando as senhas
				senha = document.getElementById('senha').value;
				if(senha == ""){
					alert("Voc� deve preencher o campo Senha.");
					return false;
				}
				confirmasenha = document.getElementById('confirma_senha').value;
				if (senha != confirmasenha){
					alert("Voc� deve usar a mesma senha na confirma��o.");
					return false;
				}
				
				//validando o email
				email = document.getElementById('email').value;
				if(email == ""){
					alert("Voc� deve preencher o campo Email");
					return false;
				}
				for(var i in array_email){
					if(email == array_email[i]){
						alert("Email inserido j� est� sendo utilizado por outro usu�rio");
						return false;
					}
				}
				if(!isEmail(email)){
					alert("Email inv�lido.");
					return false;
				}
				
				//validando a idade
				idade = document.getElementById('idade').value;
				if(idade == ""){
					alert("Voc� deve preencher o campo Idade.");
					return false;
				}
				
				if(idade > 80){
					alert("Voc� deve preencher o campo idade apenas com n�meros v�lidos.");
					return false;
				}
				
				//validando o sexo
				if(!document.getElementById('sexo1').checked && !document.getElementById('sexo2').checked){
					alert("Voc� deve preencher o campo Sexo.");
					return false;
				}

				//validando o cpf
				cpf = document.getElementById('cpf_rg').value;
				
				if((cpf == "") || (isNaN(cpf)) || cpf.length != 11){
					alert("Voc� deve preencher o campo CPF corretamente.");
					return false;
				}
				for(var i in array_cpf){
					if(cpf == array_cpf[i]){
						alert("CPF inserido j� est� sendo utilizado por outro usu�rio");
						return false;
					}
				}
				
				var digits = (""+cpf).split("");
				
				resultCPF = validaCPF(digits[0], digits[1], digits[2], digits[3], digits[4], digits[5], digits[6], digits[7], digits[8], digits[9], digits[10]);
				
				if(!resultCPF){
					alert("CPF inv�lido.");
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
						<li><a href="about.php"><?php echo utf8_encode("Cr�ditos") ?></a></li>
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
				<h2 class="title">Editar Professor</h2>
				<form name="form" method="post" action="db_rg_edit_teacher.php" onSubmit="return valida(this)">				
					<input type="hidden" name="teacher_id" id="teacher_id" value="<?php echo $teacher_id ?>"/>
					<table align="center">
					<td class="col1" width="300px">
						<p>Nome:<br />
						<input name="nome" type="text" id="nome" value="<?php echo $row[0] ?>" onkeypress='return onlyAlpha(event)'></p>
						<p>Senha:<br />
						<input name="senha" type="password" id="senha" value="<?php echo  $row[1] ?>"></p>
						<p>CPF:<br />
						<input name="cpf_rg" type="cpf_rg" id="cpf_rg" value="<?php echo  $row[5] ?>"></p>
						<p>Idade:<br />
						<input name="idade" type="text" id="idade" value="<?php echo  $row[4] ?>" onkeypress='return onlyNum(event)'></p>
					</td>
					<td class="col2" width="300px">                        	
						<p>Username:<br />
						<input name="username" type="text" id="username" value="<?php echo  $row[2] ?>"></p>
						<p>Confirmar Senha:<br />
						<input name="confirma_senha" type="password" id="confirma_senha" value="<?php echo  $row[1] ?>"></p>
						<p>Email:<br />
						<input name="email" type="text" id="email" value="<?php echo $row[3] ?>"></p>
						<p>Sexo:<br />
						<?php if($row[6] == 1){?>
						Masculino
						<input name="sexo" type="radio" id="sexo1" value='1' checked/>
						Feminino
						<input name="sexo" type="radio" id="sexo2" value='2' /></p>
						<?php }else{ ?>
						Masculino
						<input name="sexo" type="radio" id="sexo1" value='1' />
						Feminino
						<input name="sexo" type="radio" id="sexo2" value='2' checked/></p>
						<?php } ?>
					</td></table>
					<center><br /><input class="reg" name="cadastrar" type="submit" id="cadastrar" value="Editar">
				</form>
			</div>
		</div>
	</body>
</html>
