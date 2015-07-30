<?php

require_once (dirname(dirname(__FILE__))."/Engine/UsuariosClass.php");

if (isset($_POST['addSubmitted']))
{
	CadastraUsuario();
}
else if (isset($_POST['altSubmitted']))
{
	if (isset($_POST['marcaID']))
	{
		AlteraUsuario($_POST['marcaID']);	
	}
	else
	{
		header("location: ../usuarios.php?status=error");
	}
}
else if (isset($_POST['selData']))
{
	$id = $_POST['selData'];

	RemoveUser($id);
}

// Pega todos os usuarios do banco de dados
function GetUsuarios()
{
	$user = new Usuarios();
	
	$result = $user->ListaUsuarios();
	
	return $result;
}

// Pega apenas o usuario com o ID passado
function GetUsuarioByID($id)
{
	$user = new Usuarios();
	
	$result = $user->GetUsuarioByID($id);
	
	return $result;
}

function GetAdminUser()
{
	$user = new Usuarios();
	
	$result = $user->GetAdminUser();
	
	return $result;
}

// Remove usuario com o ID passado
function RemoveUser($id)
{
	$user = new Usuarios();
	
	$result = $user->RemoveUsuario($id);
	
	if ($result == TRUE)
	{
		header("location: ../usuarios.php?status=success");	
	}
	else
	{
		header("location: ../usuarios.php?status=error");		
	}
	
	return;
}

// Cadastra um novo usuario
function CadastraUsuario()
{
    $erro = Array();
    
    foreach ($_POST as $chv => $vlr) 
    {
        if($vlr == "" && substr($chv,0,3) == "USR") 
        {
            $erro[] = "O campo " . substr($chv,4) . " não foi informado";
        }
    }
	
	$n = count($erro);
	if ($n > 0)
	{
		header("location: ../usuarios.php?status=error");
		return;
	}
	
	$user = new Usuarios();
	
	$_nome = $_POST['USR_NAME'];
	$_login = $_POST['USR_LOGIN'];
	$_grupo = $_POST['USR_GRUPO'];
	$_email = $_POST['USR_MAIL'];
	
	// Criar senha
	$_senha = $_login . "123";
	
	// TODO:  Verificar se o login já existe!
	
	$result = $user->AdicionaUsuario($_nome, $_login, $_senha, $_grupo, $_email);
	
	if ($result == TRUE)
	{
		header("location: ../usuarios.php?status=success");	
	}
	else
	{
		header("location: ../usuarios.php?status=error");		
	}
	
	return;
}

// Altera o usuario com o ID passado
function AlteraUsuario($id)
{
	$user = new Usuarios();
	
	$_nome = null;
	$_login = null;
	$_grupo = null;
	$_email = null;
	
	if (isset($_POST['USR_NAME']))
	{
		$_nome = $_POST['USR_NAME'];	
	}
	if (isset($_POST['USR_GRUPO']))
	{
		$_grupo = $_POST['USR_GRUPO'];	
	}
	if (isset($_POST['USR_MAIL']))
	{
		$_email = $_POST['USR_MAIL'];	
	}
	
	$result = $user->AlteraUsuario($id, $_nome, $_email, $_grupo);
	
	if ($result == TRUE)
	{
		header("location: ../usuarios.php?status=success");	
	}
	else
	{
		header("location: ../usuarios.php?status=error");		
	}
	
	return;
}

?>