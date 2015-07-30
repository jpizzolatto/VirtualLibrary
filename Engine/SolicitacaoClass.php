<?php

require_once ("DatabaseClass.php");
require_once("UsuariosClass.php");

Class Solicitacao
{
	public function __construct()
	{
		$bd = Database::singleton("localhost", "root", "", "biblioteca");
	}

    // aduucuibar uma solicitação d eum novo trabalho
	public function AdicionarSolicitacao($_user, $_perguntas, $_arquivos)
	{
		$bd = Database::singleton();

        $values = array("usuario" => $_user, "perguntas" => $_perguntas, "estado" => "NOK");
        $ret = $bd->Insert("solicitacoes", $values);
		
		$id = null;

        if ($ret)
        {
            $col = array("id");
            $ids = $bd->Select("solicitacoes", $col, null, null, 5, "id DESC");

            if (count($ids) > 0)
            {
                $id = $ids[0];
            }
        }

        return $id['id'];
	}
	
	public function AdicionarCaminhosSolicitacao($id, $caminho)
	{
		$bd = Database::singleton();
		
		if (!isset($caminho))
		{
			echo "<meta charset='utf-8'><script type='text/javascript'>alert('Solicitacao enviada.');</script>";
			return FALSE;
		}
		
		$value = array("caminho" => $caminho);
		$where = array("id" => $id);
		$ret = $bd->Update("solicitacoes", $value, $where, null);
		
		if ($ret == FALSE)
		{
			echo "<meta charset='utf-8'><script type='text/javascript'>alert('Falha ao enviar a solicitação.');</script>";	
		}
		else 
		{
			echo "<meta charset='utf-8'><script type='text/javascript'>alert('Solicitação enviada com sucesso.');</script>";
		}
		
		return $ret;
	}

    // Adicionar pedido de alteração de algum arquivo
    public function AdicionarAlteracao($_user, $_perguntas, $_arquivos, $_idArquivo)
    {
        $bd = Database::singleton();

        $values = array("usuario" => $_user, "perguntas" => $_perguntas, "id_arquivo" => $_idArquivo, "estado" => "NOK");
        $ret = $bd->Insert("solicitacoes", $values);

		$id = null;
		
        if ($ret)
        {
            $col = array("id");
            $ids = $bd->Select("solicitacoes", $col, null, null, 5, "id DESC");

            if (count($ids) > 0)
            {
                $id = $ids[0];
            }
        }

        return $id['id'];
    }

	public function GetSolicitacoesAbertas()
	{
		$bd = Database::singleton();

		$where = array("estado" => "NOK");
		$result = $bd->Select("solicitacoes", NULL, $where, NULL, NULL, "id DESC");

		return $result;
	}

	public function AlteraEstadoSolicitacao($_id, $_novoEstado)
	{
		$bd = Database::singleton();

		if ($_novoEstado != "OK" ||
			$_novoEstado != "NOK")
			{
				return FALSE;
			}

		$values = array("estado" => $_novoEstado);
		$where = array("id" => $_id);
		$result = $bd->Update("solicitacoes", $values, $where, NULL);

		return $result;
	}
	
	public function GetSolicitacaoByID($id)
	{
		$bd = Database::singleton();

		$where = array("id" => $id);
		$result = $bd->Select("solicitacoes", NULL, $where, NULL);

		return $result[0];
	}
	
	public function RemoverSolicitacao($id)
	{
		$bd = Database::singleton();
		
		$sol = $this->GetSolicitacaoByID($id);
		
		if ($sol['caminho'] != "")
		{
			$files = explode(",", $sol['caminho']);
			
			$n = count($files);
			for ($i = 0; $i < $n; $i++)
			{
				$dir = dirname($files[$i]);
				Arquivos::RemoveFile($files[$i]);	
			}
			rmdir($dir . "/");
		}

		$where = array("id" => $id);
		$result = $bd->Delete("solicitacoes", $where, NULL);
		
		if ($result == TRUE)
		{
			header("location: ../solicitacoes-lista.php?status=success");	
		}
		else
		{
			header("location: ../solicitacoes-lista.php?status=error");
		}
		
		
		return $result;
	}
}

?>