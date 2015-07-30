<?php

include ("InicializaPagina.php");

require_once("Controller/Usuarios.php");

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
                	
                	<h3 class="muted" align="center">Usuarios</h3>
                	
                	<?php
                	if (isset($status))
					{
						if ($status == "error")
						{
							echo "<div class='alert alert-error'>
									<button type='button' class='close' data-dismiss='alert'>&times;</button>
								  	Error agregar, editar o eliminar un usuario.
								  </div>";
						}
						else if ($status == "success") 
						{
							echo "<div class='alert alert-success'>
									<button type='button' class='close' data-dismiss='alert'>&times;</button>
									Usuario agregado, modificado o eliminado con éxito!
								  </div>";
						}
					}
                	?>
                    
                    <div class="userlist">
                	<p>
						<a href="add-user.php"><button class="btn btn-small btn-primary" type="button">Agregar usuario</button></a>
	                </p>
                	
                	<hr>
   
	                
					<ul class="unstyled">
						<?php
						$users = GetUsuarios();
						
						$n = count($users);
						
						if (($n -1) == 0)
						{
							echo "<div class='alert alert-info'>
								  	No se registró usuario.
								  </div>";
						}
						
						for ($i = 0; $i < $n; $i++)
						{
							if ($users[$i]['isadmin'] == TRUE)
								continue;
							
							$id = $users[$i]['id'];
							$nome = $users[$i]['nome'];
						?>
							 <li class="lista-control">
							 	<div class="span10">
							 		<p>
							 			<i class="icon-user"></i>
							 			<?php echo $nome; ?>
							 		</p>
							 	</div>
							 	<div class="span2">
							 		<a href="altera-user.php?id=<?php echo $id; ?>"><button class="btn btn-mini" type="button">Editar</button></a>
									<a href="#myModal" onClick="RemoveClick(<?php echo $id; ?>, '<?php echo $nome; ?>');">
										<button class="btn btn-mini btn-danger" type="button">Eliminar</button>
									</a>
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
		    <h3 id="myModalLabel">Eliminar usuario</h3>
		  </div>
		  <div class="modal-body">
		    <p>¿Realmente desea eliminar el usuario<b id="selName"></b>?</p>
		  </div>
		  <div class="modal-footer">
		    <form method="post" action="Controller/Usuarios.php">
		    	<input type="hidden" name="selData" id="selData"/>
		    	<button class="btn btn-primary" type="submit">Sí</button>
		    	<button class="btn" data-dismiss="modal" aria-hidden="true">No</button>
		    </form>
		  </div>
		</div>
     	</div>
	</body>
</html>	