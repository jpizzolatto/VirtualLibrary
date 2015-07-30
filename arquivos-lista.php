<?php



include ("InicializaPagina.php");



require_once ("Controller/Arquivos.php");

require_once ("Controller/Categorias.php");



$status = null;

if (isset($_GET['status']))

{

	$status = $_GET['status'];

}



if (!isset($_GET['marca']))

{

	header("location: arquivos-marcas.php?status=error");

}



$marca_id = $_GET['marca'];

$marca_name = $_GET['name'];


?>

	

<!-- Inicio do HTML -->

	<?php

	include ("header.php");

	?>



	<body>



		<div class="container">



			<div class="row-fluid span10">



				<div class="row-fluid">

					<?php

					include ("topo.php");

					?>

				</div>

                 

                 <div class="lista-arquivos">

                 <div class="span10">

                	

                	<h3 class="muted" align="center">Archivos - <?php echo $marca_name; ?></h3>

                	

                	<hr> <br>

                	

                	<?php

                	if (isset($status))

					{

						if ($status == "error")

						{

							echo "<div class='alert alert-error'>

									<button type='button' class='close' data-dismiss='alert'>&times;</button>

									Error agregar, editar o eliminar un archivo/álbum.

								 </div>";

						}

						else if ($status == "success") 

						{

							echo "<div class='alert alert-success'>

									<button type='button' class='close' data-dismiss='alert'>&times;</button>

									Archivo/álbum agregado, cambiado o eliminado correctamente!

								 </div>";

						}

					}

                	?>

                	
                	<div class="tabbable tabs-left">

						<ul class="nav nav-tabs" id="categoriasTab">

	                	<?php

							$categorias = GetCategorias();

							

							$n = count($categorias);

							for ($i = 0; $i < $n; $i++)

							{

								$id = $categorias[$i]['id'];

								$nome = $categorias[$i]['nome'];

						?>

								<li>

									<a href="#<?php echo $nome; ?>" data-toggle="tab" id="<?php echo $id; ?>">

										<?php echo $nome; ?>

									</a>

								</li>

						<?php

							}

						?>

						</ul>

					

						<div class="tab-content">

							<?php

							

							//

							// LISTA CATEGORIAS

							//

							$categorias = GetCategorias();

							$n = count($categorias);

							for ($i = 0; $i < $n; $i++)

							{

								$cat_id = $categorias[$i]['id'];

								$cat_nome = $categorias[$i]['nome'];

							?>

								<div class="tab-pane <?php if($i == 0) { echo 'active'; } ?>" id="<?php echo $cat_nome; ?>">

									

									<a href="#addAlbum" onClick="AddAlbumClick(<?php echo $cat_id; ?>);" class="offset9">

										<button class="btn btn-small btn-primary" type="button">Agregar álbum</button>

									</a>

									

									<div class="row-fluid" style="padding-top: 10px;">

										<ul class="unstyled">

										<?php

										

										//

										// LISTA ALBUNS DA CATEGORIA

										//

										$albuns = GetAlbunsByMarca($marca_id, $cat_id);

										$m = count($albuns);

										if ($m == 0)

										{

											echo "<div class='alert alert-block'>No hay álbumes creados.</div>";

										} 

										for ($j = 0; $j < $m; $j++)

										{

											$nome_album = $albuns[$j]['nome'];

											$id_album = $albuns[$j]['id'];

										?>

											<li class="lista-control">

												<div class="alert alert-info">

												<ul class="unstyled">

													<li>

														<h3 align="left"><?php echo $nome_album; ?></h3>		

													</li>

													<li>

														<a href="#alteraAlbum" onClick="EditAlbumClick(<?php echo $cat_id; ?>,<?php echo $id_album; ?>, '<?php echo $nome_album; ?>');">

															<button class="btn btn-small" type="button">Editar</button>

														</a>

														<a href="#removeAlbum" onClick="RemoveAlbumClick(<?php echo $id_album; ?>, '<?php echo $nome_album ?>');">

															<button class="btn btn-small btn-danger" type="button">Eliminar</button>

														</a>

													</li>

												</ul>

												</div>

												

								                <ul class="unstyled" style="border: 1px solid #DDDDDD;">

								                	<p style="padding: 10px;">

														<a href="add-arquivo.php?albumid=<?php echo $id_album; ?>">

															<button class="btn btn-small" type="button">Agregar archivo en álbun</button>

														</a>

								                	</p>

							                	<?php

							                	

							                	//

												// LISTA ARQUIVOS DO ALBUM

												//

							                	$arquivos = GetArquivosByAlbum($id_album);

												$x = count($arquivos);

												if ($x == 0)

												{

													echo "<div class='alert alert-block'>No hay archivos agregados.</div>";

												}

												for ($k = 0; $k < $x; $k++)

												{

													$nome = $arquivos[$k]['nome'];

													$id = $arquivos[$k]['id'];

							                	?>

													 <li class="lista-control" style="padding: 10px;">

													 	<div class="span9">

													 		<p>

													 			<i class="icon-file"></i>

													 			<?php echo $nome; ?>

													 		</p>

													 	</div>

													 	<div class="span3">

													 		<a href="altera-arquivo.php?id=<?php echo $id; ?>"><button class="btn btn-mini" type="button">Editar</button></a>

															<a href="#myModal" onClick="RemoveArquivoClick(<?php echo $id; ?>, '<?php echo $nome ?>', <?php echo $id_album; ?>);">

																<button class="btn btn-mini btn-danger" type="button">Eliminar</button>

															</a>

													 	</div>

								                    </li>

								                    <hr>

							                    <?php

												}

												?>

							                	</ul>	

											</li>									

										<?php

										}

										?>

										</ul>

									</div>

								</div>

							<?php

							}

							?>

							</div>

						</div>

					</div>

                </div>

			</div>

     	</div>

     	

     	<!-- Janela modal para remover arquivos -->

     	     	

        <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

		  <div class="modal-header">

		    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>

		    <h3 id="myModalLabel">Eliminar archivo</h3>

		  </div>

		  <div class="modal-body">

		    <p>¿Realmente desea eliminar el archivo <b id="selName"></b>?

		  </div>

		  <div class="modal-footer">

		    <form method="post" action="Controller/Arquivos.php">

		    	<input type="hidden" name="selArquivo" id="selArquivo"/>

		    	<input type="hidden" name="AlbumID" id="AlbumID"/>

		    	<input type="hidden" name="removeArquivo" id="removeArquivo" value="1"/>

		    	<button class="btn btn-primary" type="submit">Sí</button>

		    	<button class="btn" data-dismiss="modal" aria-hidden="true">No</button>

		    </form>

		  </div>

		</div>

		

		

		<!-- Janelas modal de Adiiconar, alterar e remover um album -->

		<!-- Adicionar Album -->

		<div id="addAlbum" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="Add album" aria-hidden="true">

		  <div class="modal-header">

		    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>

		    <h3 id="myModalLabel">Agregar álbun</h3>

		  </div>

		  <form method="post" action="Controller/Arquivos.php" style="margin: 0px;">

			  <div class="modal-body">

			    <div class="control-group">

					<label class="control-label" for="inputName">Nombre</label>

					<div class="controls">

						<input class="input-xxlarge" type="text" name="ALB_NOME" id="ALB_NOME">

					</div>

				</div>

			  </div>

			  <div class="modal-footer">

				<input type="hidden" name="addAlbumBool" id="addAlbumBool" value="1"/>

				<input type="hidden" name="selCategoria" id="selCategoria"/>

				<input type="hidden" name="selMarca" id="selMarca" value="<?php echo $marca_id; ?>"/>

				<button class="btn btn-primary" type="submit">Agregar</button>

				<button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>

			  </div>

		  </form>

		</div>

		

		<!-- Editar album -->

		<div id="editAlbum" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="Add album" aria-hidden="true">

		  <div class="modal-header">

		    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>

		    <h3 id="myModalLabel">Editar álbun</h3>

		  </div>

		  <form method="post" action="Controller/Arquivos.php" style="margin: 0px;">

			  <div class="modal-body">

			    <div class="control-group">

					<label class="control-label" for="inputName">Nombre</label>

					<div class="controls">

						<input class="input-xxlarge" type="text" name="ALB_NOME" id="ALB_NOME_ALT" placeholder="">

					</div>

				</div>

			  </div>

			  <div class="modal-footer">

			  	<input type="hidden" name="selAlbum" id="selAlbum"/>

			  	<input type="hidden" name="selCategoria" id="selCategoriaAlt"/>

				<input type="hidden" name="editAlbumBool" id="editAlbumBool" value="1"/>

				<input type="hidden" name="selMarca" id="selMarca" value="<?php echo $marca_id; ?>"/>

				<button class="btn btn-primary" type="submit">Cambiar</button>

				<button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>

			  </div>

		  </form>

		</div>

		

		<!-- Remover album -->

		<div id="removeAlbum" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

		  <div class="modal-header">

		    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>

		    <h3 id="myModalLabel">Eliminar álbun</h3>

		  </div>

		  <div class="modal-body">

		    <p>¿Realmente desea eliminar el archivo <b id="selAlbumName"></b>?

		    	<div class="alert alert-block">

		    <p><strong>¡Atención!</strong> Todos los archivos se eliminarán del álbum.</strong></p>

		    </div>

		  </div>

		  <div class="modal-footer">

		    <form method="post" action="Controller/Arquivos.php">

		    	<input type="hidden" name="selData" id="selData"/>

		    	<input type="hidden" name="removeAlbum" id="removeAlbum" value="1"/>

		    	<button class="btn btn-primary" type="submit">Sí</button>

		    	<button class="btn" data-dismiss="modal" aria-hidden="true">No</button>

		    </form>

		  </div>

		</div>

        </div>

		

	</body>

</html>	