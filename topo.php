

	<div class="row-fluid span12">

    	<div class="logos">

		<div class="span6">

			<img src="img/Merial.png"/>

		</div>

		<div class="offset6">

			<img class="logo" src="img/sanofi.png"/>

		</div>

        </div>

	</div>

	

<?php



	$currentUser = $_SESSION['usuario'];

	

	$nome = explode(" ", $currentUser->Nome);

	

	if ($currentUser->isAdmin == FALSE)

	{

?>

    <div class="row-fluid span12">

		<div class="span11">

			<div class="menu">

				<ul class="nav">

					<ul class="inline">

						<li class="active">

							<a href="home.php">Home</a>

						</li>

						<li>

							<img src="img/separador.png" />

						</li>

						<li>

							<a href="solicitacoes.php">Solicitaciones</a>

						</li>

						<li>

							<img src="img/separador.png" />

						</li>

						<li>

							<a href="contato.php">Contato</a>

						</li>

						<li>

							<img src="img/separador.png" />

						</li>

						<li class="offset4">

							<p>

								Bienvenido, <b><?php echo $nome[0]; ?></b>

								<a href="Controller/logout.php" style="padding-left: 10px; text-decoration: underline;"> Salir </a>

							</p>

						</li>

					</ul>

				</ul>

			</div>

		</div>

    </div>



<?php

	}

	else 

	{

?>

	<div class="row-fluid span12">

		<div class="menu">

			<ul class="nav">

				<ul class="inline">

					<li class="active">

						<a href="index.php">Home</a>

					</li>

					<li>

						<img src="img/separador.png" />

					</li>

					<li>

						<a href="marcas-admin.php">Vacunas</a>

					</li>

					<li>

						<img src="img/separador.png" />

					</li>

					<li>

						<a href="usuarios.php">Usuarios</a>

					</li>

					<li>

						<img src="img/separador.png" />

					</li>

                    <li>

						<a href="grupos.php">Grupos</a>

					</li>

					<li>

						<img src="img/separador.png" />

					</li>

                    <li>

						<a href="categorias.php">Categorías</a>

					</li>

					<li>

						<img src="img/separador.png" />

					</li>

					<li>

						<a href="solicitacoes-lista.php">Solicitaciones</a>

					</li>

					<li>

						<img src="img/separador.png" />

					</li>

					<li>

						<a href="arquivos-marcas.php">Archivos</a>

					</li>

					<li>

						<img src="img/separador.png" />

					</li>

					

					<li style="margin-left: 10px;">

						<p>

							Bienvenido, <b><?php echo $nome[0]; ?></b>

							<a href="Controller/logout.php" style="padding-left: 10px; text-decoration: underline;"> Salir </a>

						</p>

					</li>

				</ul>

			</ul>

		</div>

	</div>

<?php

	}



	$text = null;

	if (isset($_SESSION['search_text']))

	{

		$text = $_SESSION['search_text'];

	}

?>

	<div class="span12 search">

		<div class="span12">

			<div class="span3 search-text">

				<h4 class="muted">¿Qué necesitas?</h4>

			</div>

			<form action="Controller/Busca.php" method="post" name="searchForm">

				<div class="span6 search-box">

					<input class="appendedInputButton input-large search-query" type="text"

							name="searchText" id="searchText"

							<?php if($text != null) echo "value='$text'"; ?> />

				</div>

				<div class="span2">

					<button type="submit" class="btn search-button">

						Búsqueda

					</button>

				</div>

			</form>

		</div>

	</div>

