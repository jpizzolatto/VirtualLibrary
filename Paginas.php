<?php

session_start();

require_once("Controller/Categorias.php");
require_once("Controller/Arquivos.php");

$action = $_GET['action'];
$scope = $_GET['scope'];

$var = 0;
if ($action == "next")
{
	$var = 10;
}
else if ($action == "prev")
{
	$var = -10;
}

if ($scope == "albuns")
{
	ChangeAlbunsPage($var, $action);
}
else if ($scope == "arquivos")
{
	ChangeArquivosPage($var, $action);
}
else if ($scope == "search")
{
	ChangeSearchPage($var, $action);
}

// Atualiza a paginação
function UpdatePagiation($currPage, $n, $scope)
{
	$init = $currPage - 1;
	$index = $init * 10;
	
	$retval = "";
	
	$retval .= "<ul>";
	
	if ($index == 0)
		$retval .= "<li class='disabled'><a href='#'><span>Prev</a></span></li>";
	else 
		$retval .= "<li><a href='#' onclick='ChangePage(\"prev\", \"".$scope."\");'><span>Prev</a></span></li>";
	
	$pages = ceil($n/10);
	for ($j = 1; $j <= $pages; $j++)
	{
		if ($j == $currPage)
			$retval .= "<li class='disabled'><a href='#'><span>".$j."</span></a></li>";
		else
			$retval .= "<li><a href='#' onclick='ChangePage(".$j.", \"".$scope."\");'><span>".$j."</span></a></li>";	
	}
	
	if (($index + 10) > $n)
		$retval .= "<li class='disabled'><a href='#'><span>Next</span></a></li>"; 
	else
		$retval .= "<li><a href='#' onclick='ChangePage(\"next\", \"".$scope."\");'><span>Next</span></a></li>";
	
	$retval .= "</ul>";
	
	return $retval;
}

function CalculateAggregateVar($init, $action)
{
	$currPage = ceil(($init + 1)/10);
	if ($currPage > $action)
	{
		$var = -10;
	}
	else if ($currPage < $action)
	{
		$var = 10;
	}
	
	return $var;
}

// Método que troca as páginas para albuns
function ChangeAlbunsPage($var, $action)
{
	$marca = $_SESSION['marca'];
	$categoria = $_SESSION['categoria'];
	
	$albuns = GetAlbunsByMarca($marca['id'], $categoria['id']);
	
	$init = $_SESSION['albumIndex'];
	
	if ($var == 0)
	{
		$var = CalculateAggregateVar($init, $action);
	}
	
	$index = $init + $var;
	
	$m = $index + 10;
	$n = count($albuns);
	$c = 0;
	
	$retval = "";
	for ($i = $index; $i < $n && $i < $m; $i++)
	{
		if ($c == 10)
			break;
		
		$prefix = "";
		if($c == 0) 
			$prefix = 'margin-left: 15px;';
		
		$retval .= 
		"<div class='span2' style='z-index: 100; width: 80px; height: 120px; position: relative; margin-top: 20px; margin-right: 40px; ".$prefix."'>
			<a href='arquivos.php?album=".$albuns[$i]['id']."'>
	 			<div class='span4 offset7' style='z-index: 9999; position: absolute; display: block; margin-top: 45px;'>
	 				<img src='".$_SESSION['categoriasImagePrefix'] . $categoria['imagem']."' />
	 			</div>
	 			<img  src='img/pasta.png' />
	 			<p align='center' class='btn btn-link' style='padding-left: 5px;'>".$albuns[$i]['nome']."</p>
 			</a>
		</div>";
	
		$c++;
	}
	
	$_SESSION['albumIndex'] = $index;
	
	if ($action == "prev" || $action == "next")
		$nextPage = ceil(($index + 1)/10);
	else
		$nextPage = $action;
	
	$pagination = UpdatePagiation($nextPage, $n, "albuns");
	
	echo $retval . "|" . $pagination;
	
	return;
}

// Método que troca as páginas para arquivos
function ChangeArquivosPage($var, $action)
{
	$album = $_SESSION['currAlbum'];
	
	$arquivos = GetArquivosByAlbum($album['id']);
	
	$init = $_SESSION['arquivosIndex'];
	
	if ($var == 0)
	{
		$var = CalculateAggregateVar($init, $action);
	}
	
	$index = $init + $var;
	
	$m = $index + 10;
	$n = count($arquivos);
	$c = 0;
	
	$retval = "";
	for ($i = $index; $i < $n; $i++)
	{
		if ($c == 10)
			break;
		
		$prefix = "";
		if($c == 0) 
			$prefix = 'margin-left: 15px;';
		
		$img = GetImageFromType($arquivos[$i]);
	
		$retval .=
		"<div class='span2 album-icon' style='height: 160px; width: 80px; margin-bottom: 20px;".$prefix."'>
			<a href='arquivo-escolhido.php?id=".$arquivos[$i]['id']."'>
	 			<img class='miniImages' src='".$img."' />
	 			<p align='center' class='btn btn-link'>".$arquivos[$i]['nome']."</p>
 			</a>	
		</div>";
		
		$c++;
	}
	
	$_SESSION['arquivosIndex'] = $index;
	
	if ($action == "prev" || $action == "next")
		$nextPage = ceil(($index + 1)/10);
	else
		$nextPage = $action;
	
	$pagination = UpdatePagiation($nextPage, $n, "arquivos");
	
	echo $retval . "|" . $pagination;
	
	return;	
}

// Muda a páginação das buscas
function ChangeSearchPage($var, $action)
{
	$scope = $_SESSION['search-scope'];
	$array = $_SESSION['search_result'];
	$values = $array[$scope];
	
	$init = $_SESSION['searchIndex'];
	
	if ($var == 0)
	{
		$var = CalculateAggregateVar($init, $action);
	}
	
	$index = $init + $var;
	
	$m = $index + 10;
	$n = count($values);
	$c = 0;
	
	$retval = "";
	for ($i = $index; $i < $n; $i++)
	{
		if ($c == 10)
			break;
		
		$mid = "";
		if ($scope == 'albuns')
		{
			$catID = $values[$i]['categoria'];
			$categoria = GetCategoria($catID);
			$img = "img/pasta.png";
			
			$mid .=
			"<div class='span8' style='margin-top: 20px; margin-left: 25px;'>
				<h5>".$values[$i]["nome"]."</h5>	
			</div>";
		}
		if ($scope == "arquivos")
		{
			$img = GetImageFromType($values[$i]);
			
			$mid .=
			"<div class='span8' style='margin-left: 25px;'>
				<h5>".$values[$i]["nome"]."</h5>
				<p>".$values[$i]["descricao"]."</p>	
			</div>";
		}
		if ($scope == "marcas")
		{
			$img = $_SESSION['marcasImagePrefix'] . $values[$i]["imagem"];
			
			$mid .=
			"<div class='span8' style='margin-top: 20px; margin-left: 25px;'>
				<h5>".$values[$i]["nome"]."</h5>	
			</div>";
		}
		
		$retval .=
		"<li style='padding-bottom: 20px;'>
			<div class='span10'>
				<a href='Controller/Direciona.php?id=".$values[$i]['id']."&nome=".$scope."'>
					<div class='span2' style='position: relative;'>
							<div class='span4 offset6' style='z-index: 9999; position: absolute; display: block; margin-top: 45px;'>
				 				<img src='".$_SESSION['categoriasImagePrefix'] . $categoria['imagem']."' />
				 			</div>
						<img src='".$img."' />
					</div>
					".$mid."
				</a>
			</div>
		</li>
		<hr class='span10'>";
		
		$c++;
	}
	
	$_SESSION['searchIndex'] = $index;
	
	if ($action == "prev" || $action == "next")
		$nextPage = ceil(($index + 1)/10);
	else
		$nextPage = $action;
	
	$pagination = UpdatePagiation($nextPage, $n, "search");
	
	echo $retval . "|" . $pagination;
	
	return;	
}



?>