<?php
session_start();

require_once('../include/sessions.inc.php');
CheckUnauthent();
CheckSessionExpire();



if (isset($_POST['ID']) AND !empty($_POST['ID']) )
{

	if (filter_var($_POST['ID'],FILTER_VALIDATE_INT))
	{
		require_once('../include/connexion.inc.php');
		
		$requete=$bdd->prepare('SELECT type FROM users WHERE ID=?');
		$requete->execute(array($_POST['ID']));
		$resultat=$requete->fetch(PDO::FETCH_ASSOC);


		if ($resultat['type']==0)
		{
			$promotion=$bdd->prepare('UPDATE users SET type=1 WHERE ID=?');
		}
		else
		{
			$promotion=$bdd->prepare('UPDATE users SET type=0 WHERE ID=?');			
		}
		$promotion->execute(array($_POST['ID']));	


		if ($promotion->rowCount()==1)
		{
			$success="L'autorisation utilisateur à été modifiée";
		}

		else
		{
			$errors="Erreur lors de la promotion";		
		}
		$promotion->closeCursor();
		$requete->closeCursor();
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
						echo '<div class="alert alert-danger" role=alert>'.$errors.'</div>';
					}

					if(isset($success)){


						echo '<div class="alert alert-info" role=alert>'.$success.'</div>';
					}
					?>
					<br>

					<?php 
					include('../include/connexion.inc.php');

					$requete=$bdd->query('SELECT * FROM users ORDER BY pseudo');
					$iTotal=$requete->rowCount();

					if ($iTotal==0)
					{

						echo '<br><div class="alert alert-warning">Pas de données en base</div>';
					}
					else
					{
						?>
						
						Liste des utilisateurs en base :
						<br><br>


						<table id="tblResultats" class="table table-striped table-hover table-condensed table-responsive">
							<thead>
								<tr>
									<th width="250">
										peusdo (id)
									</th>
									<th>
										mail
									</th>
									<th width="180">
									</th>
								</tr>
							</thead>
							<tbody>


								<?php
								while($resultat=$requete->fetch(PDO::FETCH_ASSOC))
								{


									echo "\n<tr>";

									echo "\n<td width='250'>";
									echo $resultat['pseudo'] . ' (' . $resultat['ID'] . ')';
									echo "</td>";

									echo "\n<td>";
									echo $resultat['email'];				            	
									echo "</td>";

									echo "\n<td width='180'>";
									
									$strTemp="-> admin";
									if ($resultat['type']==1)
									{
										$strTemp="-> user";
									}
									echo "<input type='button' value='" . $strTemp . "' class='btn btn-info' onclick='changeType(". $resultat['ID'] . ");'>&nbsp;&nbsp;";
									echo "</td>";            

									echo "\n</tr>";
								}
								?>

							</tbody>
						</table>

						<?php

					}
					$requete->closeCursor();

					?>

					<form name="FrmMain" action="" method="post">
						<input type="hidden" name="ID">
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


		function changeType(ID){
			document.FrmMain.ID.value=ID;
			document.FrmMain.submit();
		}
		

	</script>

</body>
</html>
