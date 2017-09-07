					<nav class="navbar navbar-default" role="navigation">
						<div class="navbar-header">

							<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
								<span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
							</button> <a class="navbar-brand" href="../index.php">Retour au site</a>
						</div>

						<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
							<ul class="nav navbar-nav">
								<li>
									<a href="index.php">Liste restaurants</a>
								</li>
								<li>
									<a href="liste-users.php">Liste utilisateurs</a>
								</li>


							</ul>


							<?php
							if (isset($_SESSION['USER']['pseudo']))
							{
								?>
								<div class="navbar-right">
									<ul class="nav navbar-nav">
										<li>
											<a href="../users.php" title="voir mon profil" alt="voir mon profil"><img src="../images/utilisateur.jpg" width=16 height=16><?php echo $_SESSION['USER']['pseudo']; ?></a>
										</li>
										<li>
											<a href="../deconnexion.php" title="déconnexion" alt="déconnexion"><img src="../images/deconnecter.gif" width=16 height=16></a>
										</li>
									</ul>
								</div>
								<?php 
							}
							?>
						</div>
					</nav>



