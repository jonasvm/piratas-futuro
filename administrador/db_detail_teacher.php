<?php
include "valida_secao.inc";

$id = $_SESSION["id"];
$teacher_id = $_GET["teacher_id"];
include "conecta_mysql.inc";

$sql = mysqli_query($con, 'SELECT name, username, email, age, gender, cpf_rg FROM user WHERE id = '. $teacher_id .' ') or die(mysqli_error($con));
$row = mysqli_fetch_row($sql);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Piratas do Futuro</title>
		<meta name="description" content="website description" />
        <meta name="keywords" content="website keywords, website keywords" />
		<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
		<link href="http://fonts.googleapis.com/css?family=Muli" rel="stylesheet" type="text/css" />
		<link href="http://fonts.googleapis.com/css?family=Englebert" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" type="text/css" href="style/style.css" />
	<link rel="shortcut icon" href="./aluno/images/favicon.ico" /> </head>

	<body>
		<div id="main">
			<div id="header">
            	<div class="adm">Administrador</div>
                <ul class="menu">
                	<li><a href="index.php">Desafios</a></li>
					<li><a href="index_missions.php">Miss&otilde;es</a></li>
                    <li><a href="index_store.php">Loja</a></li>
					<li><a href="index_teacher.php">Professor</a></li>
                    <li><a href="logout.php">Sair</a></li>
                </ul>
            </div>
			<div id="content">
				<p class="detailTeacher"><b>Nome:</b> <?php echo $row[0] ?></p>
				<p class="detailTeacher"><b>Usu&aacute;rio:</b> <?php echo $row[1] ?></p>
				<p class="detailTeacher"><b>E-mail:</b> <?php echo $row[2] ?></p>
				<p class="detailTeacher"><b>Idade:</b> <?php echo $row[3]?></p>
				<p class="detailTeacher"><b>Sexo:</b> <?php
					if ($row[4] == 1)
						echo "Masculino";
					else 
						echo "Feminino";
				?></p>
				<p class="detailTeacher"><b>CPF:</b> <?php echo $row[5] ?></p>
			</div>
		</div>
	</body>
</html>
