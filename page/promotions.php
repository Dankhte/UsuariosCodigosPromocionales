<?php
    include('../connection/connectionToBBDD.php');
    include('../class/promocode.php');

    $promocode = new promocode();

    // Login
    if (!empty($_POST['generatePromoCode'])) {
		$hasGeneratedPromoCode = $promocode->generate($_SESSION['username']);
		if ($hasGeneratedPromoCode) {
			// CÓDIGO GENERADO
		} else {
			// ERROR AL GENERAR
		}
    }

    // Canjear códido
    if (!empty($_POST['promocode'])) {
		$hasRedeemedPromoCode = $promocode->redeem($_POST['promocode']);
		if ($hasRedeemedPromoCode) {
			// CÓDIGO CANJEADO
		} else {
			// ERROR AL CANJEAR
		}
    }

?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Códigos promocionales - Prueba - User History</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>
<body>

	<div>
		<h1>Bienvenido <?php echo $_SESSION['username']?></h1>

		<form class="generate-promocode-form" action="" method="post">
			<input type="hidden" name="generatePromoCode" value="true"></input>
			<button type="submit">Generar Código Promocional</button>
		</form>

		<h2>Tus código promocionales</h2>
		<ul>
			<?php 
				$dataPromoCodes = $promocode->showPromoCodes($_SESSION['username']);
				if ($dataPromoCodes) {
					foreach ($dataPromoCodes as $code) {
						echo '<li>' . $code['code'] .  ' => ';
						if ($code['redeemed']) {
							echo 'Canjeado';
						} else {
							echo '<button class="redeemPromoCode" data-code="' . $code['code'] . '">Canjear</button>';
						}
						echo '</li>';
					}
				} else {
					echo "<p>Ahora no tienes ningún código, prueba a generar uno.</p>";
				}
				
			?>
		</ul>

	</div>

	<a href="#" class="logout-button">Cerrar sesión</a>

	<script>
		$(document).ready(function () {
		    $('.logout-button').on('click', function () {
		    	var form = $('<form method="post" action="../index.php"></form>');
		    	form.append('<input type="hidden" name="logout" value="true">');
		    	$('body').append(form);
	    		form.submit();
		    });

		    $('.generate-promocode-form').on('submit', function () {
		    	var generate = confirm("¿Quieres generar un nuevo código promocional?");
		    	if (!generate) {
		    		return false;
		    	}
	    	});

		    $('.redeemPromoCode').on('click', function () {
		    	var promoCode = $(this).data('code');
		    	var redeem = confirm("¿Quieres canejar el código promocional " + promoCode + "?");
		    	if (redeem) {
					var form = $('<form method="post" action=""></form>');
			    	form.append('<input type="hidden" name="promocode" value="' + promoCode + '">');
			    	$('body').append(form);
		    		form.submit();
		    	}
		    });
		});
	</script>

</body>
</html>