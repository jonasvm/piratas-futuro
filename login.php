<?php 
//obtendo os dados do usuário
$username = $_POST["username"];
$senha = $_POST["senha"];

//acesso ao bd
include "conecta_mysql.inc";
$resultado = mysqli_query($con, "SELECT username,password,id,type FROM user where username='$username'") or die(mysqli_error($con));
$linhas = mysqli_num_rows($resultado);
$row=mysqli_fetch_array($resultado);
$id = $row['id'];
$tipo = $row['type'];
$senha_user = $row['password'];

if($linhas == 0)
{
	header("Location: fb_user_not_found.php");
}else{
	if($senha != $senha_user)
	{
		header("Location: fb_incorrect_password.php");	
	}
	else{
		session_start();
		$_SESSION["nome_usuario"] = $username;
		$_SESSION["senha_usuario"] = $senha;
		$_SESSION["id"] = $id;
		$_SESSION["tipo"] = $tipo;
		$_SESSION["location"] = 1;
		//Decide a página que o usuário vai ser redirecionado ao logar
		$result = mysqli_query($con, "SELECT * FROM characterr WHERE user_id ='$id'");
		$linha = mysqli_num_rows($result);
		if($linha == 0)
		{
			mysqli_close($con);
			header("Location: inicio.php");
		}
		if($tipo == 3){
		     header("Location: aluno/index.php");
		}
		if($tipo == 2){
		     header("Location: professor/index.php");
		}
		if($tipo == 1){
		     header("Location: administrador/index.php");
		}
	}
}
mysqli_close($con);
?>
