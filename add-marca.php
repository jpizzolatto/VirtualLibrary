<?php



include ("InicializaPagina.php");



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

                <div class="add-marca">

                <h3 class="muted" align="center">Agregar vacuna</h3>

                <hr><br>

                </div>

                                

                <div class="form-grupo">

                	<form class="form-horizontal" method="post" action="Controller/Marcas.php" enctype="multipart/form-data" >

  						<div class="control-group">

    						<label class="control-label" for="inputName">Nombre</label>

    						<div class="controls">

      							<input class="input-xxlarge" type="text" name="MAR_NOME" id="MAR_NOME">

    						</div>

  						</div>

  						<div class="control-group">

  							<label class="control-label" for="inputFile">Imagen</label>

  							<div class="controls">

								 <input type="file" name="MAR_FILE" id="MAR_FILE">

								 <div class="alert">

								  <strong>¡Atención!</strong> Las imágenes deben ser de un tamaño 110x114

								</div>

            				</div>

            			</div>

            			<div class="control-group">

            				<div class="controls">

 								<input type="hidden" name="addSubmitted" id="addSubmitted" value="1" />

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