<?php

include ("InicializaPagina.php");

require_once("Controller/Arquivos.php");

if (isset($_GET['solicitacao']))
{
	$x = $_GET['solicitacao'];
	if ($x == '1')
		$sol = TRUE;
	else
		$sol = FALSE;
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

				<div class="row-fluid">
					<?php
					include ("marcasLista.php");
					?>
				</div>
				
				<?php
				if (isset($sol))
				{
					echo "<div class='row-fluid span10'>";
					
					if ($sol)
						echo "<div class='alert alert-info'>
						 	  <button type='button' class='close' data-dismiss='alert'>&times;</button>
									Solicitud enviada con éxito
							</div>";
					else
						echo "<div class='alert alert-warning'>
								<button type='button' class='close' data-dismiss='alert'>&times;</button>
								Error al enviar solicitud
							</div>";
							
					echo "</div>";
				}
				?>
				
				                
                <div id="feed" class="container-fluid">
					<div class="inline row-fluid span11" style="margin-left: 70px;">

						<div class="box span5">
                        	<p style="margin-left: 10px;">
								<b>Top 10 - Archivos recentes</b>
							</p>
							<hr>
							<div class="box-conteudo">
								<?php
								$arquivos = GetArquivosRecentes();
								$n = count($arquivos);
								
								if ($n == 0)
								{
								?>
									<div class="row-fluid arquivo">
										<div class="alert alert-info">
											No se añadieron los archivos
										</div>
	                                </div> 
								<?php
								}
								
								for ($i = 0; $i < $n; $i++)
								{
									$img = GetImageFromType($arquivos[$i]);
									
									list($_width, $_height, $type, $attr) = getimagesize($img);
									
									$width = $_width * 0.2;
									$height = $_height * 0.2;
									
								?>
									<div class="row-fluid arquivo">
										<a href="Controller/Direciona.php?id=<?php echo $arquivos[$i]['id']; ?>&nome=arquivos" 
										   style="text-decoration: none; color: black;">
											<div class="span4">
												<img src="thumbnails.php?file=<?php echo $img;?>&width=<?php echo $width; ?>&height=<?php echo $height; ?>" />
											</div>
											<div class="span8" style="padding-left: 5px;">
												<span style="font-size: 15px;">
													<b><?php echo $arquivos[$i]['nome']; ?></b>
												</span>
												<br>
												<span style="font-size: 14px;">
													<?php echo $arquivos[$i]['descricao']; ?>
												</span>
											</div>
										</a> 
	                                </div> 
	                                <hr>
								<?php
								}
	                         	?>
							</div>
						</div>

						<div class="box span5">
                        	<p style="margin-left: 10px;">	
								<b>Top 10 - Archivos más bajados</b>
							</p>
                            <hr>
							<div class="box-conteudo">
                            <?php
							$arquivos = GetArquivosMaisBaixados();
							$n = count($arquivos);
							
							if ($n == 0)
								{
								?>
									<div class="row-fluid arquivo">
										<div class="alert alert-info">
											Ningún archivo se descargó hasta la fecha
										</div>
	                                </div> 
								<?php
								}
							
							for ($i = 0; $i < $n; $i++)
							{
								if ($arquivos[$i]['ndownloads'] == 0)
									continue;
								
								$img = GetImageFromType($arquivos[$i]);
								
								list($_width, $_height, $type, $attr) = getimagesize($img);
								
								$width = $_width * 0.2;
								$height = $_height * 0.2;
								
							?>
								<div class="row-fluid arquivo">
									<a href="Controller/Direciona.php?id=<?php echo $arquivos[$i]['id']; ?>&nome=arquivos" 
										   style="text-decoration: none; color: black;">
										<div class="span4">
											
											<img src="thumbnails.php?file=<?php echo $img;?>&width=<?php echo $width; ?>&height=<?php echo $height; ?>" />
										</div>
										<div class="span8" style="padding-left: 5px;">
											<span style="font-size: 15px;">
												<b><?php echo $arquivos[$i]['nome']; ?></b>
											</span>
											<br>
											<span style="font-size: 14px;">
												<?php echo $arquivos[$i]['descricao']; ?>
											</span>
										</div>
									</a> 
                                </div> 
                                <hr>
							<?php
							}
                         	?>
							</div>
						</div>

						
						</div>
					</div>

			</div>
        </div>
	</body>
</html>