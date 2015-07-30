<?php

require_once ("DatabaseClass.php");
require_once ("CategoriasClass.php");
require_once ("MarcasClass.php");

Class Arquivos
{
	public function __construct()
	{
		$bd = Database::singleton("localhost", "root", "", "biblioteca");
	}
	
	public function AdicionaArquivo($_nome, $_desc, $_tipo, $_arquivo1, $_arquivo2, $_arquivo3, $_album)
	{
		$bd = Database::singleton();
		
		$values = array("nome" => $_nome, "album" => $_album, 
						"descricao" => $_desc, "tipo" => $_tipo);
		
		if ($_arquivo1 != NULL)
		{
			$values["arquivo1"] = $_arquivo1;
		}
		if ($_arquivo2 != NULL)
		{
			$values["arquivo2"] = $_arquivo2;
		}
		if ($_arquivo3 != NULL)
		{
			$values["arquivo3"] = $_arquivo3;
		}
		
		$result = $bd->Insert("arquivos",  $values);
		
		return $result;
	}
	
	public function RemoveArquivo($_id)
	{
		$bd = Database::singleton();
		
		$where = array("id" => $_id);
		$result = $bd->Delete("arquivos",  $where, null);
		
		return $result;
	}
	
	public function AlteraArquivo($_id, $_nome = null, $_desc = null, $_tipo = null, $_arquivo1 = null, $_arquivo2 = null, $_arquivo3 = null)
	{
		$bd = Database::singleton();
		
		$values = array();
		if (isset($_nome))
		{
			$values["nome"] = $_nome;
		}
		if (isset($_desc))
		{
			$values["descricao"] = $_desc;
		}
		if (isset($_tipo))
		{
			$values["tipo"] = $_tipo;
		}
		if (isset($_arquivo1))
		{
			$values["arquivo1"] = $_arquivo1;
		}
		if (isset($_arquivo2))
		{
			$values["arquivo2"] = $_arquivo2;
		}
		if (isset($_arquivo3))
		{
			$values["arquivo3"] = $_arquivo3;
		}
		
		$where = array("id" => $_id);
		$result = $bd->Update("arquivos", $values, $where, null);
		
		return $result;
	}
	
	public function GetArquivosRecentes()
	{
		$bd = Database::singleton();
		
		$result = $bd->Select("arquivos", null, null, null, null, "id DESC");

		$list = array();
		if (count($result) == 0)
			return null;
		
		$j = 0;
		$i = 0;
		while($i < 10)
		{
			$path = "";
			if (strlen($result[$j]['arquivo1']) > 0)
			{
				$path = $result[$j]['arquivo1'];
			}
			else if (strlen($result[$j]['arquivo2']) > 0)
			{
				$path = $result[$j]['arquivo2'];
			}
			else if (strlen($result[$j]['arquivo3']) > 0)
			{
				$path = $result[$j]['arquivo3'];
			}
			else
			{
				$j++;
				continue;
			}
			
			if (file_exists(substr($path, 3, strlen($path))))
			{
				$list[$i] = $result[$j];
				$i++;
				$j++;	
			}
			else
			{
				$j++;	
			}
		}
		
		return $list;
	}
	
	public function GetArquivosMaisBaixados()
	{
		$bd = Database::singleton();
		
		$result = $bd->Select("arquivos", null, null, null, null, "ndownloads DESC");
		
		$list = array();
		if (count($result) == 0)
			return null;
		
		$j = 0;
		$i = 0;
		while($i < 10)
		{
			$path = "";
			if (strlen($result[$j]['arquivo1']) > 0)
			{
				$path = $result[$j]['arquivo1'];
			}
			else if (strlen($result[$j]['arquivo2']) > 0)
			{
				$path = $result[$j]['arquivo2'];
			}
			else if (strlen($result[$j]['arquivo3']) > 0)
			{
				$path = $result[$j]['arquivo3'];
			}
			else
			{
				$j++;
				continue;
			}
			
			if (file_exists(substr($path, 3, strlen($path))))
			{
				$list[$i] = $result[$j];
				$i++;
				$j++;	
			}
			else
			{
				$j++;	
			}
		}
				
		return $list;
	}
	
	public function GetArquivosFromAlbum($_album)
	{
		$bd = Database::singleton();
		
		$where = array("album" => $_album);
		$result = $bd->Select("arquivos", null, $where, null);
		
		return $result;
	}
	
	public function GetArquivoByID($id)
	{
		$bd = Database::singleton();
		
		$where = array("id" => $id);
		$result = $bd->Select("arquivos", null, $where, null);
		
		return $result[0];
	}
	
	public function GetArquivosByName($name)
	{
		$bd = Database::singleton();
		
		$where = array("nome" => $name, "descricao" => $name);
		$clauses = array("OR");
		$result = $bd->Select("arquivos", null, $where, $clauses);
		
		return $result;
	}
	
	public function IncrementaDownloads($id)
	{
		$arq = $this->GetArquivoByID($id);
		
		$d = $arq['ndownloads'];
		$downloads = $d + 1;
		
		$bd = Database::singleton();
		
		$values = array("ndownloads" => $downloads);
		
		$where = array("id" => $id);
		$result = $bd->Update("arquivos", $values, $where, null);
		
		return $result;
	}
	
	static public function UpdateArquivo($caminho, $arquivo)
	{
		$arquivo1 = $arquivo;
		
		$arquivo_minusculo = strtolower($arquivo1['name']);
		$caracteres = array("ç","~","^","]","[","{","}",";",":","´",",",">","<","-","/","|","@","$","%","ã","â","á","à","é","è","ó","ò","+","=","*","&","(",")","!","#","?","`","ã"," ","©");
		
		$arquivo_tratado = str_replace($caracteres,"",$arquivo_minusculo);
		
		if ($caminho[strlen($caminho) - 1] == "/")
			$caminho = substr_replace($caminho, "", -1);
		$destino = $caminho."/".$arquivo_tratado;
		
		if (!is_dir($caminho))
		{
			mkdir(utf8_decode($caminho), 0777, TRUE);
		}

		if(move_uploaded_file($arquivo1['tmp_name'], utf8_decode($destino)))
		{
			echo "Arquivo enviado com sucesso.";
		}
		else
		{
			echo "Erro ao enviar o arquivo";
		}

		return $arquivo_tratado;		
	}
	
	static public function RemoveFile($arquivo)
	{
		$ret = unlink(utf8_decode($arquivo));
		
		return $ret;
	}
}

?>