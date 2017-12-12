<?php
include "valida_secao.inc";
include "conecta_mysql.inc";

echo "challenge: " . $challenge_id = $_GET["challenge_id"];
echo "id: " . $id = $_SESSION["id"];
echo "code: " . $code = $id . "_" . $challenge_id;
echo "fileName: " . $fileName = $code . ".cpp";
echo "id do usuário: " . $id . "<br>";
$energy = mysqli_query($con, "SELECT energy FROM characterr where user_id='$id'") or die(mysqli_error($con));
$row_e = mysqli_fetch_row($energy);
$answer = mysqli_query($con, "SELECT title,output,energy,bp FROM challenge where id='$challenge_id'") or die(mysqli_error($con));
$row = mysqli_fetch_row($answer);
$input_file = $row[0] . "_i.txt";
$output_file = $row[0] . "_o.txt";


/////////////////////////////////////////////////////////////////////////////////////
//                    Criando  o shell que testa a solução                         //
/////////////////////////////////////////////////////////////////////////////////////
echo "shell: " . $shell_x = "solucao" . $code . ".sh";
$solutionFile = "/opt/lampp/htdocs/projeto_piratas/aluno/solucoes_shell/" . $shell_x;
$content = "#!/bin/bash\n";
$content .= "g++ -lm -o main /opt/lampp/htdocs/projeto_piratas/aluno/solucoes/" . $fileName . "\n";
$content .= "./main";
$text = "$solutionFile";
echo "<br>" . $test;
$openFile = fopen($text, 'w');
fwrite($openFile, $content);
fclose($openFile);

echo "<br>Arquivo solução: ".$solutionFile;
echo "<br>SHELL: ".$shell_x;
/////////////////////////////////////////////////////////////////////////////////////
//                            Testando a solução		           	   //
/////////////////////////////////////////////////////////////////////////////////////

$output = shell_exec("sh ". $solutionFile);
echo "<br>";
var_dump($output);

$size = strlen($output);
$output = substr($output,0, $size-1);

echo "<br>SAÍDA: " . $output . " termina";
echo "<br>SAÍDA: " . $row[1] . " termina";

//verifica o nível do usuário (antes da atualização do xp), a quantidade de experiencia e energia
$sql = mysqli_query($con, "SELECT xp, lvl, energy FROM characterr WHERE user_id = '$id '") or die(mysqli_error($con));
$row_c = mysqli_fetch_row($sql);

//seleciona recompensas do desafio
$sql = mysqli_query($con, "SELECT xp, energy FROM challenge WHERE id = '$challenge_id'") or die(mysqli_error($con));
$row_m = mysqli_fetch_row($sql);

if ($row_c[2] < $row_m[1]){
   	mysqli_close($con);
   	header("Location: db_challenge_energy_fail.php");
}
else{
	
	if ($output != $row[1]) {
		echo "<br>falha";
		$sql = mysqli_query($con, "UPDATE characterr set energy = energy - $row_m[1] WHERE user_id = '$id'") or die(mysqli_error($con));
		mysqli_close($con); //mysqli_close("/opt/lampp/htdocs/projeto_piratas/aluno/solucoes_shell/" . $con);
		header('Location: db_fb_challenge_fail.php?id=' . $challenge_id . '');
	}
	else {
		echo "<br>Sucesso<br>";
		//Atualiza energia do usuário
	    
		if ( ($row_e[0] - $row[2]) <= 0 )
				mysqli_query($con, "UPDATE characterr SET energy = '0', xp = xp + $row_m[0] WHERE user_id = '$id' ") or die(mysqli_error($con));
		else
				mysqli_query($con, "UPDATE characterr SET energy = energy - $row_m[1], xp = xp + $row_m[0] WHERE user_id = '$id'") or die(mysqli_error($con));

		$exp = $row_m[0];

		//quantidade de linhas da tabela de níveis
		$sql = mysqli_query($con, "SELECT * FROM xp_lvl") or die(mysqli_error($con));
		$total = mysqli_affected_rows($con);

		//encontra o maximo xp do nivel atual do usuário
		$sql = mysqli_query($con, "SELECT xp_max FROM xp_lvl WHERE id = '$row_c[1]'") or die(mysqli_error($con));
		$xp_max = mysqli_fetch_row($sql);

		//maior nível
		$sql = mysqli_query($con, "SELECT id, xp_max FROM xp_lvl WHERE id = '$total'-1 ") or die(mysqli_error($con));
		$last_lvl = mysqli_fetch_array($sql);

		if ($row_c[0] <  $last_lvl[1]) {
			$new_xp = ($row_c[0] + $exp);
		
			//mostra uma mensagem ao usuário, caso não tenha passado de lvl
			if( $new_xp <= $xp_max[0]){
				//atualizando a experiência
				mysqli_query($con, "UPDATE characterr set xp = '$new_xp' WHERE user_id = '$id'") or die(mysqli_error($con));
			}
			//se ganhar mais experiência que o nível máximo
			elseif($new_xp >= $last_lvl[1]){
				//echo "<p>Parabéns! Você chegou ao nível máximo!</p>";
				//atualizando a experiência e o nível
				mysqli_query($con, "UPDATE characterr set xp = '$last_lvl[1]', lvl = '$last_lvl[0]' WHERE user_id = '$id'") or die(mysqli_error($con));
			}
		
			//senao, calcula qual será o próximo lvl
			else {
				$new_xp = ($row_c[0] + $exp);
				$new_lvl = ($row_c[1] + 1);
				//echo "<p>Parabéns! Você ganhou " . $exp . " de experencia e passou para o nível " . $current_lvl . ".</p>";
				//atualizando a experiência e o nível
				mysqli_query($con, "UPDATE characterr set xp = '$new_xp', lvl = '$new_lvl' WHERE user_id = '$id'") or die(mysqli_error($con));
			}
		}

		mysqli_query($con, "UPDATE characterr set bp = bp + '$row[3]' WHERE user_id = '$id'") or die(mysqli_error($con));
		//mysqli_query($con, "INSERT INTO challenge_overcome (user_id, challenge_id) VALUES ('$id','$challenge_id')") or die(mysqli_error($con));
		mysqli_close($con);

		shell_exec("cd opt/lampp/htdocs/projeto_piratas/aluno");
		shell_exec("rm main");

		header('Location: db_fb_challenge_success.php?id=' . $challenge_id . '');
	}
}
?>
