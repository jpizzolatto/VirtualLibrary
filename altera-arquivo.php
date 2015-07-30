<?php

include ("InicializaPagina.php");

require_once("Controller/Arquivos.php");

$id = $_GET['id'];

$arquivo = GetArquivo($id);

$nome = $arquivo['nome'];
$descricao = $arquivo['descricao'];
$tipo = $arquivo['tipo'];
$file1 = $arquivo['arquivo1'];
$file2 = $arquivo['arquivo2'];
$file3 = $arquivo['arquivo3'];
$albumID = $arquivo['album'];

$file = $arquivo['arquivo1'];
if ($file == NULL)
{
	$file = $arquivo['arquivo2'];
	if ($file == NULL)
	{
		$file = $arquivo['arquivo3'];
	}
}
$img = GetImageFromType($arquivo);

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
                <div class="altera-arquivo">
                <h3 class="muted" align="center">Cambiar archivo</h3>
                <hr><br>
                </div>
                                
                <div class="form-grupo">
                	<form class="form-horizontal" method="post" action="Controller/Arquivos.php" enctype="multipart/form-data" >
  						<div class="control-group">
    						<label class="control-label" for="inputName">Nombre</label>
    						<div class="controls">
      							<input class="input-xxlarge" type="text" name="ARQ_NOME" id="ARQ_NOME" placeholder=""
      									value="<?php echo $nome; ?>">
    						</div>
  						</div>
  						<div class="control-group">
    						<label class="control-label" for="inputName">Descripción</label>
    						<div class="controls">
      							<input class="input-xxlarge" type="text" name="ARQ_DESC" id="ARQ_DESC" placeholder=""
      									value="<?php echo $descricao; ?>">
    						</div>
  						</div>
  						<div class="control-group">
    						<label class="control-label" for="inputName">Tipo</label>
    						<div class="controls">
      							<input class="input-xxlarge" type="text" name="ARQ_TIPO" id="ARQ_TIPO" placeholder=""
      									value="<?php echo $tipo; ?>">
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
  						<?php
  						if ($arquivo['arquivo1'] == $img ||
							$arquivo['arquivo2'] == $img ||
							$arquivo['arquivo3'] == $img)
							{
								list($real_width, $real_height, $type, $attr) = getimagesize($img);
							
								$width = $real_width * 0.4;
								$height = $real_height * 0.4;
							}
							else 
							{
								$width = 130;
								$height = 130;
							}
						?>
						<div class="control-group">
  							<label class="control-label" for="inputFile"></label>
  							<div class="controls">
								<img width="<?php echo $width; ?>" height="<?php echo $height; ?>" 
									 src="<?php echo $img;?>" />
							</div>
					  </div>
  						<div class="control-group">
  							<label class="control-label" for="inputFile">Archivo 1</label>
  							<div class="controls">
								<span class="label"><?php echo pathinfo($file1, PATHINFO_BASENAME); ?></span>
								 <input type="file" name="ARQ_FILE_1" id="ARQ_FILE_1" />
            				</div>
            			</div>
            			<div class="control-group">
  							<label class="control-label" for="inputFile">Archivo 2</label>
  							<div class="controls">
								<span class="label"><?php echo pathinfo($file2, PATHINFO_BASENAME); ?></span>
								 <input type="file" name="ARQ_FILE_2" id="ARQ_FILE_2" />
            				</div>
            			</div>
            			<div class="control-group">
  							<label class="control-label" for="inputFile">Archivo 3</label>
  							<div class="controls">
								<span class="label"><?php echo pathinfo($file3, PATHINFO_BASENAME); ?></span>
								 <input type="file" name="ARQ_FILE_3" id="ARQ_FILE_3" />
            				</div>
            			</div>
            			<div class="control-group">
            				<div class="controls">
 								<input type="hidden" name="altArquivo" id="altArquivo" value="1" />
 								<input type="hidden" name="arquivoID" id="arquivoID" value="<?php echo $id; ?>" />
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