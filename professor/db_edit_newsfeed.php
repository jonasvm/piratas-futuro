<?php
include "valida_secao.inc";

include "conecta_mysql.inc";
$msg = $_GET["id"];

$sql2 = mysqli_query($con, "SELECT subject, id_class, id_teacher FROM news_feed WHERE id = '$msg'") or die(mysqli_error($con));
$row2 = mysqli_fetch_row($sql2);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">

    <head>
        <title>Piratas do Futuro</title>
        <meta name="description" content="website description" />
        <meta name="keywords" content="website keywords, website keywords" />
        <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
        <link rel="stylesheet" type="text/css" href="style/style.css" />
		<script>
		function postSuccess() {
			alert("Publicado com sucesso!");
		}
		</script>
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
                    <form action="db_rg_edit_newsfeed.php" method="post" enctype="multipart/form-data" name="form">
                        <p>1 - Informação a ser publicada ao aluno:<br>
                           <textarea name="info" id="info" cols="59" rows="5"><?php echo utf8_encode($row2[0]) ?></textarea>
                        </p><br>
                        <p>2 - Turma:<br>
							<select id="class" name="class">
							<?php
							//Lista de Turmas
							$sql = mysqli_query($con, 'SELECT id, subject FROM subjects WHERE teacher = ' . $row2[2] . '') or die(mysqli_error($con));
							$html = '';
							$html .= '<option value=0>Todos</option>';
							while ($row = mysqli_fetch_assoc($sql)) {
								if($row['id'] == $row2[1])
									$html .= '<option value="'.$row['id'].'" selected>'.$row['subject'].'</option>';
								else
									$html .= '<option value="'.$row['id'].'">'.$row['subject'].'</option>';
							}
							
							echo $html;
							?></select>
                        </p>
						<br>
                        <input type="hidden" id="mensagem" name="mensagem" value="<?php echo $msg ?>">
						<center><p><input type="submit" value="Publicar" onclick="postSuccess()"></p></center>
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
