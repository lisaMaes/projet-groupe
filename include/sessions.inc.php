<?php
function CheckSessionExpire()
{
	if (isset($_SESSION['USER']['token']))
	{
		// test le délais de connexion, si > 60min, déconnecte automatiquement

		//echo (strtotime("now")-$_SESSION['USER']['token']). "***<br>";
		if((strtotime("now")-$_SESSION['USER']['token'])>60)
		{
			?>
			<!DOCTYPE html>
			<html lang="fr">
			<head>
				<!-- Required meta tags -->
				<meta charset="utf-8">
				<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

				<!-- Bootstrap CSS -->
				<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">
				<link rel="stylesheet" href="../styles/jquery.dataTables.min.css">
				<link rel="stylesheet" href="../styles/style.css">

			</head>
			<body>
				


				<header>
					<h1>
						Eat-eee !! Backoffice
					</h1>
				</header> 

				<main>
					<div class="container-fluid">

						<div class="row">
							<div class="col-md-offset-2 col-md-8">
								<br><br>

								<div class="alert alert-danger" role=alert>Votre session à expiré<br><br>Merci de vous <a href="http://localhost/projet-gorupe/formconnexion.php">reconnecter</a></div>

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





				<?php



				unset($_SESSION['USER']);
				die();
			}
		}
	}




	function CheckUnauthent()
	{
		// test si l'utilisateur authentifié est de type admin, sinon le boute hors du 


		if (!isset($_SESSION['USER']['type']) OR $_SESSION['USER']['type']!=1)
		{
			header('HTTP/1.0 403 Forbidden');
			?>
			<!DOCTYPE html>
			<html lang="fr">
			<head>
				<!-- Required meta tags -->
				<meta charset="utf-8">
				<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

				<!-- Bootstrap CSS -->
				<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">
				<link rel="stylesheet" href="../styles/jquery.dataTables.min.css">
				<link rel="stylesheet" href="../styles/style.css">

			</head>
			<body>
				


				<header>
					<h1>
						Eat-eee !! Backoffice
					</h1>
				</header> 

				<main>
					<div class="container-fluid">

						<div class="row">
							<div class="col-md-offset-2 col-md-8">
								<br><br>

								<div class="alert alert-danger" role=alert>Vous n'avez rien à foutre là !<br><br>Retour à la <a href="http://localhost/projet-groupe">page  d'accueil</a></div>

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


				<?php



				die();

			}
		}



		?>




