<?php

include ("InicializaPagina.php");

$album_id = $_GET['albumid'];

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
                <div class="add-arquivo">
                <h3 class="muted" align="center">Agregar archivo</h3>
                <hr><br>
                </div>
                                
                <div class="form-grupo">
                	<form class="form-horizontal" method="post" action="Controller/Arquivos.php" enctype="multipart/form-data" >
  						<div class="control-group">
    						<label class="control-label" for="inputName">Nombre</label>
    						<div class="controls">
      							<input class="input-xxlarge" type="text" name="ARQ_NOME" id="ARQ_NOME" placeholder="">
    						</div>
  						</div>
  						<div class="control-group">
    						<label class="control-label" for="inputName">Descripción</label>
    						<div class="controls">
      							<input class="input-xxlarge" type="text" name="ARQ_DESC" id="ARQ_DESC" placeholder="">
    						</div>
  						</div>
  						<div class="control-group">
    						<label class="control-label" for="inputName">Tipo</label>
    						<div class="controls">
      							<input class="input-xxlarge" type="text" name="ARQ_TIPO" id="ARQ_TIPO" placeholder="">
    						</div>
  						</div>
  						<div class="control-group">
    						<div class="controls">
      							<div class="alert">
								  <strong>¡Atención!</strong> Tres versiones de archivo son compatibles con el sistema.<br><br>
								  Los nombres de archivo pueden ser los mismos, pero las <strong>extensiones</strong> deben ser diferentes.<br>
								  Ex. foto.jpg, foto.png e foto.gif
								</div>
    						</div>
  						</div>
  						<div class="control-group">
  							<label class="control-label" for="inputFile">Archivo 1</label>
  							<div class="controls">
								 <input type="file" name="ARQ_FILE1" id="ARQ_FILE1">
            				</div>
            			</div>
            			<div class="control-group">
  							<label class="control-label" for="inputFile">Archivo 2</label>
  							<div class="controls">
								 <input type="file" name="ARQ_FILE2" id="ARQ_FILE2">
            				</div>
            			</div>
            			<div class="control-group">
  							<label class="control-label" for="inputFile">Archivo 3</label>
  							<div class="controls">
								 <input type="file" name="ARQ_FILE3" id="ARQ_FILE3">
            				</div>
            			</div>
            			<div class="control-group">
            				<div class="controls">
 								<input type="hidden" name="addArquivo" id="addArquivo" value="1" />
 								<input type="hidden" name="albumID" id="albumID" value="<?php echo $album_id; ?>" />
            					<button type="submit" class="btn btn-primary">Agregar</button>
            				</div>
            			</div>
					</form>
				</div>
			</div>
            </div>
		</div>
	</body>
</html>