<?php
session_start();




//verifie que le formulaire soit rempli
if(!empty($_POST)){

//verifie le champ email
	if(isset($_POST['email']) AND !empty($_POST['email'])){

		if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){

			$errors[] = "email invalide";
		}
	} else {

		$errors[] = "Veuillez remplir l'email'!";
	}

//verifie le champ mot de passe
	if(isset($_POST['password']) AND !empty($_POST['password'])){

		if(!preg_match('#^.{3,50}$#i', $_POST['password'])){

			$errors[] = "mot de passe incorrect";
		}
	} else {

		$errors[] = "Veuillez remplir le mot de passe!";
	}

//si bien rempli et valide
	if(!isset($errors)){
		//connexion a la base de données
		include('include/connexion.inc.php');
		
		$response = $bdd->prepare("SELECT * FROM users WHERE email= ?");

		$response->execute(
			array(
				$_POST['email']
				)
			);

		$accountInfos = $response->fetch(PDO::FETCH_ASSOC); //forcer le tableau associatif

		//comparaison des données en base avec celle du formulaire
		if (!empty($accountInfos)) {


			if(password_verify($_POST['password'], $accountInfos['password'])){

				$_SESSION['USER']['ID']=filter_var($accountInfos['ID'],FILTER_VALIDATE_INT);
				$_SESSION['USER']['pseudo']=htmlspecialchars($accountInfos['pseudo']);
				$_SESSION['USER']['type']=filter_var($accountInfos['type'],FILTER_VALIDATE_INT);
				$_SESSION['USER']['token']=strtotime("now");			

				$success ='vous êtes bien connectés!';
			} else {
				$errors[]= 'Mot de passe incorrect';
			}
		}else {
			$errors[]= 'Compte inexistant';
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
	<link rel="stylesheet" href="styles/style.css">

</head>
<body>
	


	<header>
		<h1>
			Eat-eee !! - Connexion
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
					if (isset($_SESSION['USER']['pseudo']))
					{
						if(isset($success)){
							echo '<div class="alert alert-success" role="alert">
							<strong>'.$success.'</strong></div>';
						}
						else
						{
							echo '<div class="alert alert-info" role=alert>Vous êtes déjà connecté</div>';
						}

					}
					else
					{

					    // Si l'array $errors existe, on extrait toutes les erreurs qu'il contien avec un foreach et on les affiches
						if(isset($errors)){
							foreach($errors as $error){
								echo '<div class="alert alert-danger" role="alert">
								<strong>'.$error.'</strong></div>';
							}
						}


						?>



						<form action="" method="POST" class="form-horizontal">
							<fieldset>

								<!-- Form Name -->
								<legend>Identifiez-vous!</legend>

								<!-- Text input-->
								<div class="form-group">
									<label class="col-md-4 control-label" for="email">Email</label>  
									<div class="col-md-4">
										<input id="email" name="email" type="text" placeholder="Email" class="form-control input-md" required="">
									</div>
								</div>

								<!-- Password input-->
								<div class="form-group">
									<label class="col-md-4 control-label" for="password">Password</label>
									<div class="col-md-4">
										<input id="password" name="password" type="text" placeholder="Password" class="form-control input-md" required="">
									</div>
								</div>

								<!-- Button -->
								<div class="form-group">
									<label class="col-md-4 control-label" for="singlebutton"></label>
									<div class="col-md-4">
										<button id="singlebutton" name="singlebutton" class="btn btn-primary">Envoyer</button>
									</div>
								</div>

							</fieldset>
						</form>

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
