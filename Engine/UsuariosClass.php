<?php

require_once ("DatabaseClass.php");
require_once ("LogClass.php");
require_once ("GruposClass.php");

Class UserType
{
	const NONE = 0;
	const USER_COMMON = 1;
	const USER_ADMIN = 2;
}

Class Usuarios
{
	public $login;
	public $Type;
    public $Nome;
    public $Grupo;
    public $Email;
	public $Id;
	public $isAdmin;

    protected $user_array;

    public function __construct()
    {
        $bd = Database::singleton("localhost", "root", "root", "biblioteca");
    }

    private function InitUsuario()
    {
        $this->Id = $this->user_array['id'];
        $this->Nome = $this->user_array['nome'];
		$this->Email = $this->user_array['email'];
		$this->isAdmin = $this->user_array['isadmin'];
		$this->Grupo = $this->user_array['grupo'];

        session_start();
		$_SESSION['logado'] = true;
        $_SESSION['usuario'] = $this;

		// Inicializa o log do usuário
		$log = Log::singleton($this->id);
    }

	// adiciona um novo usuario
	public function ValidaLogin($_login, $_senha)
	{
	    $bd = Database::singleton();

        $where_cond = array("login" => $_login, "senha" => $_senha);
        $clauses = array("AND");
        $rows = $bd->Select("usuarios", NULL, $where_cond, $clauses);

		$res = reset($rows);

        if ($res == null || !isset($res))
        {
            return FALSE;
        }

        $this->user_array = $res;
        $this->login = $_login;

        $this->InitUsuario();

		return TRUE;
	}

    public function AdicionaUsuario($_nome, $_login, $_senha, $_grupo, $_email)
    {
        $bd = Database::singleton();

        $pass = md5(sha1($_senha));

        $values = array("login" => $_login, "senha" => $pass, "nome" => $_nome, "email" => $_email, "grupo" => $_grupo);

        $result = $bd->Insert("usuarios", $values);

        return $result;
    }

	// Altera os dados passados de um usuario.
    public function AlteraUsuario($id, $_nome, $_email, $grupo)
    {
    	$bd = Database::singleton();

		$values = array();
		if (isset($_nome))
		{
			$values["nome"] = $_nome;
		}
		if (isset($_email))
		{
			$values["email"] = $_email;
		}
		if (isset($grupo))
		{
			$values["grupo"] = $grupo;
		}

		$where_clauses = array("id" => $id);

		$result = $bd->Update("usuarios", $values, $where_clauses, NULL);

		return $result;
    }

	public function GetUserType($login)
	{
		return UserType::NONE;
	}

	public function ListaUsuarios()
	{
		$bd = Database::singleton();

		$result = $bd->Select("usuarios", null, null, null);

		return $result;
	}

	public function GetUsuarioByID($id)
	{
		$bd = Database::singleton();

		$where = array("id" => $id);
		$result = $bd->Select("usuarios", null, $where, null);

		return $result[0];
	}

	public function RemoveUsuario($id)
	{
		$bd = Database::singleton();

		$where = array("id" => $id);
		$result = $bd->Delete("usuarios", $where, null);

		return $result;
	}
	
	public function GetAdminUser()
	{
		$bd = Database::singleton();

		$where = array("isadmin" => 1);
		$result = $bd->Select("usuarios", null, $where, null);

		return $result[0];		
	}
}

?>
