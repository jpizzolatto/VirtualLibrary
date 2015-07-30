<?php



include ("InicializaPagina.php");



?>



<!-- Inicio do HTML -->

	<?php

	include ("header.php");

	?>

    

    <?php

    	require_once("Controller/Categorias.php");

		require_once("Controller/Grupos.php");

    

		$marca = $_SESSION['marca'];

		$categorias = GetCategorias();

		$catAcessos = GetCategoriasAutorizadas($_SESSION['usuario']);

		

		// Reseta index de albuns

		if (isset($_SESSION['albumIndex']))

		{

			$_SESSION['albumIndex'] = 0;

		}

    ?>



    <body>

		<div class="container">



			<div class="row-fluid span11">



				<div class="row-fluid">

					<?php

					include ("topo.php");

					?>

				</div>



				<div class="row-fluid">

					<?php

					include ("marcasLista.php");

					?>

				</div>

             

	             <div class="row-fluid">

		             <div class="span11">

					 	<div id="pastas">

							<img class="first-image" style="width:107px; height:114px;" src="<?php echo $_SESSION['marcasImagePrefix'] . $marca['imagem']; ?>" />

							

							<?php

							

							$n = count($categorias);

							

							if ($n == 0)

							{

								echo "<div class='alert alert-info'>No hay categoría agregada.</div>";

							}

							else

							{

								for ($i = 0; $i < $n; $i++)

								{

									$access = in_array($categorias[$i]['id'], $catAcessos);

									if (!$access)

										continue;

								?>

									<a href="Controller/Direciona.php?id=<?php echo $categorias[$i]['id']; ?>&nome=pasta">

										<img class="pasta-image" src="<?php echo $_SESSION['categoriasImagePrefix'] . $categorias[$i]['imagem']; ?>" />

									</a>	

								<?php

									

								}

							}

							?>

						</div>

					</div>

	             </div>

         	</div>

         </div>

     </body>

</html>