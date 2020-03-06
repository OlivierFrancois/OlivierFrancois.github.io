<!DOCTYPE html>

<html>
	<head>
		<meta charset="utf8" />
		<lang="fr" />
		<title>Informations de l'environnement PhP</title>
		<link rel="stylesheet"  href="../CSS/connexion_bdd.css" type="text/css" media="all" />
		<link rel="shortcut icon" type="image/x-icon" href="../Contenu/Images/champignonmario.png" />
		<script type="text/javascript" src="../JS/Formulaire_Complet.js"> </script>
	</head>

	<body>
		<header><img SRC="../Contenu/Images/ludus.png" alt="Logo ludus/" height="30%" width="30%"></header>
		
		<main id="main">
			<form method=POST action=#>
				<fieldset>
					<legend>Selectionnez la page de destination</legend>
					<select name="SelectPage">
						<option value="connexion_BDD.php">Établir une connexion avec une BDD et effectuer une requête</option>
						<option value="requetes_exemple.php">Requêtes sur une BDD et affichage</option>
					</select>
					
					<br /><br />
					
					<div><input type="submit" name="submit" value ="Go !"></div>
				</fieldset>
			</form>


			<?php
				if (!empty($_POST))
				{
					header("Location:".$_POST[SelectPage]);
				}
			?>
		</main>

		<footer><a href="mailto:o.francois@ludus-academie.com" > Me contacter par mail </a></footer>
	</body>

</html>