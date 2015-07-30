<?php
session_start();

require_once("Controller/Arquivos.php");

if (isset($_SESSION['arquivo-escolhido']))
{
	if (!isset($_GET['temp']))
	{
		$arquivo = $_SESSION['arquivo-escolhido'];
		IncrementaNumeroDownloads($arquivo['id']);	
	}
}

$filename = $_GET['file'];
$ext = pathinfo($path, PATHINFO_EXTENSION);

header('Pragma: public');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Cache-Control: private', false); // required for certain browsers 
header('Content-Type: application/'.$ext);

header('Content-Disposition: attachment; filename="'. basename($filename) . '";');
header('Content-Transfer-Encoding: binary');
header('Content-Length: ' . filesize($filename));

readfile($filename);

exit;
?>