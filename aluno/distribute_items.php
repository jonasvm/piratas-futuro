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
						<h1>Cadastro de Personagem</h1>
                    <form id="form1" method="post" action="db_register_item.php">
                        <p>Seu personagem j&aacute; est&aacute; criado mas ainda n&atilde;o est&aacute; pronto para enfrentar os perigos do mundo. </p>
                        <p>Antes de entrar em a&ccedil;&atilde;o pegue de presente um dos itens abaixo, mas n&atilde;o se acostume, depois n&atilde;o ser&aacute; t&atilde;o f&aacute;cil...  </p><br>
                        <center><table width="700">
							<tr><td width="350" ><center><p class="h2">Proteção</p></td><td><center><p class="h2">Ataque</p></td></tr>
							<tr><td>
							<p><center><input name="item_id" type="radio" value="33" checked />Colete de Couro<br><br>
							
							<?php 
						        
						        $query = mysqli_query($con, "SELECT ext, data FROM armaduras WHERE id='1' ") or die(mysqli_error($con));

						        while ($imagens = mysqli_fetch_array($query)){
						            $dados['ext'] = $imagens['ext'];
						            $dados['data'] = $imagens['data'];
						        }
						        //echo $id;
						        echo '<center><img src="data:image/' . $dados['ext'] . ';base64,' . base64_encode( $dados['data'] ) . '" width="110" height="125" /></a>';

							?>
							
							<center><br>Colete a prova de balas b&aacute;sico, ind&iacute;ce de prote&ccedil;&atilde;o + 1.</p></td>
							
							<td><p><center><input name="item_id" type="radio" value="30" />Bast&atilde;o Wood<br><br>
							
							<?php $query = mysqli_query($con, "SELECT ext, data FROM armas_brancas WHERE id='18' ") or die(mysqli_error($con));
							
							while ($imagens = mysqli_fetch_array($query)){
								$dados['ext'] = $imagens['ext'];
								$dados['data'] = $imagens['data'];
							}
							
							echo '<center><img src="data:image/' . $dados['ext'] . ';base64,' . base64_encode( $dados['data'] ) . '" width="110" height="125" /></a>';
							?>
							
							<center><br>Arma de ataque corpo a corpo, ATQ + 1.<input name="user_id" id="user_id" type="hidden" value="<?php echo $_SESSION["id"]; ?>" /></h3><br></td><tr>
						</table>
                        <br><p><center><input type="submit" value="Finalizar cadastro" /></p><br>
                    </form>
				</div>
			</div>
		</div> 
	</body>
</html>
