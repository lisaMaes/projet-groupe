<?php
//test si le formulaire a été envoyé
if (!empty($_POST)) {


	$pseudo = $_POST['pseudo'];
	$password = $_POST['password'];
	$email =$_POST['email'];
	
	//teste si le pseud est valide et rempli
	if(isset($pseudo) && !empty($pseudo)){

<<<<<<< HEAD

//protection contre injection sur le pseudo
		if(!preg_match('#^([0-9a-z \-áàâäãåçéèêëíìîïñóòôöõúùûüýÿæœÁÀÂÄÃÅÇÉÈÊËÍÌÎÏÑÓÒÔÖÕÚÙÛÜÝŸÆŒ]{3,30})$#', $pseudo)){
=======
		if(!preg_match('#^([0-9a-z \-áàâäãåçéèêëíìîïñóòôöõúùûüýÿæœÁÀÂÄÃÅÇÉÈÊËÍÌÎÏÑÓÒÔÖÕÚÙÛÜÝŸÆŒ]{3,30})$#', $pseudo)){

			include('connexion.inc.php');

			$errors[]= 'Ceci n\'est pas un email valide';

			$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			$response = $bdd->prepare('SELECT pseudo FROM users WHERE pseudo = ?');

			$response->execute(
				array($pseudo)
				);

			if($response->rowCount == 0) {

				$success = true;
				
			}else{

				$errors[] = 'Veuillez choisir un autre pseudo. Celui ci est déjà existant';

			}

			$response->closeCursor();
>>>>>>> 2b311c775f727cd22bbd8f3015e913efb4919e41

			
			$errors[]= 'Ceci n\'est pas un pseudo valide';

		}

	}else{

		$errors[]= 'Veuillez saisir un pseudo';

	}

//verifie que le mail soit rempli et valide
	if(isset($email) && !empty($email)){


//verifie qu'il n'y est pas d'injection via le mail
		if(!preg_match('#^((((\w){1,100}[\.\-])?\w{1,100}[^\.\.][^.]@\w{1,200}[^\.\.]\.\w{1,50})(\.\d\.\d)?)$#', $email)) {
			
			$errors[]= 'Veuillez renseigner une adresse mail valide';

		}

	}else{

		$errors[]= 'Veuillez remplir le champ email';

	}

//verifie la validité et le remplissage du mot de passe
	if(isset($password) && !empty($password)){

//verifie qu'il n'y est pas d'injection via mot de passe
		if(!preg_match('#^.{3,50}$#', $password)){

			$errors[]= 'Veuillez rentrer un mot de passe valide';

		}

	}else{

		$errors[]='Veuillez créer un mot de passe';

	}


// Si le proccessus est valide jusque là 
	if(empty($errors)){

			require('include/connexion.inc.php');

//connexion base pour doublon pseudo
			$response = $bdd->prepare('SELECT pseudo FROM users WHERE pseudo = ?');

			$response->execute(
				array($pseudo)
				);
//verifie qu'il n'y ait pas de doublon pseudo
				if($response->rowCount() > 0) {


					$errors[] = 'Veuillez choisir un autre pseudo. Celui ci est déjà existant';

				}

			$response->closeCursor();

//connexion base doublon email
			$response3 = $bdd->prepare('SELECT pseudo FROM users WHERE email = ?');

			$response3->execute(
				array($email)
				);


//verifie qu'il n'y ait pas de doublon d'email
				if($response3->rowCount() > 0) {


					$errors[] = 'Cette addresse possède déjà un compte chez nous. Veuillez en rentrer une autre';

				}

<<<<<<< HEAD
			$response3->closeCursor();

		}


	if(empty($errors)){

//création empreinte du mot de passe
		$hash = password_hash($password, PASSWORD_BCRYPT, array('cost' => 10));

//connexion en base pour l'insertion
		$response1 = $bdd->prepare('INSERT INTO users (pseudo, email, password) VALUES (:pseudo, :email, :password)');

		$response1->bindValue(':pseudo',htmlspecialchars(mb_strtolower($pseudo)) );
		$response1->bindValue(':email',htmlspecialchars($email));
		$response1->bindValue(':password',$hash);

		$response1->execute();

	
//test qu'une ligne à bien été insérée
	if($response1->rowCount() != 0){
        
            $success = 'L\'ajout du compte '.htmlspecialchars($pseudo).' : '.htmlspecialchars($email). ' est bien effectuée.';

            $response1->closeCursor();
=======
	if($response->rowCount() != 0){

		$success = 'L\'ajout du compte '.htmlspecialchars($pseudo).' : '.htmlspecialchars($email). ' est bien effectué.';
>>>>>>> 2b311c775f727cd22bbd8f3015e913efb4919e41

		$response->closeCursor();

	}else{

		$errors[] = 'L\'ajout n\'a pas pu être effectué.';

<<<<<<< HEAD
        }
	}
=======
	}

>>>>>>> 2b311c775f727cd22bbd8f3015e913efb4919e41

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
<<<<<<< HEAD
					//affichage des erreurs
						if(isset($errors)){
=======
					if(isset($errors)){
>>>>>>> 2b311c775f727cd22bbd8f3015e913efb4919e41

						foreach ($errors as $error) {

							echo '<div class="alert alert-danger" role=alert>'.$error.'</div>';
						}
<<<<<<< HEAD
//affichage du message de succès
						if(isset($success)){


							echo '<div class="alert alert-info" role=alert>'.$success.'</div>';
						}
					 ?>
<!-- formulaire d'inscription -->
=======
					}

					if(isset($success)){


						echo '<div class="alert alert-info" role=alert>'.$success.'</div>';
					}
					?>

>>>>>>> 2b311c775f727cd22bbd8f3015e913efb4919e41
					<form class="form-horizontal" action="" method="POST">
						<fieldset>

							<!-- Form Name -->
							<legend>Rejoignez-nous</legend>

							<!-- Text input-->
							<div class="form-group">
								<label class="col-md-4 control-label" for="pseudo">Pseudo</label>  
								<div class="col-md-4">
									<input id="pseudo" name="pseudo" placeholder="" class="form-control input-md" required="" type="text">

								</div>
							</div>

							<!-- Text input-->
							<div class="form-group">
								<label class="col-md-4 control-label" for="email">Email</label>  
								<div class="col-md-4">
									<input id="email" name="email" placeholder="jean@test.fr" class="form-control input-md" required="" type="email">

								</div>
							</div>

							<!-- Text input-->
							<div class="form-group">
								<label class="col-md-4 control-label" for="password">Mot de passe</label>  
								<div class="col-md-4">
									<input id="password" name="password" placeholder="" class="form-control input-md" required="" type="password">

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
