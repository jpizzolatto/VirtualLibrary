<?php

include ("InicializaPagina.php");

require_once ("Controller/Categorias.php");
require_once ("Controller/Grupos.php");


if (!isset($_GET['id']))
{
	header("location: grupos.php?status=error");
}

$id = $_GET['id'];

$grupo = GetGrupo($id);

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
                
				<div class="altera-grupo">
                <div class="span10">
				<h3 class="muted" align="center">Cambiar grupo</h3>
				<hr><br>
                </div>
                </div>

				<div class="span10">
				<div class="form-grupo">
					<form class="form-horizontal" method="post" action="Controller/Grupos.php">
						
						<div class="control-group">
							<label class="control-label" for="inputName">Nombre</label>
							<div class="controls">
								<input class="input-xxlarge" type="text" id="GRP_NOME" name="GRP_NOME" placeholder="Name"
								value="<?php echo $grupo['nome']; ?>">
							</div>
						</div>
						
						<div class="control-group">
							<label class="control-label" for="inputCategorias">Categorías</label>
							<div class="controls">
								<?php
								$cats = GetCategorias();
								
								$n = count($cats);
								if ($n == 0)
								{
									echo "<div class='alert alert-info'>No tiene categoria registrada.</div>";;
								}
								
								$c = 0;
								for ($i = 0; $i < $n; $i++)
								{
									$id_cat = $cats[$i]['id'];
									$nome_cat = $cats[$i]['nome'];
									
									if ($c == 5)
									{
										$c = 0;
										echo "<br>";
									}
									
									$check = strpos($grupo['categorias'], $id_cat);
								?>	
									<label class="checkbox inline">
										<input type="checkbox" id="GRP_CATS[]" name="GRP_CATS[]"
											   <?php if ($check === FALSE) echo ''; else echo 'checked="checked"';?>" 
											   value="<?php echo $id_cat; ?>"> <?php echo $nome_cat; ?> 
									</label>
								<?php
									$c++;
								}
								 
								?>
							</div>
						</div>
						<div class="control-group">
							<div class="controls" id="listaCategorias">
            					<input type="hidden" name="marcaID" id="marcaID" value="<?php echo $id; ?>" />
								<input type="hidden" name="altSubmitted" id="altSubmitted" value="1" />
								<button type="submit" class="btn btn-primary">
									Alterar
								</button>
							</div>
						</div>
					</div>
				</form>
                </
			</div>
		</div>
	</body>
</html>
