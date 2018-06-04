<?php
$id = $_GET["id"];
include "valida_secao.inc";
include "conecta_mysql.inc";
$sql = mysqli_query($con, 'SELECT * FROM challenge WHERE id = ' . $id . '') or die(mysqli_error($con));
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
                    <form action="upload_solucao.php" method="post" enctype="multipart/form-data" name="form" onSubmit="">
                        <p>1 - Título do desafio:<br>
                            <input type="text" name="titulo_problema" id="titulo_problema" value="<?php echo utf8_encode($row[1]) ?>" readonly="true">
                        </p>
                        <p>2 - Nível:<br>
                            <input type="text" name="nivel" id="nivel" value="<?php echo $row[2] ?>" readonly="true">
                        </p>
                        <p>3 - Energia:<br>
                            <input type="text" name="energia" id="energia" value="<?php echo $row[3] ?>" readonly="true">
                        </p>
                        <p>4 - Resumo:<br>
                            <textarea name="resumo" id="resumo" cols="59" rows="5" readonly="true"><?php echo utf8_encode($row[4]) ?></textarea>
                        </p>
                        <p>5 - Entrada:<br>
                            <input type="text" name="entrada" id="entrada" value="<?php echo $row[5] ?>" readonly="true">
                        </p>
                        <p>6 - Saída:<br>
                            <input type="text" name="saida" id="saida" value="<?php echo $row[6] ?>" readonly="true">
                        </p>
                        <p>7 - XP:<br>
                            <input type="text" name="xp" id="xp" value="<?php echo $row[7] ?>" readonly="true">
                        </p>  
                        <p>8 - Battle Points:<br>
                            <input type="text" name="saida" id="saida" value="<?php echo $row[8] ?>" readonly="true">
                        </p>
			<?php
				switch($row[9])
				{
					case 1:
						$location = "Ilha dos Ocidentais";
						break;
					case 2:
						$location = "Ilha dos Orientais";
						break;
						
					case 3:
						$location = "Ilha das Na&ccedil;&otilde;es";
				 		break;
							
					case 4:
						$location = "Nova &aacute;frica";
						break;
					
					case 5:
						$location = "Ilha dos Rebeldes";
						break;
				}
			?>
                        <p>9 - Localiza&ccedil;&atilde;o:<br>
                            <input type="text" name="saida" id="saida" value="<?php echo $location ?>" readonly="true">
                        </p>
                        <input type="hidden" id="problema" name="problema" value="<?php echo $id ?>">
			<p>10 - Imagem:<br>
			<?php
				$sql2 = mysqli_query($con, "SELECT ext, data FROM challenge WHERE id = '$id'") or die(mysqli_error($con));
				while ($imagens = mysqli_fetch_array($sql2)){
					$dados['ext'] = $imagens['ext'];
					$dados['data'] = $imagens['data'];
				}
				$html2 .= '<tr class="atrV"><td><center><img src="/projeto_piratas/administrador/fotos_desafios/'.$dados['data']. '" width="92" height="102"/>';
				echo $html2;
			?>
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
