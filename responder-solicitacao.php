<?php

include ("InicializaPagina.php");
require_once("Controller/Solicitacoes.php");
require_once("Controller/Usuarios.php");

$user = $_SESSION['usuario'];

$id = $_GET['id'];
$sol = GetSolicitacao($id);

$sendID = $sol['usuario'];
$sendUser = GetUsuarioByID($sendID);

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
					<h3 class="muted" align="center">Responder solicitación</h3>
					
					<?php
                	if (isset($status))
					{
						if ($status == "success") 
						{
							echo "<div class='alert alert-success'>
									<button type='button' class='close' data-dismiss='alert'>&times;</button>
									Email enviado con éxito!
								 </div>";
						}
						else if ($status == "error") 
						{
							echo "<div class='alert alert-error'>
									<button type='button' class='close' data-dismiss='alert'>&times;</button>
									El email no se ha podido enviar.
								 </div>";
						}
					}
                	?>
                            
                    <hr>
                    
                    <div class="span10">
                    	<form name="respSolicitacao" action="Controller/Email.php" method="post" class="form-horizontal">
                    		 <fieldset>
                    		 	
                    		 	<div class="control-group" style="margin-bottom: -5px;">
	                    			<label class="control-label">A</label>
                    				<div class="controls">
                    					<p class="lead"><?php echo $sendUser['nome']; ?></p>
                					</div>
            					</div>
            					
                    		 	<div class="control-group">
	                    		 	<label class="control-label" for="assuntoEmail">Tema</label>
	                    		 	<div class="controls">
								    	<input type="text" placeholder="Assunto do email" name="assuntoEmail" id="assuntoEmail"
								    			class="span12">
								    </div>
							    </div>
							    
							    <div class="control-group">
	                    		 	<label class="control-label" for="msgEmail">Mensaje</label>
	                    		 	<div class="controls">
								    	<textarea rows="10" placeholder="Mensagem para o usuário" name="msgEmail" id="msgEmail" 
								    			  class="span12" style="max-width: 500px;"></textarea>
								    </div>
							    </div>
							    
							    <input type="hidden" name="respondeSol" id="respondeSol" value="1" />
							    <input type="hidden" name="sendUserID" id="sendUserID" value="<?php echo $sendUser['id']; ?>" />
							    <input type="hidden" name="selectedSol" id="selectedSol" value="<?php echo $id; ?>" />
					    		
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