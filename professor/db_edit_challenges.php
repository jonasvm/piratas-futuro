<?php
include "valida_secao.inc";

//recebendo os dados
// ------ recebendo os dados cadastrais do problema ---------------->
$titulo_problema = $_POST["titulo_problema"];
$nivel = $_POST["nivel"];
$energia = $_POST["energia"];
$resumo = $_POST["resumo"];
$entrada = $_POST["entrada"];
$saida = $_POST["saida"];
$xp = $_POST["xp"];
$bp = $_POST["bp"];
$location = $_POST["location"];
$req_lvl = '';
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
                        $caminho_imagem = "/opt/lampp/htdocs/projeto_piratas/administrador/fotos_desafios/" . $nome_imagem;   

                        // Faz o upload da imagem para seu respectivo caminho 
                        move_uploaded_file($foto["tmp_name"], $caminho_imagem); 
                        
			mysqli_query($con, " INSERT INTO challenge (title, level, energy, abstract, input, output, xp, bp, location, req_lvl, req_chal, req_equip, data, ext) values ('$titulo_problema','$nivel','$energia','$resumo','$entrada','$saida','$xp','$bp','$location','$req_lvl','$req_chal','$req_equip','$nome_imagem','$imgType') ") or die(mysqli_error($con));
                     
                                        
		}
        	else
        		echo $error;
	}
	else{
		mysqli_query($con, " INSERT INTO challenge (title, level, energy, abstract, input, output, xp, bp, location, req_lvl, req_chal, req_equip) values ('$titulo_problema','$nivel','$energia','$resumo','$entrada','$saida','$xp','$bp','$location','$req_lvl','$req_chal','$req_equip') ") or die(mysqli_error($con));
	}



//fechando conexão	
mysqli_close($con);

$arquivo = "entradas/" . $titulo_problema . "_e.txt";
$conteudo = $entrada;
$texto = "$arquivo";
$abrearquivo = fopen($texto, 'w');
fwrite($abrearquivo, $conteudo);
fclose($abrearquivo);

$arquivo = "saidas/" . $titulo_problema . "_s.txt";
$conteudo = $saida;
$texto = "$arquivo";
$abrearquivo = fopen($texto, 'w');
fwrite($abrearquivo, $conteudo);
fclose($abrearquivo);

echo "<html><body>";
echo "<p>Problema cadastrado com sucesso.</p>";
echo "<p><a href=missions.php>Continuar</a></p>";
echo "</body></html>";
?>	



