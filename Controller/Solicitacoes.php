<?php

require_once (dirname(dirname(__FILE__))."/Engine/SolicitacaoClass.php");
require_once (dirname(dirname(__FILE__))."/Engine/ArquivosClass.php");
require_once ("Arquivos.php");
require_once ("Email.php");

if (session_id() == "")
{
	session_start();
}


if (isset($_POST['addSolicitacao']))
{
    $user = $_SESSION['usuario'];
    AdicionaSolicitacao($user->Id);
}
if (isset($_POST['addAlteracao']))
{
    $user = $_SESSION['usuario'];
	$arqID = $_POST['arquivoID'];
    AdicionaAlteracao($user->Id, $arqID);
}
if (isset($_POST['removeSolicitacao']))
{
	$id = $_POST['selData'];
	$msg = $_POST['rejectText'];

    RejeitaSolicitacao($id, $msg);
}
if (isset($_POST['aceitaSolicitacao']))
{
	$id = $_POST['selData2'];

    AceitaSolicitacao($id);
}

function GetSolicitacoes()
{
	$sol = new Solicitacao();

	$result = $sol->GetSolicitacoesAbertas();

	return $result;
}

function GetSolicitacao($id)
{
	$sol = new Solicitacao();

	$result = $sol->GetSolicitacaoByID($id);

	return $result;
}

function CreateTempPrefix($userID, $solID)
{
    return "../Temp/Usuario-" . $userID . "/ID-" . $solID . "/";
}

function AdicionaSolicitacao($userID)
{
    $sol = new Solicitacao();

    $perguntas = "";
    // Pega as perguntas enviadas
    if (isset($_POST['pergunta1']) && $_POST['pergunta1'] != "")
    {
        $perguntas .= $_POST['pergunta1'];
        $perguntas .= ",";
    }
    if (isset($_POST['pergunta2']) && $_POST['pergunta2'] != "")
    {
        $perguntas .= $_POST['pergunta2'];
        $perguntas .= ",";
    }
    if (isset($_POST['pergunta3']) && $_POST['pergunta3'] != "")
    {
        $perguntas .= $_POST['pergunta3'];
        $perguntas .= ",";
    }
    if (isset($_POST['pergunta4']) && $_POST['pergunta4'] != "")
    {
        $perguntas .= $_POST['pergunta4'];
        $perguntas .= ",";
    }
    if (isset($_POST['pergunta5']) && $_POST['pergunta5'] != "")
    {
        $perguntas .= $_POST['pergunta5'];
        $perguntas .= ",";
    }
    if ($perguntas !=  "")
    {
         // Remove a virgula do final
        $perguntas = substr_replace($perguntas, "", -1);
    }

	$file1 = $_FILES['tempFile1'];
	$file2 = $_FILES['tempFile2'];
	$file3 = $_FILES['tempFile3'];

    $id = $sol->AdicionarSolicitacao($userID, $perguntas, null);

    // Pega os arquivos enviados, e armazena em uma pasta temporária.
    $prefix = CreateTempPrefix($userID, $id);

	$caminho = "";
    // Pegar arquivos
    if (isset($file1) && $file1['size'] > 0)
	{
		$img1 = Arquivos::UpdateArquivo($prefix, $file1);
		$img1 = $prefix . $img1;
		$caminho .= $img1 . ',';
	}
	if (isset($file2) && $file2['size'] > 0)
	{
		$img2 = Arquivos::UpdateArquivo($prefix, $file2);
		$img2 = $prefix . $img2;
		$caminho .= $img2 . ',';
	}
	if (isset($file3) && $file3['size'] > 0)
	{
		$img3 = Arquivos::UpdateArquivo($prefix, $file3);
		$img3 = $prefix . $img3;
		$caminho .= $img3 . ',';
	}
	iF ($caminho != "")
	{
		$caminho = substr_replace($caminho, "", -1);
	}

    // Alterar entrada no banco de dados com os caminhos dos arquivos
    $ret = $sol->AdicionarCaminhosSolicitacao($id, $caminho);

	if ($ret)
	{
		header("location: ../home.php?solicitacao=1");
	}
	else
	{
		header("location: ../home.php?solicitacao=0");
	}


}

function AdicionaAlteracao($userID, $arquivoID)
{
    $sol = new Solicitacao();

    $perguntas = "";
    // Pega as perguntas enviadas
    if (isset($_POST['pergunta1']) && $_POST['pergunta1'] != "")
    {
        $perguntas .= $_POST['pergunta1'];
        $perguntas .= ",";
    }
    if (isset($_POST['pergunta2']) && $_POST['pergunta2'] != "")
    {
        $perguntas .= $_POST['pergunta2'];
        $perguntas .= ",";
    }
    if (isset($_POST['pergunta3']) && $_POST['pergunta3'] != "")
    {
        $perguntas .= $_POST['pergunta3'];
        $perguntas .= ",";
    }
    if (isset($_POST['pergunta4']) && $_POST['pergunta4'] != "")
    {
        $perguntas .= $_POST['pergunta4'];
        $perguntas .= ",";
    }
    if (isset($_POST['pergunta5']) && $_POST['pergunta5'] != "")
    {
        $perguntas .= $_POST['pergunta5'];
        $perguntas .= ",";
    }
    if ($perguntas !=  "")
    {
         // Remove a virgula do final
        $perguntas = substr_replace($perguntas, "", -1);
    }

	$file1 = $_FILES['tempFile1'];
	$file2 = $_FILES['tempFile2'];
	$file3 = $_FILES['tempFile3'];

    $id = $sol->AdicionarAlteracao($userID, $perguntas, null, $arquivoID);

	 // Pega os arquivos enviados, e armazena em uma pasta temporária.
    $prefix = CreateTempPrefix($userID, $id);

	$caminho = "";
    // Pegar arquivos
    if (isset($file1) && $file1['size'] > 0)
	{
		$img1 = Arquivos::UpdateArquivo($prefix, $file1);
		$img1 = $prefix . $img1;
		$caminho .= $img1 . ',';
	}
	if (isset($file2) && $file2['size'] > 0)
	{
		$img2 = Arquivos::UpdateArquivo($prefix, $file2);
		$img2 = $prefix . $img2;
		$caminho .= $img2 . ',';
	}
	if (isset($file3) && $file3['size'] > 0)
	{
		$img3 = Arquivos::UpdateArquivo($prefix, $file3);
		$img3 = $prefix . $img3;
		$caminho .= $img3 . ',';
	}
	iF ($caminho != "")
	{
		$caminho = substr_replace($caminho, "", -1);
	}

    // Alterar entrada no banco de dados com os caminhos dos arquivos
    $ret = $sol->AdicionarCaminhosSolicitacao($id, $caminho);

	if ($ret)
	{
		header("location: ../home.php?solicitacao=1");
	}
	else
	{
		header("location: ../home.php?solicitacao=0");
	}
}

function RemoveSolicitacao($id)
{
	$selSol = GetSolicitacao($id);

	$sol = new Solicitacao();

	$ret = $sol->RemoverSolicitacao($id);

	return $ret;
}

function RejeitaSolicitacao($id, $msg)
{
	$selSol = GetSolicitacao($id);
	$userID = $selSol['usuario'];
	$user = GetUsuarioByID($userID);

	$sol = new Solicitacao();

	$ret = $sol->RemoverSolicitacao($id);

	$assunto = "Su solicitud fue rechazada";
	if ($msg == "")
	{
		$msg = "No hay razón ha sido ingresada por el administrador.";
	}

	EnviarEmailToUser($user['email'], $user['nome'], $assunto, $msg);

	return $ret;
}

function AceitaSolicitacao($id)
{
	$selSol = GetSolicitacao($id);
	$userID = $selSol['usuario'];
	$user = GetUsuarioByID($userID);

	$sol = new Solicitacao();

	$ret = $sol->AlteraEstadoSolicitacao($id, "OK");

	$assunto = "Su solicitud fue aceptada!";
	$msg = "Su solicitud fue aceptada, y estará disponible tan pronto como sea posible en nuestro sistema.";

	EnviarEmailToUser($user['email'], $user['nome'], $assunto, $msg);

	return $ret;
}



?>