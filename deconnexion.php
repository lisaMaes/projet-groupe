<?php
session_start();
if (isset($_SESSION['USER']['pseudo']))
{
	unset($_SESSION['USER']);
	$success="Vous êtes à présent déconnecté";
}
else
{
	$erreur="Aucune session active à supprimer";
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="styles/style.css">

</head>
<body>
	


	<header>
		<h1>
			Eat-eee !! - Inscription
		</h1>
	</header> 

	<main>
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<?php 
					require('include/menu.inc.php');
					?>
				</div>
			</div>

			<div class="row">
				<div class="col-md-offset-2 col-md-8">
					<?php

					//affichage des erreurs
					if(isset($erreur)){
						echo '<div class="alert alert-warning" role=alert>'.$error.'</div>';
					}

						//affichage du message de succès
					if(isset($success)){


						echo '<div class="alert alert-info" role=alert>'.$success.'</div>';
					}

					?>

				</div>
			</div>




		</div>
	</main>

	<footer>
	</footer>



	<!-- jQuery first, then Tether, then Bootstrap JS. -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>

</body>
</html>
