<?php

include ("InicializaPagina.php");
require_once("Controller/Arquivos.php");
require_once("Controller/Categorias.php");
require_once("Controller/Marcas.php");

$text = null;
if (isset($_SESSION['search_text']))
{
	$text = $_SESSION['search_text'];
}

$resultado = null;
if (isset($_SESSION['search_result']))
{
	$resultado	= $_SESSION['search_result'];
}

$scope = $_GET['scope'];
$_SESSION['search-scope'] = $scope;

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
                         
				<div class="span10">
					<h3 class="muted" align="center">Resultados de la búsqueda</h3>
                        
                    <?php	
					if ($resultado == null) 
					{
						echo "<div class='alert alert-error'>
								<button type='button' class='close' data-dismiss='alert'>&times;</button>
								Error al realizar la búsqueda.
							 </div>";
					}
                	?>
                            
                    <hr>
                    
                <?php
                $img = "";
                $values = $resultado[$scope];
                $n = count($values);
                switch ($scope) 
                {
                    case 'marcas':
						echo "<p class='lead'>Resultados de las <b>Marcas</b>. (Palabra buscada: <b>".$text."</b>)</p>";
                        break;
					case 'albuns':
						echo "<p class='lead'>Resultados de los <b>Álbumes</b>. (Palabra buscada: <b>".$text."</b>)</p>";
						$img = "img/pasta.png";
						break;
						
					case 'arquivos':
						echo "<p class='lead'>Resultados de <b>Archivos</b>. (Palabra buscada: <b>".$text."</b>)</p>";
						break;
                    default:
                        break;
                }
                
                	echo "<div class='alert alert-info'>Se han encontrado <b>".$n."</b> resultados.</div>";
                
                ?>
                    <ul class="unstyled" style="padding-top: 30px;" id="search-lista">
	                    <?php
	                    if (!isset($_SESSION['searchIndex']))
						{
							$_SESSION['searchIndex'] = 0;
						}
						$index = $_SESSION['searchIndex'];
						
						for($i = $index; $i < $n; $i++)
						{
						?>
							<li style="padding-bottom: 20px;">
								<div class="span10">
									<a href="Controller/Direciona.php?id=<?php echo $values[$i]['id']; ?>&nome=<?php echo $scope; ?>">
										<div class="span2" style="position: relative;">
											<?php
											if ($scope == 'albuns')
											{
												$catID = $values[$i]['categoria'];
												$categoria = GetCategoria($catID);
											?>
												<div class="span4 offset6" style="z-index: 9999; position: absolute; display: block; margin-top: 45px;">
									 				<img src="<?php echo $_SESSION['categoriasImagePrefix'] . $categoria['imagem']; ?>" />
									 			</div>
											<?php
											}
											if ($scope == "arquivos")
												$img = GetImageFromType($values[$i]);
											 
											if ($scope == "marcas")
												$img = $_SESSION['marcasImagePrefix'] . $values[$i]["imagem"];
											?>
											<img src="<?php echo $img; ?>" />
										</div>
										<?php
										if ($scope == "arquivos")
										{
										?>
											<div class="span8" style="margin-left: 25px;">
												<h5><?php echo $values[$i]["nome"]; ?></h5>
												<p><?php echo $values[$i]["descricao"]; ?></p>	
											</div>
										<?php
										}
										else
										{
										?>
										<div class="span8" style="margin-top: 20px; margin-left: 25px;">
											<h5><?php echo $values[$i]["nome"]; ?></h5>	
										</div>
										<?php
										}
										?>
									</a>
								</div>
							</li>
							<hr class="span10">
						<?php
						}
	                    ?>	
					</ul>
					<div class="pagination offset4" id="paginas-lista">
	              			<ul>
	              				<?php
	              				if ($index == 0)
									echo "<li class='disabled'><a href='#'><span>Prev</a></span></li>";
								else 
									echo "<li><a href='#' onclick='ChangePage(\"prev\", \"search\");'><span>Prev</a></span></li>";
	              				
								$page = ceil(($index + 1)/10);
              					$pages = ceil($n/10);
								for ($j = 1; $j <= $pages; $j++)
								{
									if ($j == $page)
										echo "<li class='disabled'><a href='#'><span>".$j."</span></a></li>";
									else
										echo "<li><a href='#' onclick='ChangePage(".$j.", \"search\");'><span>".$j."</span></a></li>";	
								}

								if (($index + 10) >= $n)
									echo "<li class='disabled'><a href='#'><span>Next</span></a></li>"; 
								else
									echo "<li><a href='#' onclick='ChangePage(\"next\", \"search\");'><span>Next</span></a></li>";
								?>
						  	</ul>
						</div>
	             	</div>
               </div>
			</div>
     	</div>
	</body>
</html>	