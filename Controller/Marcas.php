<?php
if (session_id() == "")
{
	session_start();	
}

require_once (dirname(dirname(__FILE__))."/Engine/MarcasClass.php");
require_once(dirname(dirname(__FILE__))."/Engine/ArquivosClass.php");

if (isset($_POST['addSubmitted']))
{
	CadastraMarca();
}
else if (isset($_POST['altSubmitted']))
{
	if (isset($_POST['marcaID']))
	{
		AlteraMarca($_POST['marcaID']);	
	}
	else
	{
		header("location: ../marcas-admin.php?status=error");
	}
}
else if (isset($_POST['selData']))
{
	$id = $_POST['selData'];

	RemoveMarca($id);
}

// Listar todas as mracas
function ListaMarcas()
{
	$marcas = new Marcas();
	
	$lista = $marcas->CarregaMarcas();
	
	return $lista;
}

// Seleciona uma marca na sessão do usuário
function selecionaMarca($id)
{
	$marcas = new Marcas();
	
	$lista = $marcas->CarregaMarcas();
	
	$select = null;
	$n = count($lista);
	for ($i = 0; $i < $n; $i++)
	{
		if ($lista[$i]['id'] == $id)
		{
			$select = $lista[$i];
			break;
		}
	}
	
	if ($select != null)
	{
		$_SESSION['marca'] = $select;
	}
}

// Pega apenas uma marca, dado o ID, do banco de dados
function GetMarca($id)
{
	$marca = new Marcas();
	
	$result = $marca->GetMarcaByID($id);
	
	return $result;	
}

function GetMarcasByName($name)
{
	$marca = new Marcas();
	
	$result = $marca->GetMarcasByName($name);
	
	return $result;
}

// Remove a marca com o ID passado
function RemoveMarca($id)
{
	$marca = new Marcas();
	
	$m = GetMarca($id);
	$ret = Arquivos::RemoveFile("../" . $_SESSION['marcasImagePrefix'] . $m['imagem']);
	if ($ret == FALSE)
	{
		header("location: ../marcas-admin.php?status=error");
	}
	
	$result = $marca->RemoveMarca($id);
	
	if ($result == TRUE)
	{
		header("location: ../marcas-admin.php?status=success");	
	}
	else
	{
		header("location: ../marcas-admin.php?status=error");		
	}
	
	return;
}

// Cadastra uma nova marca
function CadastraMarca()
{
	$erro = Array();
    
    foreach ($_POST as $chv => $vlr) 
    {
        if($vlr == "" && substr($chv,0,3) == "MAR") 
        {
            $erro[] = "O campo " . substr($chv,4) . " não foi informado";
        }
    }
	
	$n = count($erro);
	if ($n > 0)
	{
		header("location: ../marcas-admin.php?status=error");
		return;
	}
	
	$marca = new Marcas();
	
	$_nome = $_POST['MAR_NOME'];
	$_file = $_FILES['MAR_FILE'];
		
	if ($_file["error"] > 0)
	{
		header("location: ../marcas-admin.php?status=error");
		return;
	}
	
	$_imagem = Arquivos::UpdateArquivo("../".$_SESSION['marcasImagePrefix'], $_file);
	
	$result = $marca->AdicionaMarca($_nome, $_imagem);
	
	if ($result == TRUE)
	{
		header("location: ../marcas-admin.php?status=success");	
	}
	else
	{
		header("location: ../marcas-admin.php?status=error");		
	}
	
	return;
}

// Altera uma marca com o ID passado
function AlteraMarca($id)
{
	$marca = new Marcas();
	
	$nome = null;
	$imagem = null;
	
	if (isset($_POST['MAR_NOME']))
	{
		$nome =  $_POST['MAR_NOME'];
	}
	
	if (isset($_FILES['MAR_FILE']) && $_FILES['MAR_FILE']['size'] > 0)
	{
		$_file = $_FILES['MAR_FILE'];
		if ($_file["error"] > 0)
		{
			header("location: ../marcas-admin.php?status=error");
			return;
		}
			
		$m = GetMarca($id);
		$ret = Arquivos::RemoveFile("../" . $_SESSION['marcasImagePrefix'] . $m['imagem']);

		if ($ret == FALSE)
		{
			header("location: ../marcas-admin.php?status=error");
			return;
		}
		
		$imagem = Arquivos::UpdateArquivo("../" . $_SESSION['marcasImagePrefix'], $_file);
	}

	$result = $marca->AlteraMarca($id, $nome, $imagem);
	
	if ($result == TRUE)
	{
		header("location: ../marcas-admin.php?status=success");	
	}
	else
	{
		header("location: ../marcas-admin.php?status=error");		
	}
	
	return;
}


?>