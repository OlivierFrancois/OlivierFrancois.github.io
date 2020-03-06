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
			<?php
				if (!empty($_POST))
				{
					header("Location:".$_POST[SelectPage]);
				}
			?>

			<h1>Se connecter à une BDD et effectuer des requêtes</h1>

			<?php
				require("connect.php");
				$myConn = connection();

				echo "<br />";
				if (isset($myConn))
					echo "objet existant";


				echo "<h2>Récupération des données de la table client</h2>";
				//EFECTUER UNE REQUETE
				//Appliquer la querry à l'objet conn.
				//Cela se fait de la façon suivante :
				//$myConn->query("REQUETE")
				//La requête est une chaine de caractère;
				//Elle renvoie un ensemble d'élément qui peut être parcouru avec un for each
				//Mise en place de toute ça :

				$myQuery = "SELECT * FROM client";
				$myConn->query($myQuery);

				//var_dump($myConn->query($myQuery));

				echo "<table>";
				echo "<thead><tr><th>Num Client</th> <th>Nom</th> <th>Adresse</th> <th>LOCALITE</th> <th>CategorieClient</th> <th>Solde</th></tr></thead>";
				echo "<tbody>";
				foreach ($myConn->query($myQuery) as $row)
				{
					echo "<tr>";

					echo "<td>".$row["NumClient"]."</td>";
					echo "<td>".$row["Nom"]."</td>";
					echo "<td>".$row["Adresse"]."</td>";
					echo "<td>".$row["LOCALITE"]."</td>";
					echo "<td>".$row["CategorieClient"]."</td>";
					echo "<td>".$row["Solde"]."</td>";

					echo "</tr>";
				}
				echo "</tbody>";
				echo "</table>";


				//_____________________________________________________________________//
				echo "<h2>Génération d'une erreur</h2>";
				echo "<p>Cela illustre qu'il est nécessaire de vérifier si la query a réussie avant d'afficher quoi que ce soit (à décommenter dans le code) :</p>";
				/*$myQuery = "SELECT * FROM client_";
				$myConn->query($myQuery);

				echo "<table>";
				echo "<thead><tr><th>Num Client</th> <th>Nom</th> <th>Adresse</th> <th>LOCALITE</th> <th>CategorieClient</th> <th>Solde</th></tr></thead>";
				echo "<tbody>";
				foreach ($myConn->query($myQuery) as $row)
				{
					echo "<tr>";

					echo "<td>".$row["NumClient"]."</td>";
					echo "<td>".$row["Nom"]."</td>";
					echo "<td>".$row["Adresse"]."</td>";
					echo "<td>".$row["LOCALITE"]."</td>";
					echo "<td>".$row["CategorieClient"]."</td>";
					echo "<td>".$row["Solde"]."</td>";

					echo "</tr>";
				}
				echo "</tbody>";
				echo "</table>";*/

				echo "<h2>Contrôle d'erreur</h2>";
				echo "<p>Pour être sûr qu'une table existe avant de tenter un affichage de cette dernière, il faut utiliser un try-catch. <br />En effet, l'instruction \$myConn->query($myQuery) s'éxécutant (et résultant une erreur qui fait crasher la page), il est impossible de tenter des choses de types \"isset...\". <br />On utilise donc le try-catch pour d'abord éxécuter l'instruction, puis en récupérer l'erreur si elle est générée. Par la suite, on peut utiliser un isset sur une variable contenant l'erreur (si elle a été catch, et par conséquent initialisée).</p>";
				$myQuery = "SELECT * FROM client";

				//var_dump($myConn->query($myQuery));

				//echo $stmt->rowcount();
			
				//Affichage des informations de la table

				try
				{
					$myConn->query($myQuery);
				}
				catch (PDOException $e)
				{
					echo "Request failed : " . $e->getMessage();
				}

				if (!isset($e))
				{
					echo "<table>";
					echo "<thead><tr><th>Num Client</th> <th>Nom</th> <th>Adresse</th> <th>LOCALITE</th> <th>CategorieClient</th> <th>Solde</th></tr></thead>";
					echo "<tbody>";
					foreach ($myConn->query($myQuery) as $row)
					{
						echo "<tr>";

						echo "<td>".$row["NumClient"]."</td>";
						echo "<td>".$row["Nom"]."</td>";
						echo "<td>".$row["Adresse"]."</td>";
						echo "<td>".$row["LOCALITE"]."</td>";
						echo "<td>".$row["CategorieClient"]."</td>";
						echo "<td>".$row["Solde"]."</td>";

						echo "</tr>";
					}
					echo "</tbody>";
					echo "</table>";
				}


				//_____________________________________________________________________//
				echo "<h2>Requêtes préparées</h2>";
				echo "<p></p>";

				$myQuery = "SELECT NumProduit, Designation FROM produit";
				try
				{
					$stmt = $myConn->prepare($myQuery);
					$stmt->execute();	
				}
				catch (PDOException $e)
				{
					echo "Request failed : " . $e->getMessage();
				}
				
				if (!isset($e))
				{
					echo ("<h3>Liste des produits (num et désignation)</h3>");
					echo ("<form ID=\"MyForm01\">");
					echo("<select>");
					foreach ($stmt as $row)
						echo ("<option value =".$row["NumProduit"].">".$row["NumProduit"]." ".$row["Designation"]."</option>");
					echo("</select>");
					echo ("</form>");
				}
			?> 
		</main>

		<script>

		</script>
		<footer><a href="mailto:o.francois@ludus-academie.com" > Me contacter par mail </a></footer>
	</body>

</html>