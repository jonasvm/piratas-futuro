<?php
include "valida_secao.inc";

$id = $_SESSION["id"];
$mission_id = $_POST["mission_id"];
echo "missao" . $mission_id;
$title = $_POST["title"];
$energy = $_POST["energy"];
$subject = $_POST["subject"];
$input = $_POST["input"];
$output = $_POST["output"];
$xp = $_POST["xp"];
$bp = $_POST["bp"];
$location = $_POST["location"];
$req_chal = '';
$req_equip = '';

//acesso ao bd
include "conecta_mysql.inc";

// Verifica se foi selecionado algum requerimento
if(isset($_POST["requeriments"])) {
	foreach($_POST["requeriments"] as $key => $value) {
		if($value == "chal")
			$req_chal = $_POST["label_req_chal"];
		else if($value == "equip")
			$req_equip = $_POST["label_req_equip"];
	}
}

if (!empty($_FILES["image"]) ){
		$foto = $_FILES["image"];
		$erro=0;
                $error="";
		
                // Verifica se o arquivo é uma imagem 
		if(!preg_match("/^image\/(pjpeg|jpeg|png|gif|bmp)$/", $foto["type"])){ 
                	$error = "Isso não é uma imagem.";
                        $erro = 1;
                }

                // Pega as dimensões da imagem 
                $dimensoes = getimagesize($foto["tmp_name"]);

		// Se não houver nenhum erro 
		if ($erro == 0) {
			// Pega extensão da imagem 
                        preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $foto["name"], $ext);   

                        // Gera um nome único para a imagem 
                        $nome_imagem = md5(uniqid(time())) . "." . $ext[1];   

                        // Caminho de onde ficará a imagem 
                        $caminho_imagem = "fotos_desafios/" . $nome_imagem;   

                        // Faz o upload da imagem para seu respectivo caminho 
                        move_uploaded_file($foto["tmp_name"], $caminho_imagem); 
                        mysqli_query($con, "UPDATE challenge SET title = '$title', level = '$location', energy = '$energy', abstract = '$subject', input = '$input', output = '$output', xp = '$xp', bp = '$bp', location = '$location', req_chal = '$req_chal', req_equip = '$req_equip', data = '$nome_imagem', ext = '$imgType' WHERE id='$mission_id' ") or die(mysqli_error($con));
                     
                                        
		}
        	else
        		echo $error;
	}
	
	$sql = mysqli_query($con, "UPDATE challenge SET title = '$title', level = '$location', energy = '$energy', abstract = '$subject', input = '$input', output = '$output', xp = '$xp', bp = '$bp', location = '$location', req_chal = '$req_chal', req_equip = '$req_equip' WHERE id='$mission_id' ") or die(mysqli_error($con));
	
header("Location: db_detail_challenge.php?mission_id=" .$mission_id);

//fechando conex&atilde;o	
mysqli_close($con);
?>
