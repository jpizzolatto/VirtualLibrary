<?php
require_once(dirname(dirname(__FILE__))."/Engine/CategoriasClass.php");
require_once(dirname(dirname(__FILE__))."/Engine/ArquivosClass.php");

if (isset($_POST['addSubmitted']))
{
	CadastraCategoria();
}
else if (isset($_POST['altSubmitted']))
{
	if (isset($_POST['marcaID']))
	{
		AlteraCategoria($_POST['marcaID']);	
	}
	else
	{
		header("location: ../categorias.php?status=error");
	}
}
else if (isset($_POST['selData']))
{
	$id = $_POST['selData'];

	RemoveCategoria($id);
}

// Pega todas as categorias do banco de dados
function GetCategorias()
{
	$cat = new Categorias();
	
	$result = $cat->CarregaCategorias();
	
	return $result;	
}

function GetCategoriasByName($name)
{
	$cat = new Categorias();
	
	$result = $cat->GetCategoriasByName($name);
	
	
	return $result;
}

function selecionaCategoria($id)
{
	$categorias = new Categorias();
	
	$lista = $categorias->CarregaCategorias();
	
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
		$_SESSION['categoria'] = $select;
	}
}

// Pega a categoria com o ID especificado
function GetCategoria($id)
{
	$cat = new Categorias();
	
	$result = $cat->GetCategoriaByID($id);
	
	return $result;	
}

// Remove a categoria com o ID especificado
function RemoveCategoria($id)
{
	$cat = new Categorias();
	
	$grupo = GetCategoria($id);
	$ret = Arquivos::RemoveFile("../" . $_SESSION['categoriasImagePrefix'] . $grupo['imagem']);
	if ($ret == FALSE)
	{
		header("location: ../categorias.php?status=error");
	}
	
	$result = $cat->RemoveCategoria($id);
	
	if ($result == TRUE)
	{
		header("location: ../categorias.php?status=success");	
	}
	else
	{
		header("location: ../categorias.php?status=error");		
	}
	
	return;
}

// Cadastra uma nova categoria
function CadastraCategoria()
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
		header("location: ../categorias.php?status=error");
		return;
	}
	
	$cat = new Categorias();
	
	$_nome = $_POST['CAT_NOME'];
	$_file = $_FILES['CAT_FILE'];
	
	if ($_file["error"] > 0)
	{
		header("location: ../categorias.php?status=error");
		return;
	}
	
	$_imagem = Arquivos::UpdateArquivo("../" . $_SESSION['categoriasImagePrefix'], $_file);
	
	$result = $cat->AdicionaCategoria($_nome, $_imagem);
	
		if ($result == TRUE)
	{
		header("location: ../categorias.php?status=success");	
	}
	else
	{
		header("location: ../categorias.php?status=error");		
	}
	
	return;
}

// Altera a categoria com o ID especificado
function AlteraCategoria($id)
{
	$categoria = new Categorias();
	
	$nome = null;
	$imagem = null;
	
	if (isset($_POST['CAT_NOME']))
	{
		$nome =  $_POST['CAT_NOME'];
	}
	
	if (isset($_FILES['CAT_FILE']) && $_FILES['CAT_FILE']['size'] > 0)
	{
		$_file = $_FILES['CAT_FILE'];
		if ($_file["error"] > 0)
		{
			header("location: ../categorias.php?status=error");
			return;
		}
			
		$c = GetCategoria($id);
		if (file_exists("../" . $_SESSION['categoriasImagePrefix'] . $c['imagem']))
		{
			$ret = Arquivos::RemoveFile("../" . $_SESSION['categoriasImagePrefix'] . $c['imagem']);
	
			if ($ret == FALSE)
			{
				header("location: ../categorias.php?status=error");
				return;
			}
		}
		
		$imagem = Arquivos::UpdateArquivo("../" . $_SESSION['categoriasImagePrefix'], $_file);
	}

	$result = $categoria->AlteraCategoria($id, $nome, $imagem);
	
	if ($result == TRUE)
	{
		header("location: ../categorias.php?status=success");	
	}
	else
	{
		header("location: ../categorias.php?status=error");		
	}
	
	return;
}

?>