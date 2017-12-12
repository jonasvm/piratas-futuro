<?php
include "valida_secao.inc";
include "conecta_mysql.inc";

//Sala de aula a ser alterada
$subject = $_GET["id"];

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
						<li class="top_help"><a href="#"></a></li>
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
                    <div id="bar_side2"></div>
                	<ul>
						<li class="bar_main"><a href="index.php"><font size="5" color="white">Principal</font></a></li>
						<li class="bar_classes"><a href="classroom.php"><font size="5" color="white">Classes</font></a></li>
						<li class="bar_students"><a href="missions.php"><font size="5" color="white">Missões</font></a></li>
                        			<li class="bar_challenges"><a href="challenges.php"><font size="5" color="white">Desafios</font></a></li>
						<li class="bar_ranking"><a href="db_ranking.php"><font size="5" color="white">Ranking</font></a></li>
					</ul>
                    <div id="bar_side3"></div>
                    <div id="bar_side4"></div>
                </div>
			</div>
            <div id="site_content">
            	<div id="space1"></div>
            	<div id="space2"></div>
				<div id="left_content"></div>
                <div id="content">
                	<div id="text">
					<form action="db_register_modify_classroom.php" method="post">
						<p>Turma:</p>
						<p><input type="text" name="name_class" id="name_class" value="<?php echo $subject;?>"/></p><br>
						<p>Alunos não cadastrados na turma:</p>
						<p>Clique para adicionar</p>
						<select id="box" name="names[]" size="15" multiple="multiple" >
							<?php
							//id na turma selecionada
							$sql2 = mysqli_query($con, "SELECT id FROM subjects WHERE subject = '$subject'") or die(mysqli_error($con));
							$id_subject = mysqli_fetch_array($sql2);
							
							//Estudantes que nao estao na turma selecionada
							$sql = mysqli_query($con, "SELECT u.name, u.id FROM user as u WHERE type=3 AND id NOT IN (SELECT c.student FROM classroom as c WHERE subject = '$id_subject[0]')") or die(mysqli_error($con));
							
							while ($row = mysqli_fetch_assoc($sql)) {
								$html .= '<option value="'.$row['id'].'">'.$row['name'].'</option>';
							}
							
							echo $html;
							?>
						</select>
						<br><br><input type="submit" value="Salvar"/>
						<input type="hidden" id="id_subject" name="id_subject" value="<?php echo $id_subject[0] ?>">
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
