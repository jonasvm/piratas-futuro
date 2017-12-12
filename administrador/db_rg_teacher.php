<?php
include "valida_secao.inc";

$id = $_SESSION["id"];
include "conecta_mysql.inc";

$sql = mysqli_query($con, "SELECT * FROM user WHERE type='2'") or die(mysqli_error($con));
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
		<title>Piratas do Futuro</title>
		<meta name="description" content="website description" />
        <meta name="keywords" content="website keywords, website keywords" />
        <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
		<link href="http://fonts.googleapis.com/css?family=Muli" rel="stylesheet" type="text/css" />
		<link href="http://fonts.googleapis.com/css?family=Englebert" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" type="text/css" href="style/style.css" />
        <script>
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
				var array_email = <?php echo json_encode($email); ?>;
				var array_cpf = <?php echo json_encode($cpf_rg); ?>;
				var array_name = <?php echo json_encode($name); ?>;
				
				//validando o campo nome do usuario
				nome = document.getElementById('nome').value;
				if(nome == ""){
					alert("Você deve preencher o campo Nome.");
					return false;
				}
				for(var i in array_name){
					if(nome == array_name[i]){
						alert("Nome já cadastrado");
						return false;
					}
				}
				
				//validando o username
				username = document.getElementById('username').value;
				if(username == ""){
					alert("Você deve preencher o campo Username.");
					return false;
				}
				
				for(var i in array_user){
					if(username == array_user[i]){
						alert("Username escolhido já está sendo utilizado por outro usuário");
						return false;
					}
				}
				
				//validando as senhas
				senha = document.getElementById('senha').value;
				if(senha == ""){
					alert("Você deve preencher o campo Senha.");
					return false;
				}
				confirmasenha = document.getElementById('confirma_senha').value;
				if (senha != confirmasenha){
					alert("Você deve usar a mesma senha na confirmação.");
					return false;
				}
				
				//validando o email
				email = document.getElementById('email').value;
				if(email == ""){
					alert("Você deve preencher o campo Email");
					return false;
				}
				
				for(var i in array_email){
					if(email == array_email[i]){
						alert("Email já cadastrado");
						return false;
					}
				}
				
				if(!isEmail(email)){
					alert("Email inválido.");
					return false;
				}
				
				//validando a idade
				idade = document.getElementById('idade').value;
				if(idade == ""){
					alert("Você deve preencher o campo Idade.");
					return false;
				}
				
				if(idade > 80 || idade < 18){
					alert("Você deve preencher o campo idade corretamente.");
					return false;
				}
				
				//validando o sexo
				if(!document.getElementById('sexo1').checked && !document.getElementById('sexo2').checked){
					alert("Você deve preencher o campo Sexo.");
					return false;
				}

				//validando o cpf
				cpf = document.getElementById('cpf_rg').value;
				
				if((cpf == "") || (isNaN(cpf)) || cpf.length != 11){
					alert("Você deve preencher o campo CPF corretamente.");
					return false;
				}
				
				/*for(var i in array_cpf){
					if(cpf == array_cpf[i]){
						alert("CPF já cadastrado");
						return false;
					}
				}*/
				
				var digits = (""+cpf).split("");
				
				resultCPF = validaCPF(digits[0], digits[1], digits[2], digits[3], digits[4], digits[5], digits[6], digits[7], digits[8], digits[9], digits[10]);
				
				if(!resultCPF){
					alert("CPF inválido.");
					return false;
				}
			}
		</script>
	<link rel="shortcut icon" href="./aluno/images/favicon.ico" /> </head>

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
						<h2 class="title">Cadastro de Professores</h2>
						<form name="form" method="post" action="register_teacher.php" onSubmit="return valida(this)">
							<table align="center">
							<td class="col1" width="300px">
								<p>Nome:<br />
								<input name="nome" type="text" id="nome" onkeypress='return onlyAlpha(event)'></p>
								<p>Senha:<br />
								<input name="senha" type="password" id="senha"></p>
								<p>CPF:<br />
								<input name="cpf_rg" type="cpf_rg" id="cpf_rg"></p>
								<p>Idade:<br />
								<input name="idade" type="text" id="idade" onkeypress='return onlyNum(event)'></p>
							</td>
							<td class="col2" width="300px">                        	
								<p>Username:<br />
								<input name="username" type="text" id="username"></p>
								<p>Confirmar Senha:<br />
								<input name="confirma_senha" type="password" id="confirma_senha"></p>
								<p>Email:<br />
								<input name="email" type="text" id="email"></p>
								<p>Sexo:<br />
								Masculino
								<input name="sexo" type="radio" id="sexo1" value='1' />
								Feminino
								<input name="sexo" type="radio" id="sexo2" value='2' /></p>
							</td></table>
							<center><br /><input class="reg" name="cadastrar" type="submit" id="cadastrar" value="Cadastrar">
						</form>
						
			</div>
			<div id="footer"/>
		</div>
	</body>
</html>
