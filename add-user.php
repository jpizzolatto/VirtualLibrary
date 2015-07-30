<?php



include ("InicializaPagina.php");



require_once ("Controller/Grupos.php");



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

                <div class="add-user">

                <h3 class="muted" align="center">Agregar usuario</h3>

                <hr><br>

                </div>

                                

                <div class="form-user">

                	<form class="form-horizontal" method="post" action="Controller/Usuarios.php">

  						<div class="control-group">

    						<label class="control-label" for="inputName">Nombre</label>

    						<div class="controls">

      							<input class="input-xxlarge" type="text" id="USR_NAME" name="USR_NAME">

    						</div>

  						</div>

  						<div class="control-group">

    						<label class="control-label" for="inputEmail">Email</label>

    						<div class="controls">

      							<input class="input-xxlarge" type="text" id="USR_MAIL" name="USR_MAIL">

    						</div>

  						</div>

                        <div class="control-group">

    						<label class="control-label" for="inputLogin">Login</label>

    						<div class="controls">

      							<input class="input-xxlarge" type="text" id="USR_LOGIN" name="USR_LOGIN">

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

									echo "<option value='".$grupos[$i]['id']."'>".$grupos[$i]['nome']."</option>";

								}

							}

  						?>

						    	</select>

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