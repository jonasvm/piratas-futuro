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
                    <form><?php
						include "valida_secao.inc";
						include "conecta_mysql.inc";
						
						$student_id = $_GET["id"];
						$student_id = $_GET["id"];
						
						//Nome do aluno
						$sql2 = mysqli_query($con, "SELECT username, name FROM user WHERE id='$student_id'");
						$name = mysqli_fetch_array($sql2);
						
						//Atividades quantidade de atividades do aluno
						$sql3 = mysqli_query($con, "SELECT * FROM activity_student WHERE name='$name[0]'");
						$num_rows = mysqli_num_rows($sql3);
						$act = mysqli_fetch_array($sql3);
						
						$student = '<h2>';
						$student .= $name[0];
						$student .= '</h2>';
						echo $student;
					
						$html = '';
						$html .= '<table border="0" width="785" class="tab_general" >';
						$html .= '<tr>';
						$html .= '<tr><td><center><b>Atividade</b></td>';
						$html .= '<td><center><b>Sub-atividade</b></td>';
						$html .= '<td><center><b>Resultado</b></td>';
						$html .= '<td><center><b>Data</b></td>';
						$html .= '<td><center><b>Hora</b></td></tr>';
						for ($i = 1; $i <= $num_rows; $i++) {
							$sql = mysqli_query($con, "SELECT activity,sub_activity, result, data, hour FROM activity_student WHERE id = " . $i) or die(mysqli_error($con));
							$row = mysqli_fetch_array($sql);
							$html .= '<tr><td>' . $row[0] . '</td><td>' . $row[1] . '</td><td>' . $row[2] . '</td><td><center>' . $row[3] . '</td><td><center>' . $row[4] . '</td></tr>';
						}
						$html .= '</table>';
						echo $html;
                    ?></form>
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
