<?php



include ("InicializaPagina.php");



require_once ("Controller/Solicitacoes.php");

require_once ("Controller/Usuarios.php");



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

                    	<div class="lista-sol">

                			<h3 class="muted" align="center">Solicitaciones</h3>

                			

                			<?php

		                	if (isset($status))

							{

								if ($status == "error")

								{

									echo "<div class='alert alert-error'>

											<button type='button' class='close' data-dismiss='alert'>&times;</button>

											Error rechazar/aceptar una solicitud.

										 </div>";

								}

								else if ($status == "success") 

								{

									echo "<div class='alert alert-success'>

											<button type='button' class='close' data-dismiss='alert'>&times;</button>

											Solicitud rechazada/aceptada con éxito.

										 </div>";

								}

							}

		                	?>

                			

                			<hr>

                			

                			<?php

							$sol = GetSolicitacoes();

							

							$n = count($sol);

							

							if ($n == 0)

							{

								echo "<div class='alert alert-info'>

									  	No hay solicitación agregada.

									  </div>";

							}

							?>

							

							

	                

							<ul class="unstyled">

							<?php

								for ($i = 0; $i < $n; $i++)

								{

									$id = $sol[$i]['id'];

									$id_user = $sol[$i]['usuario'];

									$id_arquivo = $sol[$i]["id_arquivo"];

									

									$dateFull = explode(" ", $sol[$i]['data']);

									$date = explode("-", $dateFull[0]);

									$hour = $dateFull[1];

									

									$user = GetUsuarioByID($id_user);

									

									if ($user == null)

									{

										echo "<div class='alert alert-error'>

											  	Solicitud enviada por un usuario no existente.

											  </div>";

										continue;

									}

										

								?>

									 <li class="lista-control">

									 	<div class="span10">

									 		<p>

									 			<strong>Usuario: </strong> <?php echo $user['nome']; ?>

								 			</p>

								 			<p>

									 			<strong>Fecha: </strong> <?php echo $date[2]."/".$date[1]."/".$date[0]." - ".$hour; ?>

									 		</p>

									 	</div>

									 	<div class="span2" style="margin-top: 20px;">

									 		<?php

									 		if ($id_arquivo > 0)

									 		{

									 		?>

									 			<a href="visualizar-solicitacao.php?id=<?php echo $id; ?>&arquivo=<?php echo $id_arquivo;?>">

										 			<button class="btn btn-mini" type="button">Visualizar</button>

										 		</a>

									 		<?php

									 		}

											else

											{

											?>

												<a href="visualizar-solicitacao.php?id=<?php echo $id; ?>">

										 			<button class="btn btn-mini" type="button">Visualizar</button>

										 		</a>

											<?php

											}

									 		?>

									 	</div>

				                    </li>

				                    

				                    <li>

				                    	<div class="span12">

				                    		<hr>

			                    		</div>	

				                    </li>

				                    

								<?php	

								}

								?>

			                </ul> 		

		                </div>

	                </div>

                </div>	

            </div>

     	</div>

	</body>

</html>	