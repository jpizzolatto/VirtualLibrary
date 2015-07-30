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
	
	if (isset($_GET['album']))
	{
		$albumID = $_GET['album'];	
	}
	
	$album = GetAlbum($albumID);
	if (!isset($_SESSION['currAlbum']) || $_SESSION['currAlbum']['id'] != $albumID)
	{
		$_SESSION['currAlbum'] = $album;
	}
	
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
		             	<div class="span3 album-icon" style="margin-left: 35px;">
		             		<img class="first-image" width="107" height="114" src="<?php echo $_SESSION['marcasImagePrefix'] . $marca['imagem']; ?>" />	
		             	</div>
				 		<div class="span3 album-icon" style="margin-left: -35px;">
				 			<a href="Controller/Direciona.php?id=<?php echo $categoria['id']; ?>&nome=pasta">
				 				<img class="first-image" width="106" height="109" src="<?php echo $_SESSION['categoriasImagePrefix'] . $categoria['imagem']; ?>" />
				 			</a>
				 		</div>
				 		
				 		<div class="span2 album-icon" style="z-index: 100; width: 80px; position: relative; margin-left: -20px; padding-top: 10px;">
				 			<div class="span4 offset7" style="z-index: 9999; position: absolute; display: block; margin-top: 45px;">
				 				<a href="#" data-toggle="tooltip" title="<?php echo $categoria['nome']; ?>">
				 					<img src="<?php echo $_SESSION['categoriasImagePrefix'] . $categoria['imagem']; ?>"  width="106" height="109" />
				 				</a>
				 			</div>
				 			<img  src="img/pasta.png" />
				 			<p align="left" style="padding-left: 5px; padding-top: 5px; color: #666666; width: 200px;"><?php echo $album['nome']; ?></p>
						</div>
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
		             	
		              	<div class="span10 inline" id="arquivos-lista" style="margin-bottom: 40px;">
		              		<?php
		              		$arquivos = GetArquivosByAlbum($albumID);
							
							if (!isset($_SESSION['arquivosIndex']))
							{
								$_SESSION['arquivosIndex'] = 0;
							}
							$index = $_SESSION['arquivosIndex'];
							
							$n = count($arquivos);
							if ($n == 0)
							{
								echo "<div class='alert alert-info'>Nenhum arquivo adicionado até o momento.</div>";
							}
							
							$c = 0;
							for ($i = $index; $i < $n; $i++)
							{
								if ($c == 10)
									break;
								
								$img = GetImageFromType($arquivos[$i]);

							?>
								<div class="span2 album-icon" style="height: 160px; width: 80px; margin-bottom: 20px;  <?php if($i == 0) { echo 'margin-left: 15px;';} ?>">
									<a href="arquivo-escolhido.php?id=<?php echo $arquivos[$i]['id']; ?>">
							 			<img class="miniImages" src="thumbnails.php?file=<?php echo $img; ?>&width=90&height=70"/>
							 			<p align="center" class="btn btn-link"><?php echo $arquivos[$i]['nome']; ?></p>
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
									echo "<li><a href='#' onclick='ChangePage(\"prev\", \"arquivos\");'><span>Prev</a></span></li>";
	              				
								$page = ceil(($index + 1)/10);
              					$pages = ceil($n/10);
								for ($j = 1; $j <= $pages; $j++)
								{
									if ($j == $page)
										echo "<li class='disabled'><a href='#'><span>".$j."</span></a></li>";
									else
										echo "<li><a href='#' onclick='ChangePage(".$j.", \"arquivos\");'><span>".$j."</span></a></li>";	
								}

								if (($index + 10) >= $n)
									echo "<li class='disabled'><a href='#'><span>Next</span></a></li>"; 
								else
									echo "<li><a href='#' onclick='ChangePage(\"next\", \"arquivos\");'><span>Next</span></a></li>";
								?>
						  	</ul>
						</div>
	             	</div>
	  			 </div>
         	</div>
         </div>
     </body>
 </html>