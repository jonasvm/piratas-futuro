<?php
include "valida_secao.inc";

$id = $_SESSION["id"];
include "conecta_mysql.inc";

// ------ recebendo os dados cadastrais do problema ---------------->
$type = $_POST["itype"];
$equip = $_POST["slot"];
$name = $_POST["name"];
$subject = $_POST["subject"];
$buyValue = $_POST["buyValue"];
$sellValue = $_POST["sellValue"];
$levelReq = $_POST["levelReq"];
$slot = $_POST["slot"];
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
                                        
                                        
                                        
                                        
                                        if($type == 1)
                                            $imgUp = mysqli_query($con, "INSERT INTO armas_de_fogo (ext,data,name,upload) VALUES ('$imgType','$nome_imagem','$name','1')") or die(mysqli_error($con));
                                        else if($type == 2)
                                            $imgUp = mysqli_query($con, "INSERT INTO armas_brancas (ext,data,name,upload) VALUES ('$imgType','$nome_imagem','$name','1')") or die(mysqli_error($con));
                                        else if($type == 3)
                                            $imgUp = mysqli_query($con, "INSERT INTO armaduras (ext,data,name,upload) VALUES ('$imgType','$nome_imagem','$name','1')") or die(mysqli_error($con));

                                        if( !$imgUp )
                                            echo "erro ao carregar imagem!";
                                        else {
                                            mysqli_query($con, "INSERT INTO item (name,description,type,sale_value,buy_value,level_required,slot) VALUES ('$name','$subject','$type','$sellValue','$buyValue','$levelReq','$slot')") or die(mysqli_error($con));
                                            mysqli_query($con, "SELECT * FROM item") or die(mysqli_error($con));
                                            echo $lastId = mysqli_affected_rows($con);

                                            $ok1 = mysqli_query($con, "INSERT INTO benefit_item (item_id, benefit_id) VALUES ('$lastId','$benType')") or die(mysqli_error($con));
                                            $ok2 = mysqli_query($con, "INSERT INTO benefit (operator,value,field_sheet) VALUES (1,'$benValue','$benType')") or die(mysqli_error($con));

                                            if($ok1 && $ok2)
                                                echo "imagem carregada com sucesso";
                                            else
                                                echo "falha";
                                        }
                                        
											
										
                                            
    
    
                                    }
                                    else
                                        echo $error;
}

else
	echo "arquivo vazio";

if($type == 1)
	header("Location: armas_de_fogo.php");
elseif($type == 2)
	header("Location: index_store.php");
else
	header("Location: armaduras.php");
	
//fechando conex?o	
mysqli_close($con);
?>
