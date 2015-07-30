<?php

require_once("../Engine/DatabaseClass.php");

echo "Testes usuarios<br><br>";
$data = new Database("localhost", "root", "root", "");

echo "Teste INSERT:<br>";
$params = array("Parametro1" => "1","Parametro2" => "2");
$data->Insert("teste", $params);

echo "<br><br>";
echo "Teste DELETE<br>";

$where_clauses = array("Parametro1" => "1", "Parametro2" => "2");
$union_clauses = array("AND");
$data->Delete("teste", $where_clauses, $union_clauses);

echo "<br><br>";
echo "Teste UPDATE<br>";

$values = array("Nome" =>  "Jose", "Idade" => "20");
$where_clauses = array("Parametro1" => "1", "Parametro2" => "2");
$union_clauses = array("AND");
$data->Update("teste", $values, $where_clauses, $union_clauses);

echo "<br><br>";
echo "Teste SELECT<br>";

$where_clauses = array("Parametro1" => "1", "Parametro2" => "2");
$union_clauses = array("AND");
$data->Select("teste", null, $where_clauses, $union_clauses);

echo "<br><br>";
echo "Teste SELECT 2<br>";

$cols = array("nome", "idade");
$where_clauses = array("Parametro1" => "1", "Parametro2" => "2");
$union_clauses = array("AND");
$data->Select("teste", $cols, $where_clauses, $union_clauses);

?>