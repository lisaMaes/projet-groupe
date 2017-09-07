<?php
session_start();

require_once('include/sessions.inc.php');
CheckSessionExpire();

if(isset($_SESSION['USER']['ID']) && !empty($_SESSION['USER']['ID']))
{
	$strId=$_SESSION['USER']['ID'];
}
else
{
	$strId=0;
}



// Permet d'afficher les infos de la fiche restau si ID existe


if ($strId>0 && $strId<=9999999999)
{
	require('include/connexion.inc.php');

	$requete=$bdd->prepare('SELECT * FROM users WHERE ID=?');
	$requete->execute(array($strId));
	$resultat=$requete->fetch(PDO::FETCH_ASSOC);

	if($requete->rowCount() > 0){

		$pseudo= $resultat['pseudo'];
		$email= $resultat['email'];

		$requete->closeCursor();	

	}else{

		$errors = "Cet utilisateur n'existe pas";

	}

}else{

	$errors = "Il n'y a pas d'utilisateur a affiché";

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
			Eat-eee !! Bienvenue <?php

			if(!isset($errors)){
				echo htmlspecialchars($pseudo); 

			}?>
			
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
					if(isset($errors)){

						echo '<div class="alert alert-danger" role=alert>'.htmlspecialchars($errors).'</div>';

					}else{

						?>

						<h2>Pseudo : <?php echo htmlspecialchars($pseudo); ?></h2>

						<p>Email : <?php echo htmlspecialchars($email); ?></p>

						<?php

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
