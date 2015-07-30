<?php

include ("InicializaPagina.php");

include ("Controller/Marcas.php");

$status = null;
if (isset($_GET['status']))
{
	$status = $_GET['status'];
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
                	
                	<h3 class="muted" align="center">Vacunas</h3>
                	
                	<?php
                	if (isset($status))
					{
						if ($status == "error")
						{
							echo "<div class='alert alert-error'>
									<button type='button' class='close' data-dismiss='alert'>&times;</button>
									Error agregar, editar o eliminar una vacuna.
								 </div>";
						}
						else if ($status == "success") 
						{
							echo "<div class='alert alert-success'>
									<button type='button' class='close' data-dismiss='alert'>&times;</button>
									Vacuna agregada, modificada o eliminada con éxito!
								 </div>";
						}
					}
                	?>
                	
                    <div class="marcaslist">
                	<p>
						<a href="add-marca.php"><button class="btn btn-small btn-primary" type="button">Agregar vacuna</button></a>
	                </p>
                	
                	<hr>
   
	                
					<ul class="unstyled">
						<?php
						$marcas = ListaMarcas();
						
						$n = count($marcas);
						
						if ($n == 0)
						{
							echo "<div class='alert alert-info'>
									No marca ha sido registrada.
								  </div>";
						}
						
						for ($i = 0; $i < $n; $i++)
						{
							$id = $marcas[$i]['id'];
							$nome = $marcas[$i]['nome'];
						?>
							 <li class="lista-control">
							 	<div class="span10">
							 		<p>
							 			<i class="icon-folder-open"></i>
							 			<?php echo $nome; ?>
							 		</p>
							 	</div>
							 	<div class="span2">
							 		<a href="altera-marcas.php?id=<?php echo $id; ?>"><button class="btn btn-mini" type="button">Editar</button></a>
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
		    <h3 id="myModalLabel">Eliminar vacuna</h3>
		  </div>
		  <div class="modal-body">
		    <p>¿Estás seguro que quieres eliminar la marca <b id="selName"></b>?
		  </div>
		  <div class="modal-footer">
		    <form method="post" action="Controller/Marcas.php">
		    	<input type="hidden" name="selData" id="selData"/>
		    	<button class="btn btn-primary" type="submit">Sí</button>
		    	<button class="btn" data-dismiss="modal" aria-hidden="true">No</button>
		    </form>
		  </div>
		</div>
        </p>
	</body>
</html>	