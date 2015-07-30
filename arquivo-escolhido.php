<?php

include ("InicializaPagina.php");



require_once("Controller/Categorias.php");
require_once("Controller/Arquivos.php");
require_once("Controller/Grupos.php");
require_once("Controller/Marcas.php");

?>

<!-- Inicio do HTML -->

	<?php

	include ("header.php");

	

	$id = $_GET['id'];
	
	$arquivo = GetArquivo($id);
	
	$album = GetAlbum($arquivo['album']);
	$_SESSION['currAlbum'] = $album;
	
	$marca = $_SESSION['marca'];
	if (!isset($marca) || $marca != $album['marca'])
	{
		selecionaMarca($album['marca']);
	}
	
	$categoria = $_SESSION['categoria'];
	if (!isset($categoria) || $categoria != $album['categoria'])
	{
		selecionaCategoria($album['categoria']);
	}

	$_SESSION['arquivo-escolhido'] = $arquivo;

	

	$file = $arquivo['arquivo1'];
	if ($file == NULL)
	{
		$file = $arquivo['arquivo2'];
		if ($file == NULL)
		{
			$file = $arquivo['arquivo3'];
		}
	}

	$img = GetImageFromType($arquivo);

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

		             <div class="span6">
			 			<div class="span3 album-icon">
		             		<img class="first-image" width="107" height="114" src="<?php echo $_SESSION['marcasImagePrefix'] . $marca['imagem']; ?>" />	
		             	</div>
				 		<div class="span3 album-icon" style="margin-left: -35px;">
				 			<a href="Controller/Direciona.php?id=<?php echo $categoria['id']; ?>&nome=pasta" data-toggle="tooltip" title="<?php echo $categoria['nome']; ?>">
				 				<img class="first-image" width="106" height="109" src="<?php echo $_SESSION['categoriasImagePrefix'] . $categoria['imagem']; ?>" />
				 			</a>
				 		</div>
			 			
				 		<div Style="width: 140px; padding-top: 5px;">

					 		<?php

					 		$outras_cats = GetCategorias();

							$catAcessos = GetCategoriasAutorizadas($_SESSION['usuario']);

							

							$n = count($outras_cats);

					 		?>

		                	<ul class="unstyled inline" style="margin-top: 20px;">

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

										echo "</ul><ul class='unstyled inline'>";

									}

		                		?>

		                			<li style="margin-top: 3px; margin-left: 2px; padding: 0px; width: 53px; height: 50px;" class="span5">
		                				<a href="Controller/Direciona.php?id=<?php echo $outras_cats[$i]['id']; ?>&nome=pasta"
		                				   data-toggle="tooltip" title="<?php echo $outras_cats[$i]['nome']; ?>">
			                				<img src="<?php echo $_SESSION['categoriasImagePrefix'] . $outras_cats[$i]['imagem']; ?>"
			                					  alt="<?php echo $outras_cats[$i]['nome']; ?>" width="47" height="42">
		                				</a>	
		                			</li>

			            		<?php

			            			$c++;

								}

			            		?>

		                	</ul>

					 	</div>

                    </div>

                    

              		<div class="span1" style="margin-top: 22px; margin-left: -80px;">

	              		<div id="escolhida" class="span10 offset4">

							<div class="span5" style="padding-top: 5px; padding-bottom: 10px;">
								
								<?php
									$real_width = 130;
									$real_height = 130;
									
									if ($arquivo['arquivo1'] == $img ||
										$arquivo['arquivo2'] == $img ||
										$arquivo['arquivo3'] == $img)
										{
											list($real_width, $real_height, $type, $attr) = getimagesize($img);
										
											$width = $real_width * 0.4;
											$height = $real_height * 0.4;
										}

									else 
									{
										$width = 130;
										$height = 130;
									}

								?>
								<a href="#" onclick="OpenImage();">

									<img class="foto-escolhida" width="<?php echo $width; ?>"
										  height="<?php echo $height; ?>" src="<?php echo $img;?>" />

								</a>

							</div>

	                    	<div class="span4 offset1" style="padding-top: 20px;">

	                    		<h5><?php echo $arquivo['nome']; ?></h5>

	                    		<p><?php echo $arquivo['descricao']; ?></p>

	                    	</div>

	                    </div>

			             

			             <div class="span6 offset4" Style="width: 430px;">

				             <table class="table table-bordered">

				             	<tr>

					                <td>Formato</td>

					                <td>Tamaño</td>

					                <td>Tipo</td>

				                </tr>

				                

			                	<?php

			                	$file1 = $arquivo['arquivo1'];

								if ($file1 != NULL)

								{

									$file1 = substr($file1, 3, strlen($file1));

									$ext = pathinfo($file1, PATHINFO_EXTENSION);

									$size = formatBytes(filesize(utf8_decode($file1)), 2);

									$type = $arquivo['tipo'];

								?>

					                <tr>

										<td><?php echo strtoupper ($ext); ?> <a href="download.php?file=<?php echo $file1; ?>"><img src="img/download.png"></a></td>

						                <td><?php echo $size; ?></td>

						                <td><?php echo $type; ?></td>

					                </tr>

								<?php

								}

			                	?>

			                	

			                	<?php

			                	$file2 = $arquivo['arquivo2'];

								if ($file2 != NULL)

								{

									$file2 = substr($file2, 3, strlen($file2));

									$ext = pathinfo($file2, PATHINFO_EXTENSION);

									$size = formatBytes(filesize(utf8_decode($file2)), 2);

									$type = $arquivo['tipo'];

								?>

					                <tr>

										<td><?php echo strtoupper($ext); ?> <a href="download.php?file=<?php echo $file2; ?>"><img src="img/download.png"></a></td>

						                <td><?php echo $size; ?></td>

						                <td><?php echo $type; ?></td>

					                </tr>

								<?php

								}

			                	?>

			                	

			                	<?php

			                	$file3 = $arquivo['arquivo3'];

								if ($file3 != NULL)

								{

									$file3 = substr($file3, 3, strlen($file3));

									$ext = pathinfo($file3, PATHINFO_EXTENSION);

									$size = formatBytes(filesize(utf8_decode($file3)), 2);

									$type = $arquivo['tipo'];

								?>

					                <tr>

										<td><?php echo strtoupper($ext); ?> <a href="download.php?file=<?php echo $file3; ?>"><img src="img/download.png"></a></td>

						                <td><?php echo $size; ?></td>

						                <td><?php echo $type; ?></td>

					                </tr>

								<?php

								}

			                	?>

				             </table>

				             <div class="span12 offset2">

			             		<div class="alteracao span5">

			               			 <a href="solicitacoes.php?id=<?php echo $id; ?>" style="color: white; text-decoration: none;">¿Necesidad de cambio?</a>

			                	</div>

			                	<div class="trabalho span5">

			               		 	<a style="color: white; text-decoration: none;" href="solicitacoes.php">Solicitar un nuevo trabajo</a>

			                	</div>             

			                </div>

			                <div class="span6">

			                	

			                </div>

			             </div>


		             </div>

	  			 </div>

         	</div>

         </div>
         
         <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		  <div class="modal-header">
		    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		    <h4 id="myModalLabel"><?php echo $arquivo['nome']; ?></h4>
		  </div>
		  <div class="modal-body">
		  	<img src="<?php echo $img;?>" width="<?php echo $$real_width; ?>" height="<?php echo $real_height; ?>"/>
		  </div>

		  <div class="modal-footer">
		  	<p><?php echo $arquivo['descricao']; ?></p>
		  </div>
		</div>

     </body>

 </html>