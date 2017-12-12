<?php
include "valida_secao.inc";
include "conecta_mysql.inc";

$id = $_SESSION["id"];

if(isset($_GET["chal"]))
{
	$chal = $_GET["chal"];
	
	$sql2 = mysqli_query($con, "SELECT name FROM item WHERE id='$chal'") or die(mysqli_error($con));
	$rowName =  mysqli_fetch_array($sql2);
	
	$deleteChal1 = mysqli_query ($con, "DELETE FROM item WHERE id = '$chal'") or die(mysqli_error($con));//sem parametro
	$deleteChal2 = mysqli_query ($con, "DELETE FROM consumiveis WHERE name = '$rowName[0]'") or die(mysqli_error($con));

	if($deleteChal1 && $deleteChal2)
		echo '<script type="text/javascript"> alert("Item excluído com sucesso!"); </script>';
	else
		echo '<script type="text/javascript"> alert("Falha ao excluir Item."); </script>';
}
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
		<script>
		function Deletar(titulo, id)
		{
			if (confirm("Deseja deletar \n" + titulo + " ?")) {
				window.location = 'consumiveis.php?chal=' + id;
			}
		}
		</script>
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
				<h2 class="title">Loja</h2>	

				<input type="button" class="button" value="Cadastrar Item" id="botao" onclick="location.href='db_rg_cons.php';">		
				 <?php
				include "conecta_mysql.inc";
				
				$html = '';
				$html .= '<ul class="menuhorizontal">';
				$html .= '<li><a href="index_store.php">Armas Brancas</a></li>';
				$html .= '<li><a href="armas_de_fogo.php">Armas de Fogo</a></li>';
				$html .= '<li><a href="armaduras.php">Armaduras</a></li>';
				$html .= '<li class="selected"><a href="consumiveis.php">Consumíveis</a></li>';
				$html .= '</ul>';
				$html .= '<table class="tableStore" border="0" width="1200">';
				$html .= '<tr class="atrB"><td><b>Imagem</b></td><td><b>Item</b></td>';
				$html .= '<td><b>Informa&ccedil;&otilde;es</b></td><td><b>N&iacute;vel</b></td><td><b>Pre&ccedil;o</b></td><td><b>Editar</b></td><td><b>Excluir</b></td></tr>';
				$sql = mysqli_query($con, "SELECT level_required,name,description,id,buy_value,slot,sale_value FROM item WHERE type='4' ORDER BY level_required") or die(mysqli_error($con));
				
				while ($row2 = mysqli_fetch_assoc($sql))
				{
					$name = $row2['name'];
					$item_id = $row2['id'];
					
					$sql2 = mysqli_query($con, "SELECT ext, data, upload FROM consumiveis WHERE name='$name'") or die(mysqli_error($con));
					
					while ($imagens = mysqli_fetch_array($sql2)){
						$dados['ext'] = $imagens['ext'];
						$dados['data'] = $imagens['data'];
						$dados['upload'] = $imagens['upload'];
					}
						
						if($dados['upload'] == 0)
							$html .= '<tr class="atrV"><td><center><img src="data:image/' . $dados['ext'] . ';base64,' . base64_encode( $dados['data'] ) . '" width="92" height="102"/>' . '</td><td><center>' . utf8_encode($row2['name']) . '</td><td><center>Descri&ccedil;&atilde;o: ' . utf8_encode($row2['description']) . '</td><td><center>' . $row2['level_required'] . '</td>';
						else
							$html .= '<tr class="atrV"><td><center><img src="fotos_armas/'.$dados['data']. '" width="92" height="102"/>' . '</td><td><center>' . utf8_encode($row2['name']) . '</td><td><center>Descri&ccedil;&atilde;o: ' . utf8_encode($row2['description']) . '</td><td><center>' . $row2['level_required'] . '</td>';
						$html .= '<td><center>Compra: ' . $row2['buy_value'] . ' Battle Points <br />';
						$html .= '<center>Venda: ' . $row2['sale_value'] . ' Battle Points <br /></td><td><a href="db_edit_item.php?item_id=' . $row2['id'] . '&item_type=4">';
						$html .= '<img src="images/edit icon.png" width="30" height="30" title="Editar"/></a></td><td><a href="#"><img src="images/delete icon.png" width="30" height="30" title="Excluir" onclick="Deletar(\''.$row2['name'].'\', '.$row2['id'].')"/></a></td></tr>';
						
				}
				$html .= '</table>';
				echo $html;
				$id = $_SESSION["id"];
				$sql = mysqli_query($con, 'SELECT money FROM characterr as p, user as u WHERE p.user_id = u.id AND u.id = ' . $id . '') or die(mysqli_error($con));
				$row = mysqli_fetch_row($sql);
				mysqli_close($con);
				?><br>
				</div>
		</div>
	</body>
</html>

