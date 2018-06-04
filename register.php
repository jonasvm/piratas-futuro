<?php
include "conecta_mysql.inc";

$sql = mysqli_query($con, "SELECT * FROM user WHERE type='3'") or die(mysqli_error($con));
$i = 0;

while($data = mysqli_fetch_array($sql)) {
	$user[$i] = $data['username'];
	$email[$i] = $data['email'];
	$cpf_rg[$i] = $data['cpf_rg'];
	$i = $i + 1;
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">

	<head>
		<title>Piratas do Futuro</title>
		<meta name="description" content="website description" />
		<meta name="keywords" content="website keywords, website keywords" />
		<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
		<link href="http://fonts.googleapis.com/css?family=Muli" rel="stylesheet" type="text/css" />
		<link href="http://fonts.googleapis.com/css?family=Englebert" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" type="text/css" href="style/style.css" />
		<link rel="shortcut icon" href="aluno/images/favicon.ico" />

		<style> 
		input[type=email],
		input[type=text],
		input[type=password] {
		    width: 170px;		   
		    border: none;
		    background-color: #e6e6e6;
		    color: black;
		    text-align: center;
		}
		</style>
	</head>

	<body>
		<div id="main">
			<div id="header">
            	<div class="adm">Cadastro</div>
                <ul class="menubar">
                	<li><a href="index.php">Voltar</a></li>
                </ul>
            </div>
		</div>
		<div id="content">
			<div id="text">
				<p class="h2">Cadastro de Usu&aacute;rios</p><br>
				<form name="form1" method="post" action="db_register_students.php" onsubmit="return valida()">
					<p>Nome:<br>
					<input name="nome" type="text" id="nome" pattern="[A-Z a-z À-ú]{1,}" onkeypress="return onlyLetters(event)" ></p><br>
					<p>Senha:<br>
					<input name="senha" type="password" id="senha"></p><br>
					<p>CPF:<br>
					<input name="cpf_rg" type="text" id="cpf_rg" pattern="[0-9]{1,}" onkeypress="return onlyNum(event)" ></p><br>
					<p>Idade:<br>
					<input name="idade" type="text" id="idade" pattern="[0-9]{1,}" onkeypress="return onlyNum(event)" ></p><br> <!--onkeypress='return onlyNum(event)'-->
					<p>Sexo:<br>
					<p>Masculino
					<input name="sexo" type="radio" id="sexo1" value='1'  checked='checked' />
					Feminino
					<input name="sexo" type="radio" id="sexo2" value='2' /></p><br>
					<p>Username:<br>
					<input name="username" type="text" id="username" ></p><br>
					<p>Confirmar Senha:<br>
					<input name="confirma_senha" type="password" id="confirma_senha"></p><br>
					<p>Email:<br>
					<input name="email" type="text" id="email" ></p><br>
					<center><input name="cadastrar" type="submit" id="cadastrar" value="Cadastrar"><br><br>
				</form>
			</div>
		</div>

		<script>
			function onlyLetters(e){
				var tecla=(window.event)?event.keyCode:e.which;
				
				if((tecla >= 65 && tecla <= 90) || (tecla >= 90 && tecla <= 122) || tecla == 8 || tecla == 32){
					return true;
				}
				else{
					return false;
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
				
			//Valida os campos
			function valida(){
				//chama os arrays de usuario, email e cpf já cadastrados
				var array_user = <?php echo json_encode($user); ?>;
				var array_email = <?php echo json_encode($email); ?>;
				var array_cpf = <?php echo json_encode($cpf_rg); ?>;

				username = document.getElementById('username').value;
				senha = document.getElementById('senha').value;
				email = document.getElementById('email').value;
				idade = document.getElementById('idade').value;
				cpf = document.getElementById('cpf_rg').value;
				nome = document.getElementById('nome').value;

				if(nome == '' || senha == '' || cpf == '' || idade == '' || username == '' || email == ''){
					alert("Preencha todos os campos!");
					return false;
				}
				
				//validando o username
				for(var i in array_user){
					if(username == array_user[i]){
						alert("Nome de usuário digitado já foi escolhido.");
						return false;
					}
				}
				
				//validando as senhas
				confirmasenha = document.getElementById('confirma_senha').value;
				if (senha != confirmasenha){
					alert("Senha não confere!");
					return false;
				}
				
				//verifica se o email já foi cadastrado
				for(var i in array_email){
					if(email == array_email[i]){
						alert("E-mail já cadastrado");
						return false;
					}
				}

			        var atpos = email.indexOf("@");
			        var dotpos = email.lastIndexOf(".");
			        if (atpos<1 || dotpos<atpos+2 || dotpos+2>=email.length) {
					alert("Insira um e-mail válido!");
					return false;
			    	}
				
				//checa se a idade é válida
				if(idade > 99 || idade < 9){
					alert("Você deve preencher o campo idade corretamente.");
					return false;
				}

				//validando o cpf
				
			      for(var i in array_cpf){
					if(cpf == array_cpf[i]){
						alert("CPF já cadastrado");
						return false;
					}
				}
													
				var digits = (""+cpf).split("");
				
				resultCPF = validaCPF(digits[0], digits[1], digits[2], digits[3], digits[4], digits[5], digits[6], digits[7], digits[8], digits[9], digits[10]);
				
				if(!resultCPF){
					alert("CPF inválido.");
					return false;
				}
			}
		</script>
	</body> 
</html>
