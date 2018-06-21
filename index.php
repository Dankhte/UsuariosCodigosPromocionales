<?php
	/*
	if (!empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS'])) {
		$uri = 'https://';
	} else {
		$uri = 'http://';
	}
	$uri .= $_SERVER['HTTP_HOST'];
	header('Location: '.$uri.'/dashboard/');
	exit;
	*/

    include('connection/connectionToBBDD.php');
    include('class/user.php');

    $user = new user();

    // Login
    if (!empty($_POST['login'])) {
		$username = $_POST['username'];
		$password = $_POST['password'];
		if (!empty($username) && !empty($password)) {
			$loggedUser = $user->login($username, $password);
			if ($loggedUser) {
				header("Location: page/promotions.php");
			} else {
				// ERROR LOGIN
			}
		}
    }

    // Registro
    if (!empty($_POST['registration'])) {
		$username = $_POST['username'];
		$password = $_POST['password'];
		$isValidUsername = strlen($username) <= 50;
		if ($isValidUsername) {
			$loggedUser = $user->registration($username, $password);
			if ($loggedUser) {
				header("Location: page/promotions.php");
			} else {
				// ERROR REGISTRO
			}
		} else {
			// NOMBRE DE USUARIO DEMASIADO LARGO
		}

    }

    // Cerrar sesión
    if (!empty($_POST['logout'])) {
		$_SESSION['username'] = "";
    }

?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Home - Prueba - User History</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>
<body>

	<div>
		<div class="login-section">
			<h1>Login</h1>
			<form class="login-form" action="" method="post">
				<label>Nombre de usuario</label>
				<input type="text" name="username" required autofocus></input>
				<label>Contraseña</label>
				<input type="password" name="password" required></input>
				<input type="hidden" name="login" value="true"></input>
				<button type="submit">Entrar</button>
			</form>
			<a href="#" class="show-registration-button">Regístrate</a>
		</div>
		<div class="registration-section" style="display: none;">
			<h1>Registro</h1>
			<form class="registration-form" action="" method="post">
				<label>Nombre de usuario</label>
				<input type="text" name="username" required autofocus></input>
				<label>Contraseña</label>
				<input type="password" name="password" required></input>
				<input type="hidden" name="registration" value="true"></input>
				<button type="submit">Registrarse</button>
			</form>
			Ya tengo cuenta, quiero hacer <a href="#" class="show-login-button">login</a>
		</div>
	</div>

	<script>
		$(document).ready(function () {
		    $('.show-registration-button').on('click', function () {
		    	$('.login-section').hide();
	    		$('.registration-section').show();
		    });

		    $('.show-login-button').on('click', function () {
	    		$('.registration-section').hide();
	    		$('.login-section').show();
		    });
		});
	</script>

</body>
</html>