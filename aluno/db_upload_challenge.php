<?php
include "valida_secao.inc";
include "conecta_mysql.inc";

$challenge_id = $_POST["problema"];
$username = $_SESSION["nome_usuario"];
$id = $_SESSION["id"];

$fileName = $id . "_" . $challenge_id . ".cpp";

echo "Testeeeeee: ";
var_dump($fileName);
var_dump($_FILES["file"]["size"]);
var_dump($_FILES["file"]["error"]);
echo "<br>";

if ($_FILES["file"]["size"] < 20000) {
    if ($_FILES["file"]["error"] > 0) {
	echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
    } else {
	echo "Iniciando procedimento de solução...<br /><br />";
	echo "Carregando arquivos...<br />";
	echo "Upload: " . $_FILES["file"]["name"] . "<br />";
	echo "Type: " . $_FILES["file"]["type"] . "<br />";
	echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
	echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br />";

	if (file_exists("solucoes/" . $_FILES["file"]["name"])) {
	    echo $_FILES["file"]["name"] . " already exists. ";
	} else {
	    move_uploaded_file($_FILES["file"]["tmp_name"], "/opt/lampp/htdocs/projeto_piratas/aluno/solucoes/" . $_FILES["file"]["name"]);
	    echo "Arquivo armazenado em: " . "solucoes/" . $_FILES["file"]["name"];
	    echo "<br /><br />Realizando conversão...<br />";
	    $origin = "solucoes/" . $_FILES["file"]["name"];
	    $destination = 'solucoes/' . $fileName . '';
	    copy($origin, $destination);
	    echo "Arquivo renomeado para: " . $fileName;
	    echo "<br />Removendo arquivo original...";
	    unlink($origin);
	    echo "<br /><br />Arquivo removido!";
	}
    }
} else {
    echo "Invalid file";
}
header('Location: db_verify_challenge.php?challenge_id=' . $challenge_id . '');
?>
