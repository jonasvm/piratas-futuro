<?php
include "valida_secao.inc";

$id = $_SESSION["id"];
$mission_id = $_GET["mission_id"];
include "conecta_mysql.inc";

$sql = mysqli_query($con, 'SELECT * FROM challenge WHERE id = '. $mission_id .' ') or die(mysqli_error($con));
$row = mysqli_fetch_row($sql);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
        <link href="http://fonts.googleapis.com/css?family=Englebert" rel="stylesheet" type="text/css" />
		<link href="http://fonts.googleapis.com/css?family=Muli" rel="stylesheet" type="text/css" />
		<title>Piratas do Futuro</title>
		<link rel="stylesheet" type="text/css" href="style/style.css" />
		
		<script type="text/javascript">
			function adjustHeight(el){
				el.style.height = (el.scrollHeight > el.clientHeight) ? (el.scrollHeight)+"px" : "60px";
			}
		</script>
	<link rel="shortcut icon" href="./aluno/images/favicon.ico" /> 
	<style>
		#resumo{
		 text-align:justify;		
		}

	
		.button {
		    background-color: #708090; 
		    border: none;
		    color: white;
		    padding: 15px 32px;
		    text-align: center;
		    text-decoration: none;
		    display: inline-block;
		    margin: 4px 2px;
		    cursor: pointer;
		    font-size: 20px;
		}
	
	</style>
	</head>

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
			<div id="contentTransparent">
				<center><input id="inputTitle" size="100%" type="text" name="titulo_problema" id="titulo_problema" value="<?php echo utf8_encode($row[1]) ?>" readonly></center>
				
				<div id="chalInfo">
					<table width="100%" id="uniqueTable">
						<tr class="titleChalInfo"><td>N&iacute;vel</td>
						<td class="contentChalInfo"><input size="6px" type="text" name="nivel_problema" id="nivel_problema" value="<?php echo $row[2] ?>" readonly></td></tr>
						
						<tr class="titleChalInfo"><td>Energia</td>
						<td class="contentChalInfo"><input align="center" size="6px" type="text" name="energia" id="energia" value="<?php echo $row[3] ?>" readonly></td></tr>
						
						<tr class="titleChalInfo"><td>XP</td>
						<td class="contentChalInfo"><input size="6px" type="text" name="xp" id="xp" value="<?php echo $row[7] ?>" readonly></td></tr>
						
						<tr class="titleChalInfo"><td>Battle Points</td>
						<td class="contentChalInfo"><input size="6px" type="text" name="bp" id="bp" value="<?php echo $row[8] ?>" readonly></td></tr>
					</table>
				</div>
								
				<div id="chal">
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
					
					<br><b>Resumo:</b><br>
					<textarea name="resumo" id="resumo" cols="110" rows="6" readonly><?php echo utf8_encode($row[4]) ?></textarea><br><br>
					<p><b>Entrada:</b>
					<input size="30px" type="text" name="entrada" id="entrada" value="<?php echo $row[5] ?>" readonly>
					<b>Sa&iacute;da:</b>
					<input size="30px" type="text" name="saida" id="saida" value="<?php echo $row[6] ?>" readonly></p>
					
					<b>Localiza&ccedil;&atilde;o:</b>
					<input type="text" name="bp" id="bp" value="<?php echo $location ?>" readonly><br>
					<b>Requerimentos:</b>
					<?php
					if(($row[10] != 0) || ($row[11] != "") || ($row[12] != "")) {
						$html = '';
						
						if($row[10] > 0)
							$html .= '<br>N&iacute;vel: <input size="10px" type="text" name="reqLvl" id="reqLvl" value= ' . $row[10] . ' readonly>';
						if($row[11] != "")
							$html .= '<br>Desafio: <input size="90px" type="text" name="reqChal" id="reqChal" value="' . utf8_encode($row[11]) .'" readonly>';
						if($row[12] != "")
							$html .= '<br>Item: <input size="90px" type="text" name="reqItem" id="reqItem" value="' . utf8_encode($row[12]) . '" readonly>';
					}
					else{
						$html = '';
						$html .= ' Nenhum';
					}
					echo $html;

					$sql2 = mysqli_query($con, "SELECT ext, data FROM challenge WHERE id = '$mission_id'") or die(mysqli_error($con));
					while ($imagens = mysqli_fetch_array($sql2)){
							$dados['ext'] = $imagens['ext'];
							$dados['data'] = $imagens['data'];
					}
					$html2 .= '<tr><td><center><img src="../administrador/fotos_desafios/'.$dados['data']. '" width="250" height="210"/>';
					echo $html2;
					?>
					<div align="right">
					<input type="button" class="button" value="Editar" id="botao" onclick="location.href='db_edit_challenge.php?mission_id=<?php echo $row[0] ?>';">
					</div>
					
				</div>
			</div>
		</div>
	</body>
</html>
