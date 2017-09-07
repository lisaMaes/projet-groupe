<?php
session_start();

include('include/connexion.inc.php');


$response = $bdd->query('SELECT * FROM restaurants ORDER BY name');
$data = $response->fetchAll(PDO::FETCH_ASSOC);
$response->closeCursor();


$response1 = $bdd->query('SELECT * FROM restaurants ORDER BY RAND() LIMIT 6');
$data1 = $response1->fetchAll(PDO::FETCH_ASSOC);
$response1->closeCursor();


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
			Eat-eee !! -Inscriptions
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
				<div class="col-md-8">
					
					<?php 
					if(!empty($data1))

						foreach ($data1 as $value) {
							
							echo'<div class="col-md-2 restaurant">'.htmlspecialchars($value['name']).'</div>';

						}

						?>
						

					</div>

					<div class="col-md-2">
						<?php  
						if (!empty($data)) {

							echo '<ul>'; 

							foreach ($data as $value) {

								echo "<li>".htmlspecialchars($value['name']) ."</li>";
							}

							echo'</ul>';

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
