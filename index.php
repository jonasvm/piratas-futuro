<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">

	<head>
		<title>Piratas do Futuro</title>
		<meta name="description" content="website description" />
		<meta name="keywords" content="website keywords, website keywords" />
		<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />
		<link rel="stylesheet" type="text/css" href="style/index_style.css" />
		<link rel="shortcut icon" href="aluno/images/favicon.ico" />
		<script>
			function redirect(){
				window.location.href ='register.php';
			}
		</script>
	</head>
	
			<?php
			if(preg_match('/(?i)MSIE [1-8]/',$_SERVER['HTTP_USER_AGENT'])){
				
				include("explorer.php");				//verifica se o navegador é o explorer antigo
				
				exit(0);
			}
			?>

	<body>
		<div id="main">
			<div id="header">
				<div id="top_left"></div>
				<div id="top_right"></div>
			</div>
			<div id="content">
				<div id="content_top"></div>
				<div id="content_left"></div>
				<div id="logo"></div>
				<div id="login">
                    <form name="form1" method="post" action="login.php">
						<div class="user"><input name="username" type="text" id="username" class="textfield"></div><br />
						<div class="pass"> <input name="senha" type="password" id="senha"></div>
						<input name="login" type="submit" id="b_login" value="" class="b_login">
						<input name="register" type="button" onclick="redirect()" id="b_register" value="" class="b_register">
					</form>
				</div>
				<div id="history">
					  <div id="text">
                      	<h1>A vida não é fácil no mundo pirata!</h1>
					    <p>Viver nunca foi fácil, e aqui no mundo de Piratas do Futuro não é diferente!</p>
					    <p>A história do jogo se passa por volta do ano 2050. O planeta terra se encontra em um estado miserável e os seres humanos competem por sobrevivência.</p>
					    <p>Como os governos não conseguem mais garantir um nível de vida para os cidadãos, todos renegaram seus políticos no começo, e em algum ponto da história a política convencional morreu e ressurgiram os governos militares.</p>
					    <p>Você jogador, não é aliado de nenhum destes governos. Voc&ecirc; leva uma vida errante e tira proveito das melhores situa&ccedil;&otilde;es, seja de um governo ou de outro. </p>
					    <p>Os chefes das na&ccedil;&otilde;es oferecem com certa frequ&ecirc;ncia miss&otilde;es em um sistema de divulga&ccedil;&atilde;o, e &eacute; da&iacute; que prov&eacute;m seu sustento. Se por ventura as miss&otilde;es ficarem muito dif&iacute;ceis ou escassas, voc&ecirc; pode aumentar sua renda nas arenas, que tamb&eacute;m &eacute; uma &oacute;tima fonte de renome!</p>
					    <p>Porém, se você é daqueles que gosta das tarefas mais difíceis, existe uma lista com &oacute;timos desafios &agrave; serem superados. Os desafios s&atilde;o a melhor forma de evoluir seu personagem e melhorar seu ranking, mas, como contrapartida existe o pequeno problema a ser resolvido...</p>
					    <p>N&atilde;o se esque&ccedil;a de gerenciar seus equipamentos e suas habilidades, s&atilde;o eles que fazem o diferencial em seu personagem!</p>
					    <p>Para finalizar, quando passar de n&iacute;vel, n&atilde;o se esque&ccedil;a de atualizar seu personagem!</p>
				      </div>
			   </div>
			</div>
			<div id="footer">
				<div id="footer_1"></div>
				<div id="footer_2">TODOS OS DIREITOS RESERVADOS</div>
				<div id="footer_3"></div>
			</div>
		</div>
	</body>
</html>
