<?php
require_once(dirname(dirname(__FILE__))."/Engine/CategoriasClass.php");
require_once(dirname(dirname(__FILE__))."/Engine/ArquivosClass.php");
require_once(dirname(dirname(__FILE__))."/Engine/PastasClass.php");
require_once(dirname(dirname(__FILE__))."/Engine/MarcasClass.php");


//
// TESTES PARA ALBUNS
//
if (isset($_POST['addAlbumBool']))
{
	if (isset($_POST['selCategoria']))
	{
		$categoria = $_POST['selCategoria'];
		$marca = $_POST['selMarca'];
		
		AdicionarAlbum($marca, $categoria);
	}
}
else if (isset($_POST['editAlbumBool']))
{
	if (isset($_POST['selAlbum']))
	{
		$marca = $_POST['selMarca'];
		$album = $_POST['selAlbum'];
		$categoria = $_POST['selCategoria'];
		
		AlteraAlbum($album, $marca, $categoria);
	}
}
else if (isset($_POST['removeAlbum']))
{
	if (isset($_POST['selData']))
	{
		$id = $_POST['selData'];
		RemoveAlbum($id);
	}
}

//
// TESTES PARA ARQUIVOS
//
else if (isset($_POST['addArquivo']))
{
	if (isset($_POST['albumID']))
	{
		$album = $_POST['albumID'];
		
		AdicionaArquivo($album);
	}
}
else if (isset($_POST['removeArquivo']))
{
	if (isset($_POST['AlbumID']))
	{
		$album = $_POST['AlbumID'];
		$arqID = $_POST['selArquivo'];
		
		RemoveArquivo($album, $arqID);
	}
}
else if (isset($_POST['altArquivo']))
{
	if (isset($_POST['arquivoID']))
	{
		$id = $_POST['arquivoID'];
		AlteraArquivo($id);
	}
}
else if (isset($_POST['selData']))
{
	$id = $_POST['selData'];

}

// ******************************************************************************************
// ******************************************************************************************
// FUNÇÕES PARA ARQUIVOS
// ******************************************************************************************
// ******************************************************************************************

// Pega o arquivo dada uma categoria
function GetArquivos($categoria)
{
	$arquivo = new Arquivos();
	
	$list_pastas = GetAlbuns($categoria);
	
	$list_arquivos = array();
	
	$n = count($list_pastas);
	for ($i = 0; $i < $n; $i++)
	{
		$temp = $list_arquivos;
		$list = $arquivo->GetArquivosFromAlbum($list_pastas[$i]['id']);
		
		$list_arquivos = array_merge ($temp, $list);
	}
	
	return $list_arquivos;
}

// Pega os arquivos de um album
function GetArquivosByAlbum($album)
{
	$arquivo = new Arquivos();
	
	$list_arquivos = $arquivo->GetArquivosFromAlbum($album);
	
	return $list_arquivos;
}

function GetArquivo($id)
{
	$arquivo = new Arquivos();
	
	$data = $arquivo->GetArquivoByID($id);
	
	return $data;	
}

function GetArquivosByName($name)
{
	$arquivo = new Arquivos();
	
	$data = $arquivo->GetArquivosByName($name);
	
	return $data;
}

function GetArquivosPrefix($albumID)
{
	$data = new Pastas();
	$ret = $data->GetAlbumByID($albumID);
	
	$marcaID = $ret['marca'];
	$catID = $ret['categoria'];
	$nome = $ret['nome'];
	
	// Pega informações de marcas
	$m = new Marcas();
	$x = $m->GetMarcaByID($marcaID);
	$_marcaNome = $x['nome'];
	$marcaNome = CleanString($_marcaNome);
	
	// Pega informações de categoria
	$c = new Categorias();
	$y = $c->GetCategoriaByID($catID);
	$catNome = $y['nome'];
	
	// Gera um valor randomico para evitar arquivos iguais num mesmo album.
	$id = uniqid(NULL, TRUE);
	
	$prefix = "../Arquivos/" . $marcaNome . "-" . $marcaID . "/" . $catNome . "-" . $catID . "/" . $nome . "/" . $id . "/";
	
	return $prefix;
}

// Adicionar um arquivo dentro de um album (de ID especificado)
function AdicionaArquivo($albumID)
{
	$erro = Array();
    
    foreach ($_POST as $chv => $vlr) 
    {
        if($vlr == "" && substr($chv,0,3) == "ARQ") 
        {
            $erro[] = "O campo " . substr($chv,4) . " não foi informado";
        }
    }
	
	$n = count($erro);
	if ($n > 0)
	{
		RedirecionaArquivo($albumID, FALSE);
	}
	
	$arquivo = new Arquivos();
	
	$nome = $_POST['ARQ_NOME'];
	$desc = $_POST['ARQ_DESC'];
	$tipo = $_POST['ARQ_TIPO'];
	
	$_file1 = $_FILES['ARQ_FILE1'];
	$_file2 = $_FILES['ARQ_FILE2'];
	$_file3 = $_FILES['ARQ_FILE3'];
	
	$prefix = GetArquivosPrefix($albumID);
	$_imagem1 = "";
	$_imagem2 = "";
	$_imagem3 = "";
	
	if (isset($_file1) && $_file1['size'] > 0)
	{
		if ($_file1["error"] > 0)
			RedirecionaArquivo($albumID, FALSE);
		
		$_imagem1 = Arquivos::UpdateArquivo($prefix, $_file1);
		$_imagem1 = $prefix . $_imagem1;
	}
	if (isset($_file2) && $_file2['size'] > 0)
	{
		if ($_file2["error"] > 0)
			RedirecionaArquivo($albumID, FALSE);
			
		$_imagem2 = Arquivos::UpdateArquivo($prefix, $_file2);
		$_imagem2 = $prefix . $_imagem2;
	}
	if (isset($_file3) && $_file3['size'] > 0)
	{
		if ($_file3["error"] > 0)
			RedirecionaArquivo($albumID, FALSE);
		
		$_imagem3 = Arquivos::UpdateArquivo($prefix, $_file3);
		$_imagem3 = $prefix . $_imagem3;
	}
	
	$result = $arquivo->AdicionaArquivo($nome, $desc, $tipo, $_imagem1, $_imagem2, $_imagem3, $albumID);
	
	RedirecionaArquivo($albumID, $result);
}

// Remove arquivo do album (albumID) de ID especificado
function RemoveArquivo($albumID, $arqID, $redirect = TRUE)
{
	$arquivo = new Arquivos();
	
	$selected = $arquivo->GetArquivoByID($arqID);
	$file1 = $selected['arquivo1'];
	$file2 = $selected['arquivo2'];
	$file3 = $selected['arquivo3'];
	
	$rootDir = "";
	if ($file1 != NULL)
	{
		$rootDir = dirname($file1);
		$ret = Arquivos::RemoveFile($file1);
		if ($ret == FALSE)
		{
			if ($redirect)
				RedirecionaArquivo($albumID, $ret);
			else
				return FALSE;
		}
	}
	if ($file2 != NULL)
	{
		$rootDir = dirname($file2);
		$ret = Arquivos::RemoveFile($file2);
		if ($ret == FALSE)
		{
			if ($redirect)
				RedirecionaArquivo($albumID, $ret);
			else
				return FALSE;
		}
	}
	if ($file3 != NULL)
	{
		$rootDir = dirname($file3);
		$ret = Arquivos::RemoveFile($file3);
		if ($ret == FALSE)
		{
			if ($redirect)
				RedirecionaArquivo($albumID, $ret);
			else
				return FALSE;
		}
	}

	$ret = rmdir(utf8_decode($rootDir . "/"));
	if ($ret == FALSE)
	{
		if ($redirect)
			RedirecionaArquivo($albumID, $ret);
		else
			return FALSE;
	}
	
	$ret = $arquivo->RemoveArquivo($arqID);
	
	if ($redirect)
		RedirecionaArquivo($albumID, $ret);
	else
		return TRUE;
}

// Alterar arquivo ocm o ID especificado
function AlteraArquivo($id)
{
	$arquivo = new Arquivos();
	
	$selected = $arquivo->GetArquivoByID($id);
	$albumID = $selected['album'];
	
	// Procura se já existe algum arquivo no BD,
	// Se existir, usa este prefixo, se não cria um novo
	$prefix = null;
	// Verifica Arquivo 1
	$myFile1 = $selected['arquivo1'];
	if ($myFile1 != null)
		$prefix = pathinfo($myFile1, PATHINFO_DIRNAME);
	// Verifica Arquivo 2
	$myFile2 = $selected['arquivo2'];
	if ($myFile2 != NULL)
		$prefix = pathinfo($myFile2, PATHINFO_DIRNAME);
	// Verifica Arquivo 3
	$myFile3 = $selected['arquivo3'];
	if ($myFile3 != NULL)
		$prefix = pathinfo($myFile3, PATHINFO_DIRNAME);
	// Caso não tenha nenhum, cria um novo
	if ($prefix == NULL)
		$prefix = GetArquivosPrefix($albumID);
	
	$nome = null;
	$desc = null;
	$tipo = null;
	$imagem1 = null;
	$imagem2 = null;
	$imagem3 = null;
	
	if (isset($_POST['ARQ_NOME']))
	{
		$nome = $_POST['ARQ_NOME'];
	}
	if (isset($_POST['ARQ_DESC']))
	{
		$desc = $_POST['ARQ_DESC'];
	}
	if (isset($_POST['ARQ_TIPO']))
	{
		$tipo = $_POST['ARQ_TIPO'];
	}
	if (isset($_FILES['ARQ_FILE_1']) && $_FILES['ARQ_FILE_1']['size'] > 0)
	{
		$file1 = $_FILES['ARQ_FILE_1'];	
		if ($file1["error"] > 0)
		{
			RedirecionaArquivo($albumID, FALSE);
		}
		
		if ($myFile1 != NULL)
		{
			$ret = Arquivos::RemoveFile($myFile1);
			if ($ret == FALSE)
			{
				RedirecionaArquivo($albumID, FALSE);
			}	
		}
		
		$imagem1 = Arquivos::UpdateArquivo($prefix . "/", $file1);
		$imagem1 = $prefix . "/" . $imagem1;
		
	}
	if (isset($_FILES['ARQ_FILE_2']) && $_FILES['ARQ_FILE_2']['size'] > 0)
	{
		$file2 = $_FILES['ARQ_FILE_2'];
		if ($file2["error"] > 0)
		{
			RedirecionaArquivo($albumID, FALSE);
		}
		
		if ($myFile2 != NULL)
		{
			$ret = Arquivos::RemoveFile($myFile2);
			if ($ret == FALSE)
			{
				RedirecionaArquivo($albumID, FALSE);
			}			
		}
	
		$imagem2 = Arquivos::UpdateArquivo($prefix . "/", $file2);
		$imagem2 = $prefix . "/" . $imagem2;
	}
	if (isset($_FILES['ARQ_FILE_3']) && $_FILES['ARQ_FILE_3']['size'] > 0)
	{
		$file3 = $_FILES['ARQ_FILE_3'];
		if ($file3["error"] > 0)
		{
			RedirecionaArquivo($albumID, FALSE);
		}
		
		if ($myFile3 != NULL)
		{
			$ret = Arquivos::RemoveFile($myFile3);
			if ($ret == FALSE)
			{
				RedirecionaArquivo($albumID, FALSE);
			}		
		}
	
		$imagem3 = Arquivos::UpdateArquivo($prefix . "/", $file3);
		$imagem3 = $prefix . "/" . $imagem3;
	}
	
	$ret = $arquivo->AlteraArquivo($id, $nome, $desc, $tipo, $imagem1, $imagem2, $imagem3);
	
	RedirecionaArquivo($albumID, $ret);
}

function IncrementaNumeroDownloads($id)
{
	$arquivo = new Arquivos();
	
	$ret = $arquivo->IncrementaDownloads($id);
}

// Pega os 10 arquivos mais baixados no sistema
function GetArquivosMaisBaixados()
{
	$arqs = new Arquivos();
	
	$result = $arqs->GetArquivosMaisBaixados();
	
	return $result;
}

// Pega os 10 arquivos mais recentes adicionados
function GetArquivosRecentes()
{
	$arqs = new Arquivos();
	
	$result = $arqs->GetArquivosRecentes();
	
	return $result;	
}

// Redireciona para a pagina com os parametros necessários
function RedirecionaArquivo($albumID, $result)
{
	$data = new Pastas();
	$ret = $data->GetAlbumByID($albumID);
	
	$marcaID = $ret['marca'];
	$catID = $ret['categoria'];
	$m = new Marcas();
	$x = $m->GetMarcaByID($marcaID);
	$marcaNome = $x['nome'];
			
	if ($result == TRUE && $m != NULL)
	{
		header("location: ../arquivos-lista.php?status=success&marca=$marcaID&name=$marcaNome&categoria=$catID");	
	}
	else
	{
		header("location: ../arquivos-lista.php?status=error&marca=$marcaID&name=$marcaNome&categoria=$catID");		
	}
}

// ******************************************************************************************
// ******************************************************************************************
// FUNÇÕES PARA ALBUNS
// ******************************************************************************************
// ******************************************************************************************

function GetAlbunsPrefix($albumID)
{
	$data = new Pastas();
	$ret = $data->GetAlbumByID($albumID);
	
	$marcaID = $ret['marca'];
	$catID = $ret['categoria'];
	$nome = $ret['nome'];
	
	// Pega informações de marcas
	$m = new Marcas();
	$x = $m->GetMarcaByID($marcaID);
	$_marcaNome = $x['nome'];
	$marcaNome = CleanString($_marcaNome);
	
	// Pega informações de categoria
	$c = new Categorias();
	$y = $c->GetCategoriaByID($catID);
	$catNome = $y['nome'];
	
	$prefix = "../Arquivos/" . $marcaNome . "-" . $marcaID . "/" . $catNome . "-" . $catID . "/" . $nome . "/";
	
	return $prefix;
}

// Busca todos os albuns de uma categoria especificada
// inclusive de todas as marcas
function GetAlbuns($categoria)
{
	$marcas = new Marcas();
	$pastas = new Pastas();
	
	$list_marcas = $marcas->CarregaMarcas();
	
	$list_pastas = array();
	
	$n1 = count($list_marcas);
	for ($i = 0; $i < $n1; $i++)
	{
		$temp = $list_pastas;
		$list = $pastas->GetAlbumsFromCategoria($list_marcas[$i]['id'], $categoria);
		
		$list_pastas = array_merge ($temp, $list);
	}
	
	return $list_pastas;
}

// Busca album através do ID
function GetAlbum($id)
{
	$pastas = new Pastas();
	
	$album = $pastas->GetAlbumByID($id);
	
	return $album;
}

function GetAlbunsByName($name)
{
	$pastas = new Pastas();
	
	$albuns = $pastas->GetAlbunsByName($name);
	
	return $albuns;
}

// Pega todos os albuns de uma marca e categoria especificada
function GetAlbunsByMarca($marca, $categoria)
{
	$pastas = new Pastas();
	
	$list_pastas = $pastas->GetAlbumsFromCategoria($marca, $categoria);
	
	return $list_pastas;
}

// Adiciona um album 
function AdicionarAlbum($marca, $categoria)
{
	$pastas = new Pastas();
	
	$m = new Marcas();
	$result = $m->GetMarcaByID($marca);
	$marcaNome = $result['nome'];
	
	$nome = $_POST['ALB_NOME'];
	if (!isset($nome))
	{
		Redireciona($marca, $categoria, FALSE);
	}
	
	$result = $pastas->AdicionaPasta($nome, $categoria, $marca);
	
	Redireciona($marca, $categoria, $result);
}

// Altera um album
function AlteraAlbum($id, $marca, $categoria)
{
	$pastas = new Pastas();
	
	$m = new Marcas();
	$result = $m->GetMarcaByID($marca);
	$marcaNome = $result['nome'];
	
	$nome = $_POST['ALB_NOME'];
	if (!isset($nome))
	{
		Redireciona($marca, $categoria, FALSE);
	}
	
	$result = $pastas->AlteraPasta($id, $nome);

	Redireciona($marca, $categoria, $result);
}

// Remove um album e todos os arquivos de dentro
function RemoveAlbum($id)
{
	$pastas = new Pastas();
	$album = $pastas->GetAlbumByID($id);
	
	$arquivos = GetArquivosByAlbum($id);
	
	// Removendo os arquivos dentro do album
	$n = count($arquivos);
	for($i = 0; $i < $n; $i++)
	{
		$ret = RemoveArquivo($id, $arquivos[$i]['id']);
		if ($ret == FALSE)
		{		
			Redireciona($album['marca'], $album['categoria'], FALSE);
		}
	}
	
	// Remove a pasta do album
	$folder = GetAlbunsPrefix($id);
	if (rmdir(utf8_decode($folder)) == FALSE)
	{
		Redireciona($album['marca'], $album['categoria'], FALSE);
	}
	
	// Remove do Banco de dados
	$ret = $pastas->RemovePasta($id);
	
	Redireciona($album['marca'], $album['categoria'], $ret);
}

// Redireciona para a pagina com os parametros necessários
function Redireciona($marca, $categoria, $result)
{
	$m = new Marcas();
	$result = $m->GetMarcaByID($marca);
	$marcaNome = $result['nome'];
	
	if ($result == TRUE && $m != NULL)
	{
		header("location: ../arquivos-lista.php?status=success&marca=$marca&name=$marcaNome&categoria=$categoria");	
	}
	else
	{
		header("location: ../arquivos-lista.php?status=error&marca=$marca&name=$marcaNome&categoria=$categoria");		
	}
}

// ******************************************************************************************
// ******************************************************************************************
// GENERIC METHODS
// ******************************************************************************************
// ******************************************************************************************

function CleanString($string)
{
	$string_minusculo = strtolower($string);
	$caracteres = array("ç","~","^","]","[","{","}",";",":","´",",",">","<","-","/","|","@","$","%","ã","â","á","à","é","è","ó","ò","+","=","*","&","(",")","!","#","?","`","ã"," ","©", "™", "®");
	
	$string_tratado = str_replace($caracteres,"",$string_minusculo);
	
	return $string_tratado;
}

function formatBytes($bytes, $precision = 2) 
{ 
 	$kilobyte = 1024;
    $megabyte = $kilobyte * 1024;
    $gigabyte = $megabyte * 1024;
    $terabyte = $gigabyte * 1024;
   
    if (($bytes >= 0) && ($bytes < $kilobyte)) {
        return $bytes . ' B';
 
    } elseif (($bytes >= $kilobyte) && ($bytes < $megabyte)) {
        return round($bytes / $kilobyte, $precision) . ' KB';
 
    } elseif (($bytes >= $megabyte) && ($bytes < $gigabyte)) {
        return round($bytes / $megabyte, $precision) . ' MB';
 
    } elseif (($bytes >= $gigabyte) && ($bytes < $terabyte)) {
        return round($bytes / $gigabyte, $precision) . ' GB';
 
    } elseif ($bytes >= $terabyte) {
        return round($bytes / $terabyte, $precision) . ' TB';
    } else {
        return $bytes . ' B';
    }
}

function GetImageFromType($arquivo)
{
	$path = $arquivo['arquivo1'];
	if ($path == null)
	{
		$path = $arquivo['arquivo2'];
		if ($path == null)
		{
			$path = $arquivo['arquivo3'];
			if ($path == null)
				return "img/default-icon.png";
		}
	}
	
	$img = GetImageFromPath($path);
	
	return $img;
}

function GetImageFromPath($path)
{
	// ARRAY WITH TYPES
$typesArray = array (
		'application/x-authorware-bin' => '.aab',
		'application/x-authorware-map' => '.aam',
		'application/x-authorware-seg' => '.aas',
		'text/vnd.abc' => '.abc',
		'video/animaflex' => '.afl',
		'application/x-aim' => '.aim',
		'text/x-audiosoft-intra' => '.aip',
		'application/x-navi-animation' => '.ani',
		'application/x-nokia-9000-communicator-add-on-software' => '.aos',
		'application/mime' => '.aps',
		'application/arj' => '.arj',
		'image/x-jg' => '.art',
		'text/asp' => '.asp',
		'video/x-ms-asf-plugin' => '.asx',
		'audio/x-au' => '.au',
		'video/avi' => '.avi',
		'video/msvideo' => '.avi',
		'video/x-msvideo' => '.avi',
		'video/avs-video' => '.avs',
		'application/x-bcpio' => '.bcpio',
		'application/mac-binary' => '.bin',
		'application/macbinary' => '.bin',
		'application/x-binary' => '.bin',
		'application/x-macbinary' => '.bin',
		'image/x-windows-bmp' => '.bmp',
		'application/x-bzip' => '.bz',
		'application/vnd.ms-pki.seccat' => '.cat',
		'application/clariscad' => '.ccad',
		'application/x-cocoa' => '.cco',
		'application/cdf' => '.cdf',
		'application/x-cdf' => '.cdf',
		'application/java' => '.class',
		'application/java-byte-code' => '.class',
		'application/x-java-class' => '.class',
		'application/x-cpio' => '.cpio',
		'application/mac-compactpro' => '.cpt',
		'application/x-compactpro' => '.cpt',
		'application/x-cpt' => '.cpt',
		'application/pkcs-crl' => '.crl',
		'application/pkix-crl' => '.crl',
		'application/x-x509-user-cert' => '.crt',
		'application/x-csh' => '.csh',
		'text/x-script.csh' => '.csh',
		'application/x-pointplus' => '.css',
		'text/css' => '.css',
		'application/x-deepv' => '.deepv',
		'video/dl' => '.dl',
		'video/x-dl' => '.dl',
		'application/commonground' => '.dp',
		'text/docword' => '.doc',
		'text/docxword' => '.docx',
		'text/excel' => '.xls',
		'text/xexcel' => '.xlsx',
		'application/drafting' => '.drw',
		'application/x-dvi' => '.dvi',
		'drawing/x-dwf (old)' => '.dwf',
		'application/acad' => '.dwg',
		'application/dxf' => '.dxf',
		'text/x-script.elisp' => '.el',
		'application/x-bytecode.elisp (compiled elisp)' => '.elc',
		'application/x-elc' => '.elc',
		'application/x-esrehber' => '.es',
		'text/x-setext' => '.etx',
		'application/envoy' => '.evy',
		'application/vnd.fdf' => '.fdf',
		'application/fractals' => '.fif',
		'image/fif' => '.fif',
		'video/fli' => '.fli',
		'video/x-fli' => '.fli',
		'text/vnd.fmi.flexstor' => '.flx',
		'video/x-atomic3d-feature' => '.fmf',
		'image/vnd.fpx' => '.fpx',
		'image/vnd.net-fpx' => '.fpx',
		'application/freeloader' => '.frl',
		'image/g3fax' => '.g3',
		'image/gif' => '.gif',
		'video/gl' => '.gl',
		'video/x-gl' => '.gl',
		'application/x-gsp' => '.gsp',
		'application/x-gss' => '.gss',
		'application/x-gtar' => '.gtar',
		'multipart/x-gzip' => '.gzip',
		'application/x-hdf' => '.hdf',
		'text/x-script' => '.hlb',
		'application/hlp' => '.hlp',
		'application/x-winhelp' => '.hlp',
		'application/binhex' => '.hqx',
		'application/binhex4' => '.hqx',
		'application/mac-binhex' => '.hqx',
		'application/mac-binhex40' => '.hqx',
		'application/x-binhex40' => '.hqx',
		'application/x-mac-binhex40' => '.hqx',
		'application/hta' => '.hta',
		'text/x-component' => '.htc',
		'text/webviewhtml' => '.htt',
		'x-conference/x-cooltalk' => '.ice ',
		'image/x-icon' => '.ico',
		'application/x-ima' => '.ima',
		'application/x-httpd-imap' => '.imap',
		'application/inf' => '.inf ',
		'application/x-internett-signup' => '.ins',
		'application/x-ip2' => '.ip ',
		'video/x-isvideo' => '.isu',
		'audio/it' => '.it',
		'application/x-inventor' => '.iv',
		'application/x-livescreen' => '.ivy',
		'audio/x-jam' => '.jam ',
		'application/x-java-commerce' => '.jcm',
		'image/x-jpg' => '.jpg',
		'image/x-jpeg' => '.jpeg',
		'image/x-jps' => '.jps',
		'application/x-javascript' => '.js ',
		'image/jutvision' => '.jut',
		'music/x-karaoke' => '.kar',
		'application/x-ksh' => '.ksh',
		'text/x-script.ksh' => '.ksh',
		'audio/x-liveaudio' => '.lam',
		'application/lha' => '.lha',
		'application/x-lha' => '.lha',
		'application/x-lisp' => '.lsp ',
		'text/x-script.lisp' => '.lsp ',
		'text/x-la-asf' => '.lsx',
		'application/x-lzh' => '.lzh',
		'application/lzx' => '.lzx',
		'application/x-lzx' => '.lzx',
		'text/x-m' => '.m',
		'audio/x-mpequrl' => '.m3u ',
		'application/x-troff-man' => '.man',
		'application/x-navimap' => '.map',
		'application/mbedlet' => '.mbd',
		'application/x-magic-cap-package-1.0' => '.mc$',
		'application/mcad' => '.mcd',
		'application/x-mathcad' => '.mcd',
		'image/vasa' => '.mcf',
		'text/mcf' => '.mcf',
		'application/netmc' => '.mcp',
		'application/x-troff-me' => '.me ',
		'application/x-frame' => '.mif',
		'application/x-mif' => '.mif',
		'www/mime' => '.mime ',
		'audio/x-vnd.audioexplosion.mjuicemediafile' => '.mjf',
		'video/x-motion-jpeg' => '.mjpg ',
		'application/x-meme' => '.mm',
		'audio/mod' => '.mod',
		'audio/x-mod' => '.mod',
		'audio/x-mpeg' => '.mp2',
		'video/x-mpeq2a' => '.mp2',
		'audio/mpeg3' => '.mp3',
		'audio/x-mpeg-3' => '.mp3',
		'application/vnd.ms-project' => '.mpp',
		'application/marc' => '.mrc',
		'application/x-troff-ms' => '.ms',
		'application/x-vnd.audioexplosion.mzz' => '.mzz',
		'application/vnd.nokia.configuration-message' => '.ncm',
		'application/x-mix-transfer' => '.nix',
		'application/x-conference' => '.nsc',
		'application/x-navidoc' => '.nvd',
		'application/oda' => '.oda',
		'application/x-omc' => '.omc',
		'application/x-omcdatamaker' => '.omcd',
		'application/x-omcregerator' => '.omcr',
		'text/x-pascal' => '.p',
		'application/pkcs10' => '.p10',
		'application/x-pkcs10' => '.p10',
		'application/pkcs-12' => '.p12',
		'application/x-pkcs12' => '.p12',
		'application/x-pkcs7-signature' => '.p7a',
		'application/x-pkcs7-certreqresp' => '.p7r',
		'application/pkcs7-signature' => '.p7s',
		'text/pascal' => '.pas',
		'image/x-portable-bitmap' => '.pbm ',
		'application/vnd.hp-pcl' => '.pcl',
		'application/x-pcl' => '.pcl',
		'image/x-pict' => '.pct',
		'image/x-pcx' => '.pcx',
		'text/pdf' => '.pdf',
		'audio/make.my.funk' => '.pfunk',
		'image/x-portable-graymap' => '.pgm',
		'image/x-portable-greymap' => '.pgm',
		'application/x-newton-compatible-pkg' => '.pkg',
		'application/vnd.ms-pki.pko' => '.pko',
		'text/x-script.perl' => '.pl',
		'application/x-pixclscript' => '.plx',
		'text/x-script.perl-module' => '.pm',
		'application/x-portable-anymap' => '.pnm',
		'image/x-portable-anymap' => '.pnm',
		'model/x-pov' => '.pov',
		'image/x-portable-pixmap' => '.ppm',
		'application/powerpoint' => '.ppt',
		'application/x-mspowerpoint' => '.ppt',
		'application/x-freelance' => '.pre',
		'paleovu/x-pv' => '.pvu',
		'text/x-script.phyton' => '.py ',
		'applicaiton/x-bytecode.python' => '.pyc ',
		'audio/vnd.qcelp' => '.qcp ',
		'video/x-qtc' => '.qtc',
		'audio/x-realaudio' => '.ra',
		'application/x-cmu-raster' => '.ras',
		'image/x-cmu-raster' => '.ras',
		'text/x-script.rexx' => '.rexx ',
		'image/vnd.rn-realflash' => '.rf',
		'image/x-rgb' => '.rgb ',
		'application/vnd.rn-realmedia' => '.rm',
		'audio/mid' => '.rmi',
		'application/ringing-tones' => '.rng',
		'application/vnd.nokia.ringing-tone' => '.rng',
		'application/vnd.rn-realplayer' => '.rnx ',
		'image/vnd.rn-realpix' => '.rp ',
		'text/vnd.rn-realtext' => '.rt',
		'application/x-rtf' => '.rtf',
		'video/vnd.rn-realvideo' => '.rv',
		'audio/s3m' => '.s3m ',
		'application/x-lotusscreencam' => '.scm',
		'text/x-script.guile' => '.scm',
		'text/x-script.scheme' => '.scm',
		'video/x-scm' => '.scm',
		'application/sdp' => '.sdp ',
		'application/x-sdp' => '.sdp ',
		'application/sounder' => '.sdr',
		'application/sea' => '.sea',
		'application/x-sea' => '.sea',
		'application/set' => '.set',
		'application/x-sh' => '.sh',
		'text/x-script.sh' => '.sh',
		'audio/x-psid' => '.sid',
		'application/x-sit' => '.sit',
		'application/x-stuffit' => '.sit',
		'application/x-seelogo' => '.sl ',
		'audio/x-adpcm' => '.snd',
		'application/solids' => '.sol',
		'application/x-pkcs7-certificates' => '.spc ',
		'application/futuresplash' => '.spl',
		'application/streamingmedia' => '.ssm ',
		'application/vnd.ms-pki.certstore' => '.sst',
		'application/sla' => '.stl',
		'application/vnd.ms-pki.stl' => '.stl',
		'application/x-navistyle' => '.stl',
		'application/x-sv4cpio' => '.sv4cpio',
		'application/x-sv4crc' => '.sv4crc',
		'x-world/x-svr' => '.svr',
		'application/x-shockwave-flash' => '.swf',
		'image/x-png' => '.png',
		'application/x-tar' => '.tar',
		'application/toolbook' => '.tbk',
		'application/x-tcl' => '.tcl',
		'text/x-script.tcl' => '.tcl',
		'text/x-script.tcsh' => '.tcsh',
		'application/x-tex' => '.tex',
		'application/plain' => '.text',
		'application/gnutar' => '.tgz',
		'audio/tsp-audio' => '.tsi',
		'application/dsptype' => '.tsp',
		'audio/tsplayer' => '.tsp',
		'text/tab-separated-values' => '.tsv',
		'text/x-uil' => '.uil',
		'application/i-deas' => '.unv',
		'application/x-ustar' => '.ustar',
		'multipart/x-ustar' => '.ustar',
		'application/x-cdlink' => '.vcd',
		'text/x-vcalendar' => '.vcs',
		'application/vda' => '.vda',
		'video/vdo' => '.vdo',
		'application/groupwise' => '.vew ',
		'application/vocaltec-media-desc' => '.vmd ',
		'application/vocaltec-media-file' => '.vmf',
		'audio/voc' => '.voc',
		'audio/x-voc' => '.voc',
		'video/vosaic' => '.vos',
		'audio/voxware' => '.vox',
		'audio/x-twinvq' => '.vqf',
		'application/x-vrml' => '.vrml',
		'x-world/x-vrt' => '.vrt',
		'application/wordperfect6.1' => '.w61',
		'audio/wav' => '.wav',
		'audio/x-wav' => '.wav',
		'application/x-qpro' => '.wb1',
		'image/vnd.wap.wbmp' => '.wbmp',
		'application/vnd.xara' => '.web',
		'application/x-123' => '.wk1',
		'windows/metafile' => '.wmf',
		'text/vnd.wap.wml' => '.wml',
		'application/vnd.wap.wmlc' => '.wmlc ',
		'text/vnd.wap.wmlscript' => '.wmls',
		'application/vnd.wap.wmlscriptc' => '.wmlsc ',
		'application/x-wpwin' => '.wpd',
		'application/x-lotus' => '.wq1',
		'application/mswrite' => '.wri',
		'application/x-wri' => '.wri',
		'text/scriplet' => '.wsc',
		'application/x-wintalk' => '.wtk ',
		'image/x-xbitmap' => '.xbm',
		'image/x-xbm' => '.xbm',
		'image/xbm' => '.xbm',
		'video/x-amt-demorun' => '.xdr',
		'xgl/drawing' => '.xgz',
		'image/vnd.xiff' => '.xif',
		'audio/xm' => '.xm',
		'application/xml' => '.xml',
		'text/xml' => '.xml',
		'video/movie' => '.xmz',
		'application/x-vnd.ls-xpix' => '.xpix',
		'image/xpm' => '.xpm',
		'video/x-amt-showrun' => '.xsr',
		'image/x-xwd' => '.xwd',
		'image/x-xwindowdump' => '.xwd',
		'application/x-compress' => '.z',
		'application/x-zip-compressed' => '.zip',
		'application/zip' => '.zip',
		'text/x-script.zsh' => '.zsh',
		);

	$ext = pathinfo($path, PATHINFO_EXTENSION);

	$_type = array_search (strtolower("." . $ext), $typesArray);
	

	if ($_type == null)
	{
		return "img/default-icon.png";
	}
	
	$selected = explode("/", $_type);
	
	$image = null;
	switch (strtolower($selected[0])) 
	{
		case 'application':
			$image = "img/app-icon.png";
			break;
		case 'text':
			$image = "img/doc-icon.png";
			break;
		case 'video':
			$image = "img/video-icon.png";
			break;
		case 'image':
		case 'drawing':
			$image = substr($path, 3, strlen($path));
			break;
		case 'audio':
			$image = "img/audio-icon.png";
			break;
		case 'multipart':
		case 'x-world':
		default:
			$image = "img/default-icon.png";
			break;
	}
		
	return $image;
}

function setMemoryForImage( $filename )
{
    $imageInfo = getimagesize($filename);
    $MB = 1048576;  // number of bytes in 1M
    $K64 = 65536;    // number of bytes in 64K
    $TWEAKFACTOR = 1.5;  // Or whatever works for you
    $memoryNeeded = round( ( $imageInfo[0] * $imageInfo[1]
                                           * $imageInfo['bits']
                                           * $imageInfo['channels'] / 8
                             + $K64
                           ) * $TWEAKFACTOR
                         );
						 
    //ini_get('memory_limit') only works if compiled with "--enable-memory-limit" also
    //Default memory limit is 8MB so well stick with that. 
    //To find out what yours is, view your php.ini file.
    
    $memoryLimit = 8 * $MB;
    if (function_exists('memory_get_usage') && 
        memory_get_usage() + $memoryNeeded > $memoryLimit) 
    {
        $newLimit = $memoryLimitMB + ceil( ( memory_get_usage()
                                            + $memoryNeeded
                                            - $memoryLimit
                                            ) / $MB
                                        );
        ini_set( 'memory_limit', $newLimit . 'M' );
        return true;
    }
    else
	{
        return false;
    }
}

?>