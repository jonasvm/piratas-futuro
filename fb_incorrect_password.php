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
		<script>
			function valida(){
				//validando o campo nome do usuario
				nome = document.getElementById('nome').value;
				if(nome == ""){
					alert("Você deve preencher o campo Nome.");
					return false;
				}
				//validando o username
				username = document.getElementById('username').value;
				if(username == ""){
					alert("Você deve preencher o campo Username.");
					return false;
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
				//validando o tipo
				username = document.getElementById('tipo').value;
				if(username == ""){
					alert("Você deve preencher o campo Tipo.");
					return false;
				}	
			}
		</script>
		<link rel="shortcut icon" href="aluno/images/favicon.ico" />
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
				<p class="style1">Senha incorreta!</p><br>
				<p>A senha utilizada est&aacute; incorreta, por favor, tente novamente! </p>
				<br>
				<p><a href="index.php">Clique aqui</a> para voltar para a tela de login</p>
			</div>
		</div>
	</body>
</html>
