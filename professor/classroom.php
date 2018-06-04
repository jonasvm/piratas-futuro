<?php
include "valida_secao.inc";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">

    <head>
        <title>Piratas do Futuro</title>
        <meta name="description" content="website description" />
        <meta name="keywords" content="website keywords, website keywords" />
        <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
        <link rel="stylesheet" type="text/css" href="style/style.css" />
		
		<script type="text/javascript">
			function deleteSubject(id){
				if (confirm('Deseja excluir "'+id+'" ?')){
					window.location = 'db_delete_classroom.php?id='+id;
				}
			}
			
			function modifySubject(id){
					window.location = 'db_modify_classroom.php?id='+id;
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
                    <form><?php
						include "conecta_mysql.inc";

						$id = $_SESSION["id"];
						
						//Quantidade de salas no banco de dados
						$sql = mysqli_query($con, "SELECT subject, teacher, id FROM subjects") or die(mysqli_error($con));
						$aux = mysqli_num_rows($sql);
						
						$html = '';
						$html .= '<table border="0" width="400" class="tab_general">';
						$html .= '<tr>';
						$html .= '<td colspan="3"><b>Turmas</b></td></tr>';
						for ($i = 1; $i <= $aux; $i++) {
							$row = mysqli_fetch_array($sql);
							
							if($id == $row[1])
								$html .= '<tr><td><a href="db_detail_subject.php?subject=' . $row[2] . '">' . $row[0] . '</td><td><center><input type="button" name="delete" id="'.$row[2].'" value="Excluir" onclick="deleteSubject(this.id)""></td><td><center><input type="button" name="modify" id="'.$row[0].'" value="Alterar" onclick="modifySubject(this.id)""></center></td></tr>';
						}
						$html .= '</table>';
						echo $html;
                    ?></form>

		    <input type="button" value="Cadastrar Sala" id="botao" onclick="location.href='db_create_class.php';">
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
