<?php
session_start();

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

//Verifie que la personne soit connectée
	if(!isset($_SESSION['USER'])){

		$errors1[] = 'Veuillez vous connecter pour laisser un commentaire';

	}
//verification de l'envoi du formulaire commentaire
if(!empty($_POST)){

	$comment = $_POST['comment'];
	$ID_user = $_SESSION['USER']['ID'];
	$ID_restau = $_POST['ID'];

//verifie qu'il ne soit pas vide
	if(!isset($comment) || empty($comment)){

		$errors1[]= 'Veuillez remplir le champ commentaires';

	}



if(empty($errors1)){

	//connexion en base pour l'insertion

	$requete1 = $bdd->prepare('INSERT INTO comments (ID_restaurant, ID_users, comments) VALUES (:ID_restaurant, :ID_users, comments)');
	$requete1->bindValue(':ID_restaurant', $ID_restau);
	$requete1->bindValue(':ID_users', $ID_user);
	$requete1->bindValue(':comments', $comment);

	$requete1->execute();

	//Teste si une ligne a bien été insérée

	if($requete1->rowCount() !=0){

		$success1 = 'Merci pour votre commentaire';

		$requete1->closeCursor();
	
	}else{

		$errors1[] = 'L\'ajout a échoué veuillez réessayer plus tard';

	}

}

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

					<div class = "col-md-8"><?php echo '<img src ="img_restau/'.htmlspecialchars($image).'" style ="width : 100%;">'; ?>
						


					</div>

					<div class="col-md-4">
						<h3>Contacts</h3>
						<?php echo	htmlspecialchars($strTelephone) ?><br><br>
						<?php echo htmlspecialchars($strAdresse) ?><br>	
						<?php echo htmlspecialchars($strCP).' '. htmlspecialchars($strVille)?>

						<br><br><a href="index.php" class="btn btn-info">Retour</a>
						<br><br>
			<!-- formulaire -->
						<div class="col-md-12">
							<?php 
							//affichage des erreurs  pour les commentaires
								if(isset($errors1)){

									foreach ($errors1 as $error) {

									echo '<div class="alert alert-danger" role=alert>'.$error.'</div>';
									}
								}

							//affichage du message de succès
							if(isset($success)){


								echo '<div class="alert alert-info" role=alert>'.$success.'</div>';
							}
							 ?>
	<!-- formulaire de commentaire -->
							<?php 
								if(isset($_SESSION['USER'])){
							 ?>
								<form class="form-horizontal" action="" method="POST">
									<fieldset>

									<!-- Form Name -->
										<legend>Donnez votre avis</legend>

										<!-- Text input-->
										<div class="form-group">
											<label class="col-md-4 control-label" for="ID"></label>  
											<div class="col-md-4">
												<input id="ID" name="ID" placeholder="" class="form-control input-md" type="hidden" value=" <?php echo filter_var($_GET['ID'], FILTER_VALIDATE_INT); ?> ">

											</div>
										</div>

										<!-- Textarea -->
										<div class="form-group">
										
											<div class="col-md-12">                     
												<textarea class="form-control" id="comment" name="comment">default text</textarea>
											</div>
										</div>

										<!-- Button -->
										<div class="form-group">
											<label class="col-md-4 control-label" for="button"></label>
											<div class="col-md-4">
												<button id="button" name="button" class="btn btn-info">Valider</button>
											</div>
										</div>

									</fieldset>
								</form>
							<?php }
							 ?>
							
						</div>
				
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
