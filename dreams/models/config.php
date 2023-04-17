<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

	function getConnexion(){


		// Etape 1 : la connexion
		$server = 'localhost';
		$port = '3306';
		$dbname = 'inmydreams';
		$username = 'root';
		$password = 'root';

		// Construction de la chaîne de connexion : Data Source Name
		$dsn = "mysql:host=$server;port=$port;dbname=$dbname;charset=utf8";
		

		try{
			$conn = new PDO($dsn, $username, $password);
			return $conn;
		}catch(PDOException $ex){
			print('Pas possible de se connecter !!!');
			die();
		}



	}


?>