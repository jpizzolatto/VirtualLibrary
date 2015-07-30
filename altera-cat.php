<?php



include("InicializaPagina.php");



require_once("Controller/Categorias.php");



if (!isset($_GET['id']))

{

	header("location: categorias.php?status=error");

}



$id = $_GET['id'];



$cat = GetCategoria($id);



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

                

                <div class="altera-cat">

                <div class="span10">

                <h3 class="muted" align="center">Cambiar categoría</h3>

                <hr><br>

                </div>

                </div>

                

                <div class="span10">                

                <div class="form-grupo">

                	<form class="form-horizontal" method="post" action="Controller/Categorias.php" enctype="multipart/form-data" >

  						<div class="control-group">

    						<label class="control-label" for="inputName">Nombre</label>

    						<div class="controls">

      							<input class="input-xxlarge" type="text" name="CAT_NOME" id="CAT_NOME" placeholder="Name"

      									value="<?php echo $cat['nome']; ?>">

    						</div>

  						</div>

  						<div class="control-group">

  							<label class="control-label" for="inputFile">Imagen</label>

  							<img src="<?php echo $_SESSION['categoriasImagePrefix'] . $cat['imagem']; ?>" />

  							<div class="controls">

								 <input type="file" name="CAT_FILE" id="CAT_FILE">

								 <div class="alert">

								  Formato de las imagenes: 106X109 pixels

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