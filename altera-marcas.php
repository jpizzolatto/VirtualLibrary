<?php
include("InicializaPagina.php");

require_once("Controller/Marcas.php");

if (!isset($_GET['id']))
{
	header("location: marcas-admin.php?status=error");
}

$id = $_GET['id'];

$marca = GetMarca($id);

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
                
			<div class="altera-marca">
				<div class="span10">                
                <h3 class="muted" align="center">Cambiar vacuna</h3>
                <hr>
                <br>
                </div>
            </div>

                
                <div class="span10">
                <div class="form-grupo">
                	<form class="form-horizontal" method="post" action="Controller/Marcas.php" enctype="multipart/form-data" >
  						<div class="control-group">
    						<label class="control-label" for="inputName">Nombre</label>
    						<div class="controls">
      							<input class="input-xxlarge" type="text" name="MAR_NOME" id="MAR_NOME" placeholder="Name"
      									value="<?php echo $marca['nome']; ?>" />
    						</div>
  						</div>
  						<div class="control-group">
  							<label class="control-label" for="inputFile">Imagen</label>
  							<img src="<?php echo $_SESSION['marcasImagePrefix'] . $marca['imagem']; ?>" />
  							<div class="controls">
  								 <br>
								 <input type="file" name="MAR_FILE" id="MAR_FILE">
								 <div class="alert">
								  <strong>¡Atención!</strong> Las imágenes deben ser de un tamaño 110x114
								</div>
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
		</div>
	</body>
</html>