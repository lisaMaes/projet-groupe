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


require('../include/connexion.inc.php');

//verifie la validité du formulaire et des validité des champs
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


	if (isset($_POST['telephone'])  && !empty($_POST['telephone']))
	{
		$strTelephone=$_POST['telephone'];
		if (!preg_match('#^[0-9]{10}$#i',$strTelephone)){
			$tErreurs[]="Merci de saisir un Téléphonne correct (10 chiffres ex. 0412345678";
		}
	}
	else
	{
		$tErreurs[]="Veuillez saisir un téléphone";
	}


//verifie que le fichier est été envoyé
if(isset($_FILES['monFichier']) && (isset($_POST))){

    
//verifie chaque cas d'erreur
  switch ($_FILES['monFichier']['error']) {

    case 1:
      $tErreurs[]='La taille de fichier est supérieur à celle acceptée';
      break;

    case 2:
      $tErreurs[]='La taille de fichier est supérieur à celle acceptée';
      break;

    case 3:
      $tErreurs[]='Le téléchargement est incomplet. Veuillez réessayer';
      break;

    case 4:
      $tErreurs[]='Veuillez selectionner un fichier';
      break; 

    case 6:
      $tErreurs[]='Erreur serveur code 90001 : Le téléchargement n\'a pus ce faire. Veuillez réessayer plus tard';
      break;
      //90001 doit etre inscrit chez nous afin de pouvoir identifier l'erreur facilement 

    case 7:
      $tErreurs[]='Le téléchargement n\'a pu ce faire. Veuillez réessayer plus tard';
      break;

    case 8:
      $tErreurs[]='Le téléchargement était interrompu';
      break;

    case !0://comme on a sauté des erreurs il faut verifier qu'il n'y en ai pas d'autres
        $tErreurs[]= 'Erreur inconnue.';

    default://si aucune erreur a été envoyer
      

        $extension = finfo_file(finfo_open(FILEINFO_MIME_TYPE), $_FILES['monFichier']['tmp_name']);
        
        if(($_FILES['monFichier']['size'])<=512000){

             
                if($extension=='image/jpeg' || $extension=='image/png'|| $extension=='image/bmp' || $extension=='image/gif'){

                       
    //recupération, deplacement et chgt du nom du fichier
                    if(!isset($tErreurs)){

                       require('../include/fileNameGenerator.php');
                        $newFileName = createFileName(10);

                        if($extension == 'image/jpeg'){
                            $newFileExt = '.jpg';
            
                        }elseif ($extension == 'image.png') {
                            $newFileExt = '.png';
                        }

                        $finalFileName = $newFileName .$newFileExt;
                    }

                    move_uploaded_file($_FILES['monFichier']['tmp_name'], '../img_restau/'.$finalFileName);



                      }else{

                $tErreurs[] = 'Le format d\'image n\'est pas valide';

                          }
        }else{

            $tErreurs[] = 'Veuillez choisir un fichier inférieur à 500Ko !';
        }

      break;
  }

	
}

//si il  n'y a pas d'erreurs
	if (!isset($tErreurs)){

//soit INSERT d'un nouvel élément si Id vide
		if 	($strId==0){
			$requete=$bdd->prepare('INSERT INTO restaurants (name,adress,city,zipcode,telephone,image) VALUES(:nom,:adresse,:ville,:cp,:tel,:image)');
			$requete->bindValue(':nom',$strLibelle);
			$requete->bindValue(':adresse',$strAdresse);
			$requete->bindValue(':ville',$strVille);
			$requete->bindValue(':cp',$strCP);
			$requete->bindValue(':tel',$strTelephone);
			$requete->bindValue(':image',$finalFileName);
			$requete->execute();

			if ($requete->rowCount()>0)
			{
				$success[]="Le restaurant vient d'être ajouté";
				$strId = $bdd -> lastInsertId();
				$requete->closeCursor();
			}else
			{
				$tErreurs[]="erreur à l'enregistrement, contactez l'admin";
				$requete->closeCursor();
			}

		}
		//soit mise à jour de la fiche existante
		else
		{
			$requete=$bdd->prepare('UPDATE restaurants SET name=:nom,adress=:adresse,city=:ville,zipcode=:cp,telephone=:tel,image=:image WHERE ID=:id');
			$requete->bindValue(':id',$strId);
			$requete->bindValue(':nom',$strLibelle);
			$requete->bindValue(':adresse',$strAdresse);
			$requete->bindValue(':ville',$strVille);
			$requete->bindValue(':cp',$strCP);
			$requete->bindValue(':tel',$strTelephone);
			$requete->bindValue(':image',$finalFileName);
			$requete->execute();

			if ($requete->rowCount()>0)
			{
				$success[]="Le restaurant a été modifié";
				$requete->closeCursor();
			}
			else
			{
				$tErreurs[]="erreur à la modification, contactez l'admin";

				$requete->closeCursor();
			}

			
		}
	}
}









// Permet d'afficher les infos de la fiche restau si ID existe

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
	$image=$resultat['image'];

	$requete->closeCursor();
}
else
{
	$strLibelle="";
	$strAdresse="";
	$strCP="";
	$strVille="";
	$strTelephone="";
	$image="";

	$requete->closeCursor();
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

					<?php //Gestion des message d'erreur et de succès
					if(isset($tErreurs)){

						foreach ($tErreurs as $error) {

							echo '<div class="alert alert-danger" role=alert>'.$error.'</div>';
						}
					}

					if(isset($success)){

						foreach ($success as $value) {
						echo '<div class="alert alert-info" role=alert>'.$value.'</div>';
						}
					}

					?>
<!-- Formulaire de modification et création -->
					<form class="form-horizontal" action="" method="POST" enctype="multipart/form-data">
						<input type="hidden" name="ID" value="<?php echo $strId; ?>">
						<fieldset>

							<!-- Form Name -->
							<legend>Ajouter / Modifier une fiche restaurant</legend>

							<div class="form-group">
								<label for="name" class="control-label">Nom du restaurant</label>
								<input type="text" name="name" id="name" class="form-control" placeholder="Le bar des amis" value="<?php echo htmlspecialchars($strLibelle); ?>">
							</div>
							<div class="form-group">
								<label for="adress" class="control-label">Adresse</label>
								<input type="text" name="adress" id="adress" class="form-control" placeholder="adresse" maxlength=150 value="<?php echo htmlspecialchars($strAdresse); ?>">
							</div>
							<div class="form-group">
								<label for="cp" class="control-label">Code Postal</label>
								<input type="text" name="cp" id="cp" class="form-control" placeholder="69001" maxlength=5 value="<?php echo htmlspecialchars($strCP); ?>">
							</div>
							<div class="form-group">
								<label for="city" class="control-label">Ville</label>
								<input type="text" name="city" id="city" class="form-control" placeholder="la ville" maxlength=50 value="<?php echo htmlspecialchars($strVille); ?>">
							</div>
							<div class="form-group">
								<label for="telephone" class="control-label">Téléphone</label>
								<input type="text" name="telephone" id="telephone" class="form-control" placeholder="1234567890" maxlength=10  value="<?php echo htmlspecialchars($strTelephone); ?>">
							</div>
							<div class="form-group">
								<input type="hidden" name="MAX_FILE_SIZE" value="10000000">
        						<input type="file" name="monFichier">

							</div>
							<div>
								
								<?php if(!empty($image)){

										echo '<img src="../img_restau/'.htmlspecialchars($image).'"><br><br>';

									} 
									?>

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
