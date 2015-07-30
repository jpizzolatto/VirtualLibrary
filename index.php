<?php
session_start();

if (isset($_SESSION['logado']))
{
	if ($_SESSION['logado'] == true)
	{
		header ('location: home.php');
	}
}
?>
<!-- Inicio do HTML -->
	<?php
	include ("header.php");
	?>

    <div id="login">
        <img class="logomerial" src="img/logo.png" />
        <div class="form-login">
            <form id="form1" class="form-horizontal" name="form1" method="post" action="Controller/logar.php">
                <div class="control-group">
                    <label class="control-label" for="inputLogin">Usuario</label>
                    <div class="controls">
                        <input type="text" id="inputLogin" name="inputLogin" placeholder="Login">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="inputSenha">Contraseña</label>
                    <div class="controls">
                        <input type="password" id="inputSenha" name="inputSenha" placeholder="Senha">
                        <?php
                        if (isset($_GET['error'])) {
                            echo "<span class='label label-important error'>" . $_GET['error'] . "</span>";
                        }
                        ?>
                    </div>

                </div>
                <div class="control-group buttons<?php if(isset($_GET['error'])) echo "-error"; ?>">
                    <button type="submit"> <img src="img/login.png">   </button>
                    <button class="btn-link">
                        <a href="#">¿Olvidaste tu contraseña?</a>
                    </button>
                </div>
            </form>
        </div>

    </div>
</html>