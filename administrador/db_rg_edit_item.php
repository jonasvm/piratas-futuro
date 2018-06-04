<?php
include "valida_secao.inc";

//recebendo os dados
// ------ recebendo os dados cadastrais do item ---------------->
$item_id = $_POST["item_id"];
$type = $_POST["item_type"];
$old_name = $_POST["old_name"];

$name = $_POST["title"];
$subject = $_POST["subject"];
$buyValue = $_POST["buyValue"];
$sellValue = $_POST["sellValue"];
$levelReq = $_POST["levelReq"];
$benValue = $_POST["benValue"];
$benType = $_POST["benType"];

//acesso ao bd
include "conecta_mysql.inc";

if(is_uploaded_file($_FILES['image']['tmp_name'])) {
if (!empty($_FILES["image"])){
echo "aqui";

 

	$foto = $_FILES["image"];
	$erro=0;
        $error="";

        // Verifica se o arquivo é uma imagem 

        if(!preg_match("/^image\/(pjpeg|jpeg|png|gif|bmp)$/", $foto["type"])){ 
           $error = "Isso não é uma imagem.";
           $erro = 1;
	   echo $foto["type"];
        }
        // Pega as dimensões da imagem 
        //$dimensoes = getimagesize($foto);   
	echo "$erro";
	// Se não houver nenhum erro 
        if ($erro == 0) {

		// Pega extensão da imagem 
		preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $foto["name"], $ext);   

		// Gera um nome único para a imagem 
		$nome_imagem = md5(uniqid(time())) . "." . $ext[1];   

		// Caminho de onde ficará a imagem 
		$caminho_imagem = "fotos_armas/" . $nome_imagem;   

		if(isset($_POST["submit"]) && isset($_FILES['file'])) {
    			$file_temp = $_FILES['file']['tmp_name'];   
    			$info = getimagesize($file_temp);
		}
		// Faz o upload da imagem para seu respectivo caminho 
		move_uploaded_file($foto["tmp_name"], $caminho_imagem); 
		                          
	    
	    
	    
		if($type == 1)
			$imgUp = mysqli_query($con, "UPDATE armas_de_fogo SET ext = '$ext[1]', data = '$nome_imagem', name = '$name' WHERE name = '$old_name' ") or die(mysqli_error($con));
		else if($type == 2)
			$imgUp = mysqli_query($con, "UPDATE armas_brancas SET ext = '$ext[1]', data = '$nome_imagem', name = '$name' WHERE name = '$old_name' ") or die(mysqli_error($con));
		else if($type == 3)
			$imgUp = mysqli_query($con, "UPDATE armaduras SET ext = '$ext[1]', data = '$nome_imagem', name = '$name' WHERE name = '$old_name' ") or die(mysqli_error($con));
		else
			$imgUp = mysqli_query($con, "UPDATE consumiveis SET ext = '$ext[1]', data = '$nome_imagem', name = '$name', quant = '$benValue', tipo = '$benType' WHERE name = '$old_name' ") or die(mysqli_error($con));

		 		
		        
		        
		if( !$imgUp )
			echo "Erro ao carregar imagem";
		else {
			$result = mysqli_query($con, "UPDATE item SET name = '$name', description = '$subject', sale_value = '$sellValue', buy_value = '$buyValue', level_required = '$levelReq' WHERE id = '$item_id' ") or die(mysqli_error($con));
			if($result)
				echo "Sucesso ao editar Item (Imagem editada)";
			else
				echo "Erro ao editar Item (Imagem editada)";
		}
	}
	else
        	echo $error;
}
}
else
{
    echo "yo";
    echo $name;
    echo $old_name;
    //exit(1);
    
	if($type == 1)
		$imgUp = mysqli_query($con, "UPDATE armas_de_fogo SET name = '$name' WHERE name = '$old_name' ") or die(mysqli_error($con));
	else if($type == 2)
		$imgUp = mysqli_query($con, "UPDATE armas_brancas SET name = '$name' WHERE name = '$old_name' ") or die(mysqli_error($con));
	else if($type == 3)
		$imgUp = mysqli_query($con, "UPDATE armaduras SET name = '$name' WHERE name = '$old_name' ") or die(mysqli_error($con));
	else
		$imgUp = mysqli_query($con, "UPDATE consumiveis SET name = '$name' WHERE name = '$old_name' ") or die(mysqli_error($con));

	if( !$imgUp )
		echo "Erro ao carregar imagem";
	else {
		$result = mysqli_query($con, "UPDATE item SET name = '$name', description = '$subject', sale_value = '$sellValue', buy_value = '$buyValue', level_required = '$levelReq' WHERE id = '$item_id' ") or die(mysqli_error($con));
		$resultB = mysqli_query($con, "UPDATE benefit SET value = '$benValue', field_sheet = '$benType' WHERE id = '$item_id' ") or die(mysqli_error($con));
		
		if($result && $resultB)
			echo "Sucesso ao editar Item (Imagem n&atilde;o editada)";
		else
			echo "Erro ao editar Item (Imagem n&atilde;o editada)";
	}
}

if($type == 1)
	header("Location: armas_de_fogo.php");
elseif($type == 2)
	header("Location: index_store.php");
elseif($type == 3)
	header("Location: armaduras.php");
else
	header("Location: consumiveis.php");
	

//fechando conex&atilde;o	
mysqli_close($con);


?>
