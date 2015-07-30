<?php

require_once ("../Engine/UsuariosClass.php");

$user = new Usuarios();

// Teste com login correto, senha errada
echo "<br><br>";
echo "TESTE VALIDA USUARIO<br>";
echo "Login: admin / Senha: errada<br>";
$ret = $user->ValidaLogin("admin", "errada");
echo $ret? "TRUE" : "FALSE";

// Teste com login errado e senha correta
echo "<br><br>";
echo "TESTE VALIDA USUARIO<br>";
echo "Login: errado / Senha: admin<br>";
$ret = $user->ValidaLogin("errado", "admin");
echo $ret? "TRUE" : "FALSE";


// Teste com login e senha corretos
echo "<br><br>";
echo "TESTE VALIDA USUARIO<br>";
echo "Login: admin / Senha: admin<br>";
$ret = $user->ValidaLogin("admin", md5(sha1("admin")));
echo $ret? "TRUE" : "FALSE";

echo "<br><br>";
echo "TESTE INIT USUARIO<br>";
echo "Nome: " . $user->Nome . "<br>";
echo "Email: " . $user->Email . "<br>";

echo "<br><br>";
echo "TESTE ADICIONAR NOVO USUARIO<br>";
$ret = $user->AdicionaUsuario("Jorge", "jorgepzt", "manu", "0", "jorge.pzt@gmail.com");
echo $ret? "TRUE" : "FALSE";

?>