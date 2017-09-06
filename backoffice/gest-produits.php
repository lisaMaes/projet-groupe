<?php


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


include('../connexion.inc.php');


if (!empty($_POST) && isset($_POST['btnEnvoyer']))
{

	if (isset($_POST['name'])  && !empty($_POST['name']))
	{
		$strLibelle=$_POST['name'];
		if (!preg_match('#^[^\<\>\"\&]{3,75}$#i',$strLibelle)){
			$tErreurs[]="Merci de saisir un Libellé correct (de 3 à 75 caractères hors spéciaux)";
		}
	}
	else
	{
		$tErreurs[]="Veuillez saisir un Libellé";
	}

	if (isset($_POST['adress'])  && !empty($_POST['adress']))
	{
		$strAdresse=$_POST['adress'];
		if (!preg_match('#^[^\<\>\"\&]{3,75}$#i',$strAdresse)){
			$tErreurs[]="Merci de saisir une Adresse correct (de 3 à 75 caractères hors spéciaux)";
		}
	}
	else
	{
		$tErreurs[]="Veuillez saisir une Adresse";
	}

	if (isset($_POST['cp'])  && !empty($_POST['cp']))
	{
		$strCP=$_POST['cp'];
		if (!preg_match('#^[0-9]{5}$#i',$strCP)){
			$tErreurs[]="Merci de saisir un Code Postal correct (de 5 caractères hors spéciaux)";
		}
	}
	else
	{
		$tErreurs[]="Veuillez saisir un Code Postal";
	}


	if (isset($_POST['city'])  && !empty($_POST['city']))
	{
		$strVille=$_POST['city'];
		if (!preg_match('#^[^\<\>\"\&]{3,50}$#i',$strVille)){
			$tErreurs[]="Merci de saisir une Adresse correct (de 3 à 50 caractères hors spéciaux)";
		}
	}
	else
	{
		$tErreurs[]="Veuillez saisir une Adresse";
	}




		/*if (!isset($tErreurs)){

			$requete=$link->prepare('INSERT INTO fruits (fruitName,color) VALUES(?,?)');
			$requete->execute(array(
				$strLibelle,
				$strCouleur
				));

			if ($requete->rowCount()>0)
			{
				$success="Vous venez d'ajouter un fruit. Vous pouvez dès à présent en ajouter un autre";
			}
		}*/

	}











	if ($strId>0 && $strId<=9999999999)
	{

		$requete=$bdd->prepare('SELECT * FROM restaurants WHERE ID=?');
		$requete->execute(array($strId));
		$resultat=$requete->fetch(PDO::FETCH_ASSOC);

		$strLibelle=$resultat['name'];
		$strAdresse=$resultat['adress'];
		$strCP=$resultat['zipcode'];
		$strVille=$resultat['city'];
		$strTelephone=$resultat['telephone'];
		$strMail=$resultat['email'];
	}
	else
	{
		$strLibelle="";
		$strAdresse="";
		$strCP="";
		$strVille="";
		$strTelephone="";
		$strMail="";
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
				Eat-eee !! Backoffice
			</h1>
		</header> 

		<main>
			<div class="container-fluid">
				<div class="row">
					<div class="col-md-12">
						<?php 
						require('menu.inc.php');
						?>
					</div>
				</div>

				<div class="row">
					<div class="col-md-offset-2 col-md-8">

						<?php 
						if(isset($errors)){

							foreach ($errors as $error) {

								echo '<div class="alert alert-danger" role=alert>'.$error.'</div>';
							}
						}

						if(isset($success)){


							echo '<div class="alert alert-info" role=alert>'.$success.'</div>';
						}
						?>

						<form class="form-horizontal" action="" method="POST">
							<fieldset>

								<!-- Form Name -->
								<legend>Ajouter / Modifier une fiche restaurant</legend>

								<div class="form-group">
									<label for="name" class="control-label">Nom du restaurant</label>
									<input type="text" name="name" id="name" class="form-control" placeholder="Le bar des amis" value="<?php echo $strLibelle; ?>">
								</div>
								<div class="form-group">
									<label for="adress" class="control-label">Adresse</label>
									<input type="text" name="adress" id="adress" class="form-control" placeholder="adresse" maxlength=150 value="<?php echo $strAdresse; ?>">
								</div>
								<div class="form-group">
									<label for="cp" class="control-label">Code Postal</label>
									<input type="text" name="cp" id="cp" class="form-control" placeholder="69001" maxlength=5 value="<?php echo $strCP; ?>">
								</div>
								<div class="form-group">
									<label for="city" class="control-label">Ville</label>
									<input type="text" name="city" id="city" class="form-control" placeholder="la ville" maxlength=50 value="<?php echo $strVille; ?>">
								</div>
								<div class="form-group">
									<label for="telephone" class="control-label">Téléphone</label>
									<input type="text" name="telephone" id="telephone" class="form-control" placeholder="1234567890" maxlength=10  value="<?php echo $strTelephone; ?>">
								</div>
								<div class="form-group">
									<label for="email" class="control-label">Email</label>
									<input type="text" name="email" id="email" class="form-control" placeholder="1234567890" maxlength=10 value="<?php echo $strMail; ?>">
								</div>

								<input type="submit" id="btnEnvoyer" name="btnEnvoyer" class="btn btn-primary" value="Valider">&nbsp;&nbsp;
								<input type="button" value="retour" class="btn btn-secondary" onclick="window.location='index.php';">
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
		<script src="../scripts/jquery.dataTables.min.js"></script>

		<script>
			$(document).ready(function(){
				$('#tblResultats').DataTable( {
					'language': {
						'url': '../scripts/French.json'
					}
				});
			});


/*		function ajouter(){
			document.FrmMain.ID.value=0;
			document.FrmMain.action='gest-cgu.php';
			document.FrmMain.submit();

		}
		*/

	</script>

</body>
</html>
