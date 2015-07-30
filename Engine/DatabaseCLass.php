<?php

Class Database
{
    static private $instance;

    // Variaives para conexão do Banco
    protected $host;
    protected $user;
    protected $pass;
    protected $db_name;

    // Variavel de conexão
    protected $connection;
    protected $sqli;

    private function __construct($_host, $_user, $_pass, $_db)
    {
        $this->host = $_host;
        $this->user = $_user;
        $this->pass = $_pass;
        $this->db_name = $_db;

        $this->sqli = mysqli_init();
        if (!$this->sqli)
        {
            die("Error to init mysql.");
        }

        // Check connection
        if (!mysqli_real_connect($this->sqli, $this->host, $this->user, $this->pass, $this->db_name))
        {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
            die();
        }

		$this->sqli->set_charset('utf8');
    }

    // O método singleton
    static public function singleton($_host = null, $_user = null, $_pass = null, $_db = null)
    {
        $_host = "db_host";
        $_user = "username";
        $_pass = "password";
        $_db = "db_name";

        if (!isset(self::$instance))
        {
            $c = __CLASS__;
            self::$instance = new $c($_host, $_user, $_pass, $_db);
        }

        return self::$instance;
    }

    function __destruct()
    {
        if (!$this->sqli->close())
        {
            echo "Failed to disconnect to MySQL: " . mysqli_connect_error();
            die();
        }
    }

    // Método para inserir em um tablea, alguns valores passador através de um vetor.
    // $table - Tabela ao qual os valore serão inseridos
    // $values - Os valores que serão inseridos nos parâmetros da tabela, indexados pelo parâmetros
    //           No tipo Parametro1 => valor1, Parametro2 => valor2
    public function Insert($table, $values)
    {
        // Constroi a lista de parametros a partir de um vetor
        $listParams = "";
        $listValues = "";
        foreach ($values as $param => $value)
        {
            $listParams = $listParams . $param . ",";
            $listValues = $listValues . "'$value'" . ",";
        }
        // Remove a ultima virgula
        $listParams = substr_replace($listParams, "", -1);
        $listValues = substr_replace($listValues, "", -1);

        $cmd = "INSERT INTO $table ($listParams) VALUES ($listValues)";

        if (!$this->sqli->query($cmd))
        {
            echo "Failed to insert values: " . $this->sqli->error;
            return FALSE;
        }

        return TRUE;
    }

    // Método para deletar linhas de uma tabela
    // $table - Tabela ao qual as linhas serão deletadas
    // $where_cond - Clausulas de checagem para especificar o que será deletado
    //					Deverá ter o formato (Parametro => Valor) = Parametro LIKE Valor
    // $clauses - Caso exista mais de uma clausula where, deverá existir um lógica de união
    //					entre elas, como por exemplo 'AND', 'OR' e assim por diante
    public function Delete($table, $where_cond, $clauses)
    {
        $where = "";
        $n = 0;
        // Cria todas as clausulas WHERE, unindo com os valores
        // de união, de acordo com a ordem
        if (!$where_cond)
        {
            $where = "1";
        }
        else
        {
            foreach ($where_cond as $param => $value)
            {
                $where = $where . " $param LIKE '$value' ";

                if ($clauses && $clauses[$n])
                {
                    $where = $where . " $clauses[$n] ";
                    $n++;
                }
            }
        }

        $cmd = "DELETE FROM $table WHERE $where";

        if (!$this->sqli->query($cmd))
        {
            echo "Failed to delete: " . $this->sqli->error;
            return FALSE;
        }

        return TRUE;
    }

    // Método para alterar valores listados em $values na tabela $table.
    // Respeitando as clausulas definidas.
    // $table - Tabela ao qual as linhas serão deletadas
    // $values - Os valores que serão alterados na tabela, indexados pelo parâmetros
    //           No tipo Parametro1 => valor1, Parametro2 => valor2
    // $where_cond - Clausulas de checagem para especificar o que será deletado
    //                  Deverá ter o formato (Parametro => Valor) = Parametro LIKE Valor
    // $clauses - Caso exista mais de uma clausula where, deverá existir um lógica de união
    //                  entre elas, como por exemplo 'AND', 'OR' e assim por diante
    public function Update($table, $values, $where_cond, $clauses)
    {
        $listValues = "";
        // Cria todas as clausulas WHERE, unindo com os valores
        // de união, de acordo com a ordem
        foreach ($values as $param => $value)
        {
            $listValues = $listValues . " $param = '$value',";
        }
        $listValues = substr_replace($listValues, "", -1);

        $n = 0;
        $where = "";
        // Cria todas as clausulas WHERE, unindo com os valores
        // de união, de acordo com a ordem
        if (!$where_cond)
        {
            $where = "1";
        }
        else
        {
            foreach ($where_cond as $param => $value)
            {
                $where = $where . " $param LIKE '$value' ";

                if ($clauses && $clauses[$n])
                {
                    $where = $where . " $clauses[$n] ";
                    $n++;
                }
            }
        }

        $cmd = "UPDATE $table SET $listValues WHERE $where";

        if (!$this->sqli->query($cmd))
        {
            echo "Failed to update: " . $this->sqli->error;
            return FALSE;
        }

        return TRUE;
    }

    // Selecions na tabela $table, as colunas pedidas, respeitando as clausulas
    // passadas pelo usuario. Caso não passe nenhuma coluna, retorna-se todas.
    // $table - Tabela ao qual as linhas serão deletadas
    // $selectCols - As colunas que serão buscadas pelo metodo, caso passe null,
    //               o metodo busca todas as colunas.
    // $where_cond - Clausulas de checagem para especificar o que será deletado
    //                  Deverá ter o formato (Parametro => Valor) = Parametro LIKE Valor
    // $clauses - Caso exista mais de uma clausula where, deverá existir um lógica de união
    //                  entre elas, como por exemplo 'AND', 'OR' e assim por diante
    // RETURNS:
    // As linhas selecionadas. Para percorrer os valores,
    // deve-se utilizar a função mysqli_fetch_array($rows).
    public function Select($table, $selectCols, $where_cond, $clauses, $limit = null, $order = null)
    {
        $select = "";
        if (!$selectCols)
        {
            $select = "*";
        }
        else
        {
            foreach($selectCols as $cols)
            {
                $select = $select . $cols . ",";
            }
            $select = substr_replace($select, "", -1);
        }

		$m = count($clauses);
        $n = 0;
        $where = "";
        // Cria todas as clausulas WHERE, unindo com os valores
        // de união, de acordo com a ordem
        if (!$where_cond)
        {
            $where = "1";
        }
        else
        {
            foreach ($where_cond as $param => $value)
            {
                $where = $where . " $param LIKE '$value' ";

                if ($m > 0 && $n < $m)
                {
                    $where = $where . " $clauses[$n] ";
                    $n++;
                }
            }
        }

		$cmd = "SELECT $select FROM $table WHERE $where";

		if (isset($order))
		{
			$cmd .= " ORDER BY $order";
		}

		if (isset($limit))
		{
			$cmd .= " LIMIT $limit";

		}
		
        $rows = $this->sqli->query($cmd) or die ("Failed to select " . mysqli_error());

		$result = array();
        while($row = mysqli_fetch_assoc($rows))
		{
			$chaves = array_keys($row);
			$n = count($chaves);
			$value = array();

			for ($i=0; $i < $n; $i++)
			{
				$chave = $chaves[$i];
				$value[$chave] = $row[$chave];
			}

			array_push($result, $value);
		}

		return $result;
    }
}
?>