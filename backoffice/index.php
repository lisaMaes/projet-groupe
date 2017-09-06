<?php



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

					<div id="cmdUI">
						<input type="button" value="Nouveau" onclick="ajouter();" class='btn btn-success'>

					</div>
					<br>

					<?php 
					include('../connexion.inc.php');

					$requete=$bdd->query('SELECT ID,name,city,zipcode FROM restaurants ORDER BY name');
					$iTotal=$requete->rowCount();

					if ($iTotal==0)
					{

						echo '<br><div class="alert alert-warning">Pas de données en base</div>';
					}
					else
					{
						?>
						
						Liste des restaurants en base :
						<br><br>


						<table id="tblResultats" class="table table-striped table-hover table-condensed table-responsive">
							<thead>
								<tr>
									<th>
										Nom (id)
									</th>
									<th width="250">
										Ville (code postal)
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

									echo "\n<td>";
									echo $resultat['name'] . ' (' . $resultat['ID'] . ')';
									echo "</td>";

									echo "\n<td width='250'>";
									echo $resultat['city'] . ' (' . $resultat['zipcode'] . ')';				            	
									echo "</td>";

									echo "\n<td width='180'>";
									echo "<input type='button' value='Modifier' class='btn btn-info' onclick='modifier(". $resultat['ID'] . ");'>&nbsp;&nbsp;";
									echo "<input type='button' value='Supprimer' class='btn btn-danger' onclick='supprimer(". $resultat['ID'] . ");'>";
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
						<input type="hidden" name="COMMANDE">
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


		function ajouter(){
			document.FrmMain.ID.value=0;
			document.FrmMain.action='gest-produits.php';
			document.FrmMain.submit();

		}
		
		function modifier(ID){
			document.FrmMain.ID.value=ID;
			document.FrmMain.action='gest-produits.php';
			document.FrmMain.submit();

		}



	</script>

</body>
</html>
