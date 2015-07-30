<?php
require_once ("Controller/Marcas.php");

$marcas = ListaMarcas();

$n = count($marcas);

if ($n > 0) {

	if (!isset($_SESSION['indexMarcas'])) {

		$_SESSION['indexMarcas'] = 0;

	}

}
?>

<div class="span10" style="margin-bottom: 20px;">

	<div id="marcas">

		<a href="#" onclick="SlideMarcas('volta')"><img class="seta-left" src="img/seta1.png" </a>

		<a href="#" onclick="SlideMarcas('avanca')"><img class="seta-right" src="img/seta2.png"></a>

		<div id="marcas-lista" class="span9">

		<?php

		if ($n == 0)

		{

		echo "<br><br>No hay categoría agregada";

		}

		$index = $_SESSION['indexMarcas'];

		$m = $index + 5;

		$c = 0;

		for ($i = $_SESSION['indexMarcas']; $i < $m && $i < $n; $i++)

		{

		?>

		<a href="Controller/Direciona.php?id=<?php echo $marcas[$i]["id"]; ?>&nome=marcas" class="marca-box">

		<img class="box-marcas" src="<?php echo $_SESSION['marcasImagePrefix'] . $marcas[$i]["imagem"]; ?>" width="107" height="114"> </a>

		<?php

		$c++;

		}
		?>
	</div>

</div>

</div>