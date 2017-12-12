<?php
include "valida_secao.inc";

$id = $_SESSION["id"];
include "conecta_mysql.inc";

// ------ recebendo os dados cadastrais do problema ---------------->
$name = $_POST["name"];
$subject = $_POST["subject"];
$buyValue = $_POST["buyValue"];
$sellValue = $_POST["sellValue"];
$benType = $_POST["benType"];
$benValue = $_POST["benValue"];

//recebendo imagem
//Lendo o arquivo tempor?rio
if (!empty($_FILES['image']) ){

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
                                        $caminho_imagem = "fotos_armas/" . $nome_imagem;   

                                        // Faz o upload da imagem para seu respectivo caminho 
                                        move_uploaded_file($foto["tmp_name"], $caminho_imagem); 

 					$imgUp = mysqli_query($con, "INSERT INTO consumiveis (ext,data,name,quant,tipo,upload) VALUES ('$imgType','$nome_imagem','$name','$benValue','$benType','1')") or die(mysqli_error($con));                          

                                        if( !$imgUp )
                                            echo "erro ao carregar imagem!";
                                        else {
                                            mysqli_query($con, "INSERT INTO item (name,description,type,sale_value,buy_value,level_required,slot) VALUES ('$name','$subject','4','0','$buyValue','1','0')") or die(mysqli_error($con));
                                            mysqli_query($con, "SELECT * FROM item") or die(mysqli_error($con));
                                            echo $lastId = mysqli_affected_rows($con);

                                        }
    
                                    }
                                    else
                                        echo $error;
}

else
	echo "arquivo vazio";

header("Location: consumiveis.php");
	
//fechando conex?o	
mysqli_close($con);
?>
