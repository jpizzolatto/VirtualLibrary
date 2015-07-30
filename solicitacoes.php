<?php



include ("InicializaPagina.php");



require_once("Controller/Arquivos.php");



?>

<!-- Inicio do HTML -->

	<?php

	include ("header.php");

	?>



	<?php

	$user = $_SESSION['usuario'];



	// Caso de alteração em algum arquivo

	$id = null;

	if (isset($_GET['id']))

	{

		$id = $_GET['id'];

	}

	?>



	<body>



		<div class="container">



			<div class="row-fluid span11">



				<div class="row-fluid">

					<?php

					include ("topo.php");

					?>

				</div>



				<div class="row-fluid">

					<?php

					include ("marcasLista.php");

					?>

				</div>



				<div class="row-fluid">

					<div class="solicitacao">

						<div class="span11" style="margin-top: 15px; margin-left: 30px;">

							<h4>

								<span>Solicitar nuevo trabajo</span>

							</h4>

						</div>



						<div class="span11">



							<hr>



							<div class="span7">

								<form action="Controller/Solicitacoes.php" method="post" enctype="multipart/form-data" name="solicitacoes">

									<div class="span7">

										<p>
											1) Fecha para divulgación de la campaña:
										</p>
										<input name="pergunta1" class="input-xlarge" type="text" placeholder="pergunta">

										<p>
											2) ¿A quién va dirigido (target)?
										</p>
										<input name="pergunta2" class="input-xlarge" type="text" placeholder="pergunta">

										<p>
											3) ¿El objetivo de esta campaña/job es institucional o de ventas?
										</p>
										<input name="pergunta3" class="input-xlarge" type="text" placeholder="pergunta">

										<p>
											4) ¿Por qué haremos esta campaña? ¿Cuál es su función?
										</p>
										<input name="pergunta4" class="input-xlarge" type="text" placeholder="pergunta">

										<p>
											5) ¿Quién ha solicitado? ¿Han discutido la creación de la campaña anteriormente o tenemos libertad para crear?
										</p>
										<input name="pergunta5" class="input-xlarge" type="text" placeholder="pergunta">

                                        <p>
											6) ¿Hay alguna fotografía/imagen que debemos utilizar?
										</p>
										<input name="pergunta5" class="input-xlarge" type="text" placeholder="pergunta">

                                        <p>
											7) ¿Hay alguna fotografía/imagen que debemos evitar?
										</p>
										<input name="pergunta5" class="input-xlarge" type="text" placeholder="pergunta">

                                        <p>
											8) ¿Hay algún formato definido? ¿Cuál?
										</p>
										<input name="pergunta5" class="input-xlarge" type="text" placeholder="pergunta">

                                        <p>
											9) ¿Este material ha sido hecho anteriormente? ¿Tiene un ejemplo?
										</p>
										<input name="pergunta5" class="input-xlarge" type="text" placeholder="pergunta">

                                        <p>
											10) ¿Hay alguna regla o determinación que debemos cumplir?
										</p>
										<input name="pergunta5" class="input-xlarge" type="text" placeholder="pergunta">


										<?php

										if ($id != null)

										{

										?>

											<input type="hidden" name="addAlteracao" id="addAlteracao" value="1" />

											<input type="hidden" name="arquivoID" id="arquivoID" value="<?php echo $id; ?>" />

										<?php

										}

										else

										{

										?>

											<input type="hidden" name="addSolicitacao" id="addSolicitacao" value="1" />

										<?php

										}

										?>



										<div class="span7">

											<div class="enviar">

												<input type="submit" class="offset2"

													   style="background-color: transparent; border: 0px; color: white; padding-left: 10px; padding-top: 10px;"/>

											</div>

										</div>



									</div>

							</div>



							<div class="upload span4">

								<?php

								if (isset($id))

								{
									$arquivo = GetArquivo($id);

									$img = GetImageFromType($arquivo);

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

    								<div id="escolhida-solicitacao" style="margin-bottom: 20px; height: <?php echo ($height * 0.1) . "px"; ?>" >
                                        <div class="span5" style="padding-top: 5px; padding-bottom: 10px;">
                                            <a href="#">
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



								<div class="span11">

									<h5>Agregar archivos de ejemplo</h5>

									<div style="margin-bottom: 10px;">

										<label>Archivo 1</label>

										<input type="file" id="tempFile1" name="tempFile1"/>

									</div>

									<div style="margin-bottom: 10px;">

										<label>Archivo 2</label>

										<input type="file" id="tempFile2" name="tempFile2"/>

									</div>

									<div style="margin-bottom: 10px;">

										<label>Archivo 3</label>

										<input type="file" id="tempFile2" name="tempFile3"/>

									</div>

								</div>

							</div>

							</form>

						</div>

					</div>

				</div>

			</div>

	</body>

</html>