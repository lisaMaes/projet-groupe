<?php
//recupère l'id
if (isset($_POST['ID']))
{
	$strId=filter_var($_POST['ID'],FILTER_VALIDATE_INT);
}
elseif (isset($_GET['ID']))
{
	$strId=filter_var($_GET['ID'],FILTER_VALIDATE_INT);
}
else
{
	$strId=0;
}

// Permet d'afficher les infos de la fiche restau si ID existe
require('include/connexion.inc.php');

if ($strId>0 && $strId<=9999999999)
{

	$requete=$bdd->prepare('SELECT * FROM restaurants WHERE ID=?');
	$requete->execute(array($strId));
	$resultat=$requete->fetch(PDO::FETCH_ASSOC);

	if($requete->rowCount() > 0){

	$strLibelle=$resultat['name'];
	$strAdresse=$resultat['adress'];
	$strCP=$resultat['zipcode'];
	$strVille=$resultat['city'];
	$strTelephone=$resultat['telephone'];
	$image=$resultat['image'];

	$requete->closeCursor();

}else{

		$errors = "Ce restaurant n'existe pas";

	}

}else{

	$errors = "Il n'y a pas de restaurant a affiché";

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
	<link rel="stylesheet" href="../styles/jquery.dataTables.min.css">
	<link rel="stylesheet" href="../styles/style.css">

</head>
<body>



	<header>
		<h1>
			Eat-eee !! <?php 
			if(!isset($errors)){
			echo htmlspecialchars($strLibelle); 
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
				<div class="col-md-12">
					
						<?php
						//traitement d'affichage 
						if(isset($errors)){

							echo '<div class="alert alert-danger" role=alert>'.htmlspecialchars($errors).'</div>';

						}else{
 
					?>

					<h2><?php echo htmlspecialchars($strLibelle); ?></h2>

					<div class = "col-md-8"><?php echo '<img src ="img_restau/'.htmlspecialchars($image).'" style ="width : 100%;">'; ?></div>

					<div class="col-md-2">
						<h3>Contacts</h3>
						<?php echo	htmlspecialchars($strTelephone) ?><br><br>
						<?php echo htmlspecialchars($strAdresse) ?><br>	
						<?php echo htmlspecialchars($strCP).' '. htmlspecialchars($strVille)?>
				
					</div>

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
	<script src="../scripts/jquery.dataTables.min.js"></script>

</body>
</html>
