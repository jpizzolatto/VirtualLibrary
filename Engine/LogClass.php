<?php
require_once ("DatabaseClass.php");

Class Actions
{
	const CLICOU = "CLICK";
	const DOWNLOAD = "DOWNLOAD";
	const DESLOGOU = "DESLOGOU";
	const VIZUALIZOU = "VIZUALIZOU";
	const REQUISICAO = "REQUISICAO";
}

Class Log 
{
	static private $instance;
	
	protected $file = null; 

	private function __construct($_idUser, $_nomeUser) 
	{
		$filename = "../Logs/logs_user_$_idUser.txt";
		
		$this->file = fopen($filename, "a+");
		
		$header = self::criaHeader($_nomeUser);
		fwrite($this->file, $header);
	}
	
	function __destruct()
	{
		fclose($this->file);
	}
	
	private function criaHeader($_nomeUser)
	{
		$ip = $_SERVER["REMOTE_ADDR"];
		$data = date("d/m/Y, H:i");
		
		$header = "\r\n\r\n$_nomeUser LOGOU\r\nData: $data | IP: $ip\r\n";
		
		return $header;
	}
	
	public function appendText($_action, $_msg)
	{
		$data = date("d/m/Y,H:i");
		$msg = "$data,$_action,$_msg";
		
		fwrite($this->file, $msg);
	}
		
	// O método singleton
    static public function singleton($_idUser = null)
    {
        if (!isset(self::$instance))
        {
            $c = __CLASS__;
            self::$instance = new $c($_idUser);
        }

        return self::$instance;
    }

}
?>