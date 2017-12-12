<?php
	//recebendo os dados cadastrais do problema 
	$title = $_POST["title"];
	$energy = $_POST["energy"];
	$subject = $_POST["subject"];
	$input = $_POST["input"];
	$output = $_POST["output"];
	$xp = $_POST["xp"];
	$bp = $_POST["bp"];
	$location = $_POST["location"];
	$req_lvl = 0; // '' level modificado para 0
	$req_chal = '';
	$req_equip = '';	

	//acesso ao bd
	include "conecta_mysql.inc";

	// Verifica se foi selecionado algum requerimento
	if(isset($_POST["requeriments"])) {
		foreach($_POST["requeriments"] as $key => $value) {
			if($value == "lvl")
				$req_lvl = $_POST["label_req_lvl"];
			else if($value == "chal")
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
                        
                        mysqli_query($con, "INSERT INTO challenge (title,level,energy,abstract,input,output,xp,bp,location,req_lvl,req_chal,req_equip,data,ext) values ('$title','$location','$energy','$subject','$input','$output','$xp','$bp','$location','$req_lvl','$req_chal','$req_equip','$nome_imagem','$imgType')") or die(mysqli_error($con));
                     
                                        
		}
        	else
        		echo $error;
	}
	else
		mysqli_query($con, "INSERT INTO challenge (title,level,energy,abstract,input,output,xp,bp,location,req_lvl,req_chal,req_equip) values ('$title','$location','$energy','$subject','$input','$output','$xp','$bp','$location','$req_lvl','$req_chal','$req_equip')") or die(mysqli_error($con));
	//fechando conexão	
	mysqli_close($con);

	header("Location: index.php");

?>
