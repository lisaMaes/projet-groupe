<nav class="navbar navbar-default" role="navigation">
	<div class="navbar-header">

		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
			<span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
		</button> <a class="navbar-brand" href="index.php">Accueil</a>
	</div>

	<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		<ul class="nav navbar-nav">

			<?php 
			//affiche si la session n'existe pas les page de connexion/inscription
			if (!isset($_SESSION['pseudo']))
			{
				?>
				<li>
					<a href="formconnexion.php">Connexion</a>
				</li>
				<li>
					<a href="inscription.php">Inscription</a>
				</li>
				<?php
			}

			?>


			<?php
			// affiche l'accès à l'admin si l'utilisateur est de type admin
			if (isset($_SESSION['type']) && $_SESSION['type']==1)
			{
				?>		
				<li>
					<a href="backoffice/index.php">Admin</a>
				</li>
				<?php
			}

			?>			
		</ul>


		<div class="navbar-right">
			<ul class="nav navbar-nav">
				<li>
					<a href="#">pseudo</a>
				</li>
			</ul>
		</div>
	</div>

</nav>



