<?php
include ("InicializaPagina.php");

require_once ("Controller/Categorias.php");

require_once ("Controller/Arquivos.php");

require_once ("Controller/Grupos.php");
?>

<!-- Inicio do HTML -->

	<?php
	include ("header.php");

	$marca = $_SESSION['marca'];

	$categoria = $_SESSION['categoria'];

	// Reseta index de arquivos

	if (isset($_SESSION['arquivosIndex'])) {
		$_SESSION['arquivosIndex'] = 0;
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

		             <div class="span11" style="margin-bottom: 8px;">

				 		<img class="first-image" style="width:107px; height:114px;" src="<?php echo $_SESSION['marcasImagePrefix'] . $marca['imagem']; ?>" />

				 		<img class="first-image" style="width:106px; height:109px;" src="<?php echo $_SESSION['categoriasImagePrefix'] . $categoria['imagem']; ?>" />

					 </div>

	                     

		             <div class="span11">

					 	<div class="span2">

					 		<?php

							$outras_cats = GetCategorias();

							$catAcessos = GetCategoriasAutorizadas($_SESSION['usuario']);

							$n = count($outras_cats);
					 		?>

		                	<div class="miniaturas">

		                		<?php

		                		$c = 0;

		                		for ($i = 0; $i < $n; $i++)
								{
									if ($outras_cats[$i]['id'] == $categoria['id'])
										continue;

									$access = in_array($outras_cats[$i]['id'], $catAcessos);
									if (!$access)
										continue;

									if ($c == 2)
									{
										$c = 1;
										echo "<br>";
									}

		                		?>
                                
		                			<div class="span5" style="margin-left: 8px; margin-top: 2px;">
		                				<a href="Controller/Direciona.php?id=<?php echo $outras_cats[$i]['id']; ?>&nome=pasta"
		                					data-toggle="tooltip" title="<?php echo $outras_cats[$i]['nome']; ?>">
			                				<img src="<?php echo $_SESSION['categoriasImagePrefix'] . $outras_cats[$i]['imagem']; ?>"
			                					  alt="<?php echo $outras_cats[$i]['nome']; ?>" width="53" height="50">
		                				</a>
		                			</div>

			            		<?php

								$c++;

								}
			            		?>

		                	</div>

		                </div>

		             	

		              	<div class="span10 inline" style="margin-bottom: 80px;" id="albuns-lista">
	
		              		<?php

		              		$albuns = GetAlbunsByMarca($marca['id'], $categoria['id']);

							if (!isset($_SESSION['albumIndex']))
							{
								$_SESSION['albumIndex'] = 0;
							}

							$index = $_SESSION['albumIndex'];

					
							$n = count($albuns);
							if ($n == 0)
							{
								echo "<div class='alert alert-info'>No hay álbun agregado.</div>";
							}

							$c = 0;
							for ($i = $index; $i < $n; $i++)
							{
								if ($c == 10)
									break;

							?>
								<div class="span2" style="z-index: 100; width: 80px; height: 120px; position: relative; margin-top: 20px; margin-right: 40px;
								<?php if ($i == 0) { echo 'margin-left: 15px;'; } ?>">
									<a href="arquivos.php?album=<?php echo $albuns[$i]['id']; ?>">
							 			<div class="span4 offset7" style="z-index: 9999; position: absolute; display: block; margin-top: 45px;">
							 				<img src="<?php echo $_SESSION['categoriasImagePrefix'] . $categoria['imagem']; ?>" />
							 			</div>
							 			<img  src="img/pasta.png" />
							 			<p align="center" class="btn btn-link" style="padding-left: 5px;"><?php echo $albuns[$i]['nome']; ?></p>
						 			</a>
								</div>
							<?php
								$c++;
							}
		              		?>

					 	</div>

					 	<div class="pagination offset5" id="paginas-lista">

	              			<ul>

	              				<?php

								if ($index == 0)

									echo "<li class='disabled'><a href='#'><span>Prev</a></span></li>";
								
								else

									echo "<li><a href='#' onclick='ChangePage(\"prev\", \"albuns\");'><span>Prev</a></span></li>";

								$page = ceil(($index + 1) / 10);

								$pages = ceil($n / 10);

								for ($j = 1; $j <= $pages; $j++) {

									if ($j == $page)

										echo "<li class='disabled'><a href='#'><span>" . $j . "</span></a></li>";
									
									else

										echo "<li><a href='#' onclick='ChangePage(" . $j . ", \"albuns\");'><span>" . $j . "</span></a></li>";

								}

								if (($index + 10) >= $n)

									echo "<li class='disabled'><a href='#'><span>Next</span></a></li>";
								
								else

									echo "<li><a href='#' onclick='ChangePage(\"next\", \"albuns\");'><span>Next</span></a></li>";
								?>

						  	</ul>

						</div>

	             	</div>

	  			 </div>

         	</div>

         </div>

     </body>

 </html>