<?php

include ("InicializaPagina.php");

require_once ("Controller/Marcas.php");

$status = null;
if (isset($_GET['status']))
{
	$status = $_GET['status'];
}
	
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
                
                 <div class="escolher-marca">
                 <div class="span10">
                	
                	<h3 class="muted" align="center">Eligir una vacuna</h3>
                	
                	<hr><br>
                	
                	<?php
                	if (isset($status))
					{
						if ($status == "error")
						{
							echo "<div class='alert alert-error'>
									<button type='button' class='close' data-dismiss='alert'>&times;</button>
									Vacuna no es válida, elegir de nuevo.
								 </div>";
						}
					}
                	?>
                	
                	<?php
                	$marcas = ListaMarcas();
					
					$n = count($marcas);
					if ($n == 0)
					{
						echo "<div class='alert alert-info'>No hay vacuna agregada.</div>";
					}
					
					$c = 0;
					for ($i = 0; $i < $n; $i++)
					{
						$id = $marcas[$i]['id'];
						$nome = $marcas[$i]['nome'];
						$img = $marcas[$i]['imagem'];
						
						if ($c == 5)
						{
							$c = 0;
							echo "<br>";
						}
					?>
						<div class="span2 arquivos_marca">
                			<a href="arquivos-lista.php?marca=<?php echo $id; ?>&name=<?php echo $nome; ?>">
                				<img class="pasta-image" src="<?php echo $_SESSION['marcasImagePrefix'] . $img; ?>" />
                			</a>
                			<p align="center" style="color: #666666	"><?php echo $nome; ?></p>
                		</div>
					<?php
					}
                	?>
                </div>
			</div>
            </div>
     	</div>
	</body>
</html>	