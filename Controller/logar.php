<?php
    include (dirname(dirname(__FILE__))."/Engine/UsuariosClass.php");

	$usuario = $_POST['inputLogin'];
	$senha = md5(sha1($_POST['inputSenha']));

	if (!isset($_POST['inputLogin']) || !isset($_POST['inputSenha']))
	{
	    $mensagem = "Usuário ou senha não foram definidos.";
	    header ('location:../index.php?error=' . $mensagem);
    }

    $user = new Usuarios();
    $result = $user->ValidaLogin($usuario, $senha);

	if ($result == TRUE)
	{
        header ('location:../home.php');
    }
	else
	{
		$mensagem = "Usuário ou senha inválido(s).";
        header ('location:../index.php?error=' . $mensagem);
    }
?>
