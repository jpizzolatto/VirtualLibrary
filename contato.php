<?php



include ("InicializaPagina.php");

require_once("Controller/Solicitacoes.php");

require_once("Controller/Usuarios.php");



$user = $_SESSION['usuario'];



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

					<h3 class="muted" align="center">Contatar administrador</h3>

                        

                    <?php

                	if (isset($status))

					{

						if ($status == "success") 

						{

							echo "<div class='alert alert-success'>

									<button type='button' class='close' data-dismiss='alert'>&times;</button>

									Email enviado com sucesso!

								 </div>";

						}

						else if ($status == "error") 

						{

							echo "<div class='alert alert-error'>

									<button type='button' class='close' data-dismiss='alert'>&times;</button>

									O email não pode ser enviado.

								 </div>";

						}

					}

                	?>

                            

                    <hr>

                    

                    <div class="span10">

                    	<form name="respSolicitacao" action="Controller/Email.php" method="post" class="form-horizontal">

                    		 <fieldset>

                    		 	

                    		 	<div class="control-group" style="margin-bottom: -5px;">

	                    			<label class="control-label">De</label>

                    				<div class="controls">

                    					<p class="lead"><?php echo $user->Nome; ?></p>

                					</div>

            					</div>

            					

                    		 	<div class="control-group">

	                    		 	<label class="control-label" for="assuntoEmail">Assunto</label>

	                    		 	<div class="controls">

								    	<input type="text" name="assuntoEmail" id="assuntoEmail"

								    			class="span12">

								    </div>

							    </div>

							    

							    <div class="control-group">

	                    		 	<label class="control-label" for="msgEmail">Mensagem</label>

	                    		 	<div class="controls">

								    	<textarea rows="10" name="msgEmail" id="msgEmail" 

								    			  class="span12" style="max-width: 500px;"></textarea>

								    </div>

							    </div>

							    

							    <input type="hidden" name="contatarAdmin" id="contatarAdmin" value="1" />

							    <input type="hidden" name="userID" id="userID" value="<?php echo $user->Id; ?>" />

					    		

					    		<div class="control-group offset7">

					    			<div class="controls">					    

							    		<button type="submit" class="btn">Enviar</button>

							    	</div>

							    </div>

                		 	</fieldset>

                    	</form>

                    </div>

               </div>

			</div>

     	</div>

	</body>

</html>	