<?php
include ("InicializaPagina.php");

require_once ("Controller/Grupos.php");
require_once ("Controller/Usuarios.php");

if (!isset($_GET['id']))
{
	header("location: usuarios.php?status=error");
}

$id = $_GET['id'];

$altUser = GetUsuarioByID($id);

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
                
                <div class="altera-user">
                <div class="span10">
                <h3 class="muted" align="center">Cambiar usuario</h3>
                <hr><br>
                </div>
                </div>
                
                <div class="span10">                
                <div class="form-user">
                	<form class="form-horizontal" method="post" action="Controller/Usuarios.php">
                		<div class="control-group">
    						<label class="control-label" for="inputName">Login</label>
    						<div class="controls">
      							<span class="label label-info" style="padding: 8px; font-size: 12px;" >
      								<?php echo $altUser['login']; ?>
      							</span>
      									
    						</div>
  						</div>
  						<div class="control-group">
    						<label class="control-label" for="inputName">Nombre</label>
    						<div class="controls">
      							<input class="input-xxlarge" type="text" id="USR_NAME" name="USR_NAME" placeholder="Nome"
      									value="<?php echo $altUser['nome']; ?>" />
    						</div>
  						</div>
  						<div class="control-group">
    						<label class="control-label" for="inputEmail">Email</label>
    						<div class="controls">
      							<input class="input-xxlarge" type="text" id="USR_MAIL" name="USR_MAIL" placeholder="Email"
      									value="<?php echo $altUser['email']; ?>" />
    						</div>
  						</div>
  						<div class="control-group">
							<label class="control-label" for="inputLogin">Grupo</label>
							<div class="controls">
								<select name="USR_GRUPO">
  						<?php
  							$grupos = GetGrupos();
							
							if ($grupos != null)
							{
								$n = count($grupos);
								
								for ($i = 0 ; $i  < $n; $i++) 
								{							
									$grp_id = $grupos[$i]['id'];
									
									echo "entra! ". $grp_id;
									
									if ($grp_id == $altUser['grupo'])
										echo "<option value='".$grp_id."' selected>".$grupos[$i]['nome']."</option>";
									else
										echo "<option value='".$grp_id."'>".$grupos[$i]['nome']."</option>";
								}
							}
  						?>
						    	</select>
    						</div>
 						</div>	
 						<div class="control-group">
 							<div class="controls">
            					<input type="hidden" name="marcaID" id="marcaID" value="<?php echo $id; ?>" />
 								<input type="hidden" name="altSubmitted" id="altSubmitted" value="1" />
 								<button type="submit" class="btn btn-primary">Cambiar</button>
 							</div>
 						</div>
					</form>
                </div>
			</div>
     	</div>
	</body>
</html>	