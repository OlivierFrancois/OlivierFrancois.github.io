<!DOCTYPE html>

<html>
	<head>
		<meta charset="utf8" />
		<lang="fr" />
		<title>Informations de l'environnement PhP</title>
		<link rel="stylesheet"  href="../CSS/requetes_exemple.css" type="text/css" media="all" />
		<link rel="shortcut icon" type="image/x-icon" href="../Contenu/Images/champignonmario.png" />
		<script type="text/javascript" src="../JS/Formulaire_Complet.js"> </script>
	</head>

	<body>
		<header><img SRC="../Contenu/Images/ludus.png" alt="Logo ludus/" height="30%" width="30%"></header>
		
		<main id="main">
			<h1>Execution de requêtes et récupération de données</h1>
			<h2>Filtrage des données</h2>
			<form ID="MyForm01" method="POST" action=#>
				<fieldset>
					<legend>Test</legend>
						
					<?php 
						require("connect.php");
						$myConn = connection();
						$functionCount = 0; //Variable globale utilisée pour compter le nb de passage dans la fonction

						function CreateSelectFromRequest($myConn, $myQuery)
						//BUT : Créer un select contenant chaque ligne renvoyée par la requête dans une option.
						//$myConn : Connexion à la BDD
						//$myQuery : requête devant contenir deux colonnes ayant pour alias respectifs row1 et row2
						{
							$GLOBALS["functionCount"]++;

							//Préparation et exécution de la requête
							$stmt = $myConn->prepare($myQuery);
							$stmt->execute();
							
							echo "<label for=\"select" . $GLOBALS["functionCount"] . "\">". "Filtre "  . $GLOBALS["functionCount"] .  " : </label>";
							echo "<select name=\"select" . $GLOBALS["functionCount"] . "\">"; //Création du select avec un ID
							echo "<option value=\"none\"></option>";
							foreach ($stmt as $row)
								echo "<option value=".$row["row1"].">".$row["row2"]."</option>";
							echo "</select><br />";
						}

						//Affichage des noms clients
						$myQuery = "SELECT NumClient AS row1, Nom AS row2 FROM client";
						CreateSelectFromRequest($myConn, $myQuery);

						//Affichage des localites
						$myQuery = "SELECT Localite AS row1, Localite AS row2 FROM client GROUP BY Localite";
						CreateSelectFromRequest($myConn, $myQuery);

						//Affichage des dates
						$myQuery = "SELECT DateCommande AS row1, DateCommande AS row2 FROM commande GROUP BY DateCommande";
						CreateSelectFromRequest($myConn, $myQuery);

						//Affichage des produits
						$myQuery = "SELECT NumProduit AS row1, Designation AS row2 FROM produit";
						CreateSelectFromRequest($myConn, $myQuery);
					?>

					<div>
						<input class="formButtons" type="reset" name="reset" value="Reset" />
						<input class="formButtons" type="button" name="reloadBtn" value="Reload" onClick="ReloadForm()" />
						<input class="formButtons" type="button" name="submitBtn" value="Valider" onClick="CheckForm()" />
					</div>
				</fieldset>
			</form>
			

			<?php
				/* Requete complete
				SELECT NumBonCommande, NumClient, DateCommande
				FROM commande
				WHERE NumBonCommande = NumBonCommande
				AND NumClient IN
					(SELECT NumClient FROM client WHERE NumClient = "SELECT" )
				AND NumClient IN
					(SELECT NumClient FROM client WHERE Localite = "SELECT" )
				AND DateCommande = STR_TO_DATE( "SELECT" , \"%Y-%m-%d\)
				AND NumBonCommande IN
					(SELECT NumBonCommande FROM detail WHERE NumProduit = "SELECT") */

				//Affichage si le formulaire a été soumis.
				if (!empty($_POST))
				{
					echo "<h2>Affichage des données</h2>";

					$myQuery = "SELECT NumBonCommande, NumClient, DateCommande FROM commande WHERE NumBonCommande = NumBonCommande";
										
					if ($_POST["select1"] != "none") //Filtre par client
						$myQuery = $myQuery." AND NumClient IN (SELECT NumClient FROM client WHERE NumClient =\"" . $_POST["select1"] . "\")";
					
					if ($_POST["select2"] != "none") //Filtre par localite
						$myQuery = $myQuery." AND NumClient IN (SELECT NumClient FROM client WHERE Localite =\"" . $_POST["select2"] . "\")";
					
					if ($_POST["select3"] != "none") //Filtre par date
						$myQuery = $myQuery." AND DateCommande = STR_TO_DATE(\"" . $_POST["select3"] . "\", \"%Y-%m-%d\")";
					
					if ($_POST["select4"] != "none") //Filtre par produit
						$myQuery = $myQuery." AND NumBonCommande IN (SELECT NumBonCommande FROM detail WHERE NumProduit =\"" . $_POST["select4"] . "\")";

					$stmt = $GLOBALS['myConn']->prepare($myQuery);
					$stmt->execute();

					//Si la recherche renvoie des données on les affiches, sinon message à l'utilisateur.
					if ($stmt->rowCount() > 0)
					{
						echo "<table>";
						echo "<thead><tr> <th>NumBonCommande</th> <th>NumClient</th> <th>DateCommande</th> </tr></thead>";
						echo "<tbody>";
						
						foreach ($stmt as $row)
						{	
							echo "<tr>";
							echo "<td>" . $row["NumBonCommande"] . "</td>";
							echo "<td>" . $row["NumClient"] . "</td>";
							echo "<td>" . $row["DateCommande"] . "</td>";
						}
						echo "</tbody> </table> <br />";
					}
					else
						echo "<div ID=\"LastRequest\">Aucune donnée correspondant à votre recherche n’a été trouvée</div><br />";

					//Affichage de la requête SQL effectuée pour vérification.
					echo "<div ID=\"LastRequest\"><legend>Requête effectuée :</legend> <br />" . $myQuery . "</div>";
				}
			?> 
		</main>

		<script>

		</script>
		<footer><a href="mailto:o.francois@ludus-academie.com" > Me contacter par mail </a></footer>
	</body>

</html>