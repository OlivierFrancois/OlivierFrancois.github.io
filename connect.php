<?php
	//PDO : PhP Data Objects
	define('SERVERNAME', "localhost");
	define('USERNAME', "root");
	define('PASSWORD', "");
	define('DBNAME', "commerce_cours");

	function connection()
	{

		//En prog objet, quand on fait une instruction qui peut générer une erreur, on encapsule l'instruction dans
		//un bloc try/catch afin de récupérer l'erreur et de la gérer
		try
		{
			//mysql est important pour préciser le type de driver dont on se sert.
			// pour oracle: $dsn="oci:dbname=//serveur:1521/base
			// pour sqlite: $dsn="sqlite:/tmp/base.sqlite"
			$conn = new PDO("mysql:host=".SERVERNAME."; dbname=".DBNAME, USERNAME, PASSWORD);
			
			//mode d'erreur du PDO réglé sur EXCEPTION.
			//Il existe d'autre mode d'erreur :
			// ERRMODE_SILENT :
			// PDO::ERRMODE_WARNING :
			// PDO::ERRMODE_EXCEPTION :
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			
			//echo "Connected successfully <br />";
		}
		catch(PDOException $e)
		//le catch n'attrape que ce qui est spécifié. Ici, on attrape $e qui est une variable provenant de la classe PDOException.
		{
			echo "Connection failed: " . $e->getMessage();
			// $e est une instance de la classe PDOException. On a donc accès aux méthodes de cette classe, dont getMessage.
		}

		return $conn;
	}
?>