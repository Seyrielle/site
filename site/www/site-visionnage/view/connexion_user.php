<head>

</head> 
	

	<div id="connexion_inscription" style="font-size:15px" >
			<?php
			session_start();
			if (isset($_SESSION['login']))
			{
				?> <script>recommandation(); </script> <?php
				echo '<a href="PHP/deconnexion.php">Deconnexion</a>';
			}
			else 
			{
			?>
				Connexion:<br>
				Pseudo : <input size=5px style="height: 19px; padding:0; margin:0; font-size:12px;" type="text" id="login" name="login">
				Mot de passe : <input size=5px style="height: 19px; padding:0; margin:0; font-size:12px;" id="password" type="password" name="password">
				<button id="submit-connexion" style="height: 25px; padding:2px; margin:2px; font-size:12px;" onclick="envoi('PHP/connexion.php');" >Se connecter</button>
				<a href="HTML/inscription.html">Inscription</a>
		    <?php }; ?>	
	</div>
	