<?php

session_start();
require_once("Usuarios.php");

if (isset($_POST['respondeSol']))
{
	$solID = $_POST['selectedSol'];
	$userId = $_POST['sendUserID'];
	$sendUser = GetUsuarioByID($userId);
	
	$assunto = $_POST['assuntoEmail'];
	$msg = $_POST['msgEmail'];
	
	$ret = EnviarEmailToUser($sendUser['email'], $sendUser['nome'], $assunto, $msg);
	
	if ($ret)
		header("location: ../responder-solicitacao.php?id=".$solID."&status=success");
	else
		header("location: ../responder-solicitacao.php?id=".$solID."&status=error");
}

if (isset($_POST['contatarAdmin']))
{
	$userId = $_POST['userID'];
	$user = GetUsuarioByID($userId);
	
	$assunto = $_POST['assuntoEmail'];
	$msg = $_POST['msgEmail'];
	
	$ret = EnviarEmailToAdmin($user['email'], $user['nome'], $assunto, $msg);
	
	if ($ret)
		header("location: ../contato.php?status=success");
	else
		header("location: ../contato.php?status=error");
}

// Função para enviar email a um usuário
function EnviarEmailToUser($email, $nome, $assunto, $msg)
{
	$para = $email;
	$nome = $nome;
	$assunto = $assunto;	
	
	//4 – Agora definimos a  mensagem que vai ser enviado no e-mail
	$msg = str_replace("\n.", "\n..", $msg);
	$mensagem = $msg;
	
	$admin = GetAdminUser();
	if ($admin == null)
	{
		return FALSE;
	}
	
	$headers = "From: ". $admin['nome'] ."<". $admin['email'] .">\n";
	$emailsender = $admin['email'];
	
	$ret = mail($para, $assunto, $mensagem, $headers ,"-r".$emailsender);
	if(!$ret)
	{
    	$headers .= "Return-Path: " . $emailsender . "\n"; // Se "não for Postfix"
    	$ret = mail($para, $assunto, $mensagem, $headers );
	}
	
	return $ret;
}

// Função para enviar email de um usuário para o administrador
function EnviarEmailToAdmin($email, $nome, $assunto, $msg)
{
	$admin = GetAdminUser();
	if ($admin == null)
	{
		return FALSE;
	}
	
	$para = $admin['email'];
	
	$msg = str_replace("\n.", "\n..", $msg);
	// $mensagem = "Mensagem enviada pelo usuário <b>$nome <$email></b>\n\n";
	$mensagem = $msg;
	
	$headers = "From: ". $nome ."<". $admin['email'] .">\n";
	$emailsender = $admin['email'];

	$ret = mail($para, $assunto, $mensagem, $headers ,"-r".$emailsender);
	if(!$ret)
	{
    	$headers .= "Return-Path: " . $emailsender . "\n"; // Se "não for Postfix"
    	$ret = mail($para, $assunto, $mensagem, $headers );
	}
	
	return $ret;
}
?>
