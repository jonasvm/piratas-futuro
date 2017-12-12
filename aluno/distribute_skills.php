<?php
include "valida_secao.inc";

$id = $_SESSION["id"];
include "conecta_mysql.inc";

$sql = mysqli_query($con, 'SELECT p.xp,p.hp,p.max_hp,p.energy,p.max_energy FROM characterr as p, user as u WHERE p.user_id = u.id AND u.id = '.$id.'') or die(mysqli_error($con));
$row = mysqli_fetch_row($sql);
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
    <head>
        <title>Piratas do Futuro</title>
        <meta name="description" content="website description" />
        <meta name="keywords" content="website keywords, website keywords" />
        <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
		<link href="http://fonts.googleapis.com/css?family=Muli" rel="stylesheet" type="text/css" />
		<link href="http://fonts.googleapis.com/css?family=Englebert" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" type="text/css" href="style/style1024.css" media="only screen and (max-width:1245px)"/>
        <link rel="stylesheet" type="text/css" href="style/style1280.css" media="only screen and (min-width: 1246px) and (max-width:1315px)"/>
		<link rel="stylesheet" type="text/css" href="style/style1920.css" media="only screen and (min-width: 1446px) and (max-width:1920px)"/>
        <link rel="stylesheet" type="text/css" href="style/style.css" media="only screen and (min-width:1116px) and (max-width:1445px)"/>
	<script>
		function validateSkills() {
			botao1 = document.form1.1.checked;
			//if(form1.getElementById('1').checked == false;) {
				alert("olaa");
				return false;
			//}
		}

		function menuClicked()
		{
			alert("Crie seu personagem primeiro!");
			return false;
		}
	</script>
    <link rel="shortcut icon" href="images/favicon.ico"/> </head>

    <body>
		<div id="main">
			<div id="header">
				<div id="top_menu">
					<ul>
						<li><a href="#" onclick="menuClicked()" >Ajuda</a></li>
						<li><a href="#" onclick="menuClicked()" >Créditos</a></li>
						<li><a href="#" onclick="menuClicked()" >Sair</a></li>
					</ul>
				</div>
				<div id="user_content">
                    <div id="user_picture_bg">
                    	
					</div>
					
				</div>
				<div id="menubar">
					<ul>
						<li><a href="#" onclick="menuClicked()" >In&iacute;cio</a></li>
						<li><a href="#" onclick="menuClicked()" >Status</a></li>
						<li><a href="#" onclick="menuClicked()" >Mapa</a></li>
						<li><a href="#" onclick="menuClicked()" >Arena</a></li>
						<li><a href="#" onclick="menuClicked()" >Desafios</a></li>
						<li><a href="#" onclick="menuClicked()" >Miss&otilde;es</a></li>
						<li><a href="#" onclick="menuClicked()" >Invent&aacute;rio</a></li>
						<li><a href="#" onclick="menuClicked()" >Loja</a></li>
						<li><a href="#" onclick="menuClicked()" >Ranking</a></li>
					</ul>
				</div>
			</div>
			<div id="content">
				<div id="text">
			<form id="form1" method="post" action="db_register_skill.php" onSubmit="return validateSkills(this)">
                        <p>Agora que voc&ecirc; j&aacute; fez o cadastro b&aacute;sico, chegou a hora de escolher uma habilidade especial que pode melhorar o desempenho de seu personagem durante o jogo. </p>
                        <p>N&atilde;o se preocupe caso voc&ecirc; goste de mais de uma, pois a cada n&iacute;vel voc&ecirc; poder&aacute; escolher uma nova habilidade para seu personagem. </p><br>
                        <p class="h2">Habilidades</p>
                        <p><input name="skill" type="radio" value="1" checked />Memória Eidética<br /></p>
                         <p>Seu personagem consegue se lembrar de tudo com riqueza de detalhes. Garante + 2 pontos em intelig&ecirc;ncia.</p><br>
                        <p><input name="skill" type="radio" value="2" /> Ambidestria<br /></p>
                        <p>Seu personagem &eacute; apto a usar tanto a m&atilde;o esquerda quanto a m&atilde;o direita com a mesma facilidade. Garante + 2 pontos em destreza.
                        </p><br>
                        <p><input name="skill" type="radio" value="3" /> Boa Apar&ecirc;ncia<br /></p>
                            <p>Seu personagem se destaca no meio de uma multid&atilde;o. Garante + 2 pontos em carisma.</p><br>
                        <p><input name="skill" type="radio" value="4" /> Corpo Atl&eacute;tico<br /></p>
                            <p>Seu personagem adquiriu com o tempo uma resist&ecirc;ncia t&atilde;o boa quanto a de um atleta. Garante + 2 pontos em vigor.</p><br>
                        <p><input name="skill" type="radio" value="5" /> Superfor&ccedil;a<br /></p>
                            <p>Seu personagem &eacute; muito mais forte que a maioria. Garante + 2 pontos em for&ccedil;a.</p><br>
                        <input name="user_id" id="user_id" type="hidden" value="<?php echo $_SESSION["id"]; ?>" />
                        <center><input type="submit" value="Salvar e continuar" /><br><br>
                    </form>
					</div>
				</div>
		</div> 
	</body>
</html>
