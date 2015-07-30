<?php



include ("InicializaPagina.php");



require_once("Controller/Solicitacoes.php");

require_once("Controller/Usuarios.php");

require_once("Controller/Arquivos.php");



$id = $_GET['id'];



$sol = GetSolicitacao($id);



$arquivoAlt = null;

if (isset($_GET['arquivo']))

{

	$arquivoAlt = $sol['id_arquivo'];

}



$userID = $sol['usuario'];

$user = GetUsuarioByID($userID);


$arquivos = null;

if ($sol['caminho'] != null)

{

	$arquivos = explode(",", $sol['caminho']);

}



$perguntas = null;

if ($sol['perguntas'] != null)

{

	$perguntas = explode(",", $sol['perguntas']);

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



				<div class="span11">

					<h3 class="muted" align="center">Visualizar solicitación</h3>



					<div class="span12" style="margin-top: 10px;">

						<div class="span2">

							<a href="responder-solicitacao.php?id=<?php echo $id;?>">

								<button class="btn">Responder</button>

							</a>

						</div>



						<div class="span10">
							
							<button class="btn btn-success offset7" onclick="AcceptSol(<?php echo $id; ?>, '<?php echo $user['nome']; ?>')">
							    Aceptar
						    </button>

							<button class="btn btn-danger"

									onclick="RemoveClick(<?php echo $id; ?>, '<?php echo $user['nome']; ?>')">

									Rechazar

								</button>

						</div>

					</div>



					<hr class="span11">



					<div class="span7" style="margin-bottom: 20px; margin-top: -25px;">



					<?php

					if ($arquivoAlt != null)

					{

						$arquivo = GetArquivo($arquivoAlt);

						$img = GetImageFromType($arquivo);

					?>

							<h4 style="margin-bottom: 10px;">Archivo original</h4>

							<div id="escolhida" class="span10" style="margin-bottom: 20px;">
                                <div class="span5" style="padding-top: 5px; padding-bottom: 10px;">
                                    <a href="#">
                                        <?php

                                        if ($img)
                                            {
                                                list($width, $height, $type, $attr) = getimagesize($img);

                                                $width = $width * 0.5;
                                                $height = $height * 0.5;
                                            }
                                            else
                                            {
                                                $width = 130;
                                                $height = 130;
                                            }
                                        ?>
                                        <img class="foto-escolhida" src="<?php echo $img;?>" width="<?php echo $width; ?>"
                                              height="<?php echo $height; ?>" />
                                    </a>
                                </div>
                                <div class="span4 offset1" style="padding-top: 20px;">
                                    <h5><?php echo $arquivo['nome']; ?></h5>
                                    <p><?php echo $arquivo['descricao']; ?></p>
                                </div>
                            </div>

		            <?php

					}

					?>

					 	<h4>Preguntas</h4>



					<?php

						if ($perguntas != null)
						{

							echo "<ol style='margin-top: 20px;'>";

							$n = count($perguntas);
							for ($i = 0; $i < $n; $i++)
							{

								if ($perguntas[$i] == "")
								    continue;

							?>
								<li>

									<p style="font-size: 16px; color: #666666;">

										<?php echo $perguntas[$i]; ?>

									</p>

								</li>

							<?php

							}

							echo "</ol>";
						}
                        else
                        {
                            echo "<div class='alert alert-info'>No hay Ninguna pregunta se hizo.</div>";
                        }

					?>

					</div>





					<!-- <div class="span7">



					</div>

					 -->

					<div class="span4" style="margin-bottom: 30px;">

						<h4>Archivos de ejemplo</h4>

					<?php

						if ($arquivos != null)

						{

							$n = count($arquivos);

							for ($i = 0; $i < $n; $i++)

							{

								$img = GetImageFromPath($arquivos[$i]);



							?>

								<div class="span10" style="margin-top: 20px;">

									<a href="download.php?file=<?php echo $arquivos[$i];?>&temp=true">

										<img src="<?php echo $img; ?>" />

									</a>

								</div>

							<?php

							}

						}

						else

						{

							echo "<div class='alert alert-info'>No hay archivo agregado.</div>";

						}

					?>

					</div>

				</div>

			</div>



		<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

		  <div class="modal-header">

		    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>

		    <h3 id="myModalLabel">Rechazar solicitación</h3>

		  </div>

		  <div class="modal-body">

		    <p>

		    	¿Realmente desea eliminar la solicitud del usuario <b id="selName"></b>?

		    	<div class='alert alert-warning'>

		    		Al rechazar, las solicitudes serán <b>eliminadas</b>.

	    		</div>

		    </p>

		    <p>

		    	Introduzca una razón para el rechazo

		    	<input type="text" name="rejectText" id="rejectText" class="span8">

		    </p>

		  </div>

		  <div class="modal-footer">

		    <form method="post" action="Controller/Solicitacoes.php">

		    	<input type="hidden" name="selData" id="selData"/>

		    	<input type="hidden" name="removeSolicitacao" id="removeSolicitacao" value="1"/>

		    	<button class="btn btn-primary" type="submit">Sí</button>

		    	<button class="btn" data-dismiss="modal" aria-hidden="true">No</button>

		    </form>

		  </div>

		</div>



		<div id="acceptModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

		  <div class="modal-header">

		    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>

		    <h3 id="myModalLabel">Aceptar solicitación</h3>

		  </div>

		  <div class="modal-body">

		    <p>

		    	¿Realmente desea aceptar la solicitud del usuario <b id="selName2"></b>?

		    </p>

		  </div>

		  <div class="modal-footer">

		    <form method="post" action="Controller/Solicitacoes.php">

		    	<input type="hidden" name="selData2" id="selData2"/>

		    	<input type="hidden" name="aceitaSolicitacao" id="aceitaSolicitacao" value="1"/>

		    	<button class="btn btn-primary" type="submit">Sí</button>

		    	<button class="btn" data-dismiss="modal" aria-hidden="true">No</button>

		    </form>

		  </div>

		</div>

     	</div>

	</body>

</html>