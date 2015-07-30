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
                    
                    <div class="span10" id="searchList">
                    	
                    	<p class="lead"><b>Texto buscado: </b><?php echo $text; ?></p>
                    	
                    	<?php
                    	foreach ($resultado as $key => $value) 
                    	{
                    		switch ($key) 
                    		{
								case 'marcas':
									$n = count($value);
	                		?>
	                				<div class="span8">
	                					<ul class="inline">
	                						<li>
	                							<i class="icon-circle-arrow-right"></i>
	                						</li>
	                						<li>
	                							<a href="busca-especifica.php?scope=marcas">
	                								<h5>Vacunas (<?php echo $n; ?>)</h5>
                								</a>		
	                						</li>
	                					</ul>
	                					
	                				</div>				
							<?php								
									break;
									
								case 'albuns':
									$n = count($value);
							?>
                					<div class="span8">
                						<ul class="inline">
	                						<li>
	                							<i class="icon-circle-arrow-right"></i>
	                						</li>
	                						<li>
	                							<a href="busca-especifica.php?scope=albuns">
	                								<h5>Álbumes (<?php echo $n; ?>)</h5>
	                							</a>
	                						</li>
	                				</div>
							<?php
									break;
									
								case 'arquivos':
									$n = count($value);
							?>
                					<div class="span8">
                						<ul class="inline">
	                						<li>
	                							<i class="icon-circle-arrow-right"></i>
	                						</li>
	                						<li>
	                							<a href="busca-especifica.php?scope=arquivos">
	                								<h5>Archivos (<?php echo $n; ?>)</h5>
	                							</a>
                							</li>
	                				</div>
							<?php
									break;
							}
						}
                    	?>
                    </div>
               </div>
			</div>
     	</div>
	</body>
</html>	