<?php

include ("InicializaPagina.php");

require_once ("Controller/Categorias.php");
require_once("Controller/Grupos.php");

$status = null;
if (isset($_GET['status']))
{
	$status = $_GET['status'];
}

$user = $_SESSION['usuario'];
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
                	
                	<h3 class="muted" align="center">Categorías</h3>
                	
                	<?php
                	if (isset($status))
					{
						if ($status == "error")
						{
							echo "<div class='alert alert-error'>
									<button type='button' class='close' data-dismiss='alert'>&times;</button>
									Error agregar, editar o eliminar una categoría.
								 </div>";
						}
						else if ($status == "success") 
						{
							echo "<div class='alert alert-success'>
									<button type='button' class='close' data-dismiss='alert'>&times;</button>
									Categoría agregado, modificado o eliminado con éxito!
								 </div>";
						}
					}
                	?>
                	
                    <div class="categorialist">
                	<p>
						<a href="add-cat.php"><button class="btn btn-small btn-primary" type="button">Agregar categoría</button></a>
	                </p>
                	
                	<hr>
   
	                
					<ul class="unstyled">
						<?php
						$categorias = GetCategorias();
						
						$catAcessos = GetCategoriasAutorizadas($user);
						
						$n = count($categorias);
						
						if ($n == 0)
						{
							echo "<div class='alert alert-info'>
								  	Ninguna categoría se registró.
								  </div>";
						}
						
						for ($i = 0; $i < $n; $i++)
						{
							$id = $categorias[$i]['id'];
							$nome = $categorias[$i]['nome'];
							
							$access = in_array($id, $catAcessos);
							if (!$access)
								continue;
							
						?>
							 <li class="lista-control">
							 	<div class="span10">
							 		<p>
							 			<i class="icon-tags"></i>
							 			<?php echo $nome; ?>
							 		</p>
							 	</div>
							 	<div class="span2">
							 		<a href="altera-cat.php?id=<?php echo $id; ?>"><button class="btn btn-mini" type="button">Editar</button></a>
									<a href="#myModal" onClick="RemoveClick(<?php echo $id; ?>, '<?php echo $nome; ?>');"><button class="btn btn-mini btn-danger" type="button">Eliminar</button></a>
							 	</div>
		                    </li>
		                    <hr>
						<?php	
						}
						?>
	                </ul> 		
                </div>
			</div>
     	</div>
     	
     	     	
        <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		  <div class="modal-header">
		    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		    <h3 id="myModalLabel">Eliminar categoría</h3>
		  </div>
		  <div class="modal-body">
		    <p>¿Realmente desea eliminar la categoría <b id="selName"></b>?
		  </div>
		  <div class="modal-footer">
		    <form method="post" action="Controller/Categorias.php">
		    	<input type="hidden" name="selData" id="selData"/>
		    	<button class="btn btn-primary" type="submit">Sí</button>
		    	<button class="btn" data-dismiss="modal" aria-hidden="true">No</button>
		    </form>
		  </div>
		</div>
        </div>
	</body>
</html>	