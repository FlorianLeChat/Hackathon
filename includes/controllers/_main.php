<?php
	//
	// Contrôleur principal de la création et de la gestion
	//	de l'environnement d'exécution des scripts PHP.
	//

	// On affiche les erreurs liées au PHP.
	ini_set("display_errors", 1);
	ini_set("display_startup_errors", 1);

	error_reporting(E_ALL);

	// Fonctions de compatibilité pour PHP 7 et versions inférieures.
	// Ces fonctions sont nativement présentes sur PHP 8.
	if (!function_exists("str_contains"))
	{
		// Permet de vérifier si une sous-chaîne est présente dans
		//	une chaîne de caractères spécifiée.
		// 	Source : https://www.php.net/manual/fr/function.str-contains.php#125977
		function str_contains(string $source, string $search): bool
		{
			return mb_strpos($source, $search) !== false;
		}
	}

	if (!function_exists("str_starts_with"))
	{
		// Permet de vérifier si une sous-chaîne est présente
		//	au début d'une chaîne de caractères spécifiée.
		//	Source : https://www.php.net/manual/fr/function.str-starts-with.php#125913
		function str_starts_with(string $source, string $search): bool
		{
			return strncmp($source, $search, mb_strlen($search)) === 0;
		}
	}

	// On demande le chargement du moteur TWIG.
	require_once(__DIR__ . "/../../vendor/autoload.php");

	$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . "/../../templates");
	$twig = new \Twig\Environment($loader, ["debug" => true, "autoescape" => false]);

	// On réalise la création de certaines variables cruciales.
	require_once("database.php");
	require_once("user.php");

	session_start();

	$connector = new Notes\Controllers\Connector();				// Connexion à la base de données.
	$connector = $connector->getPDO();

	$user_login = new Notes\Controllers\UserAuthentication();	// Mécanisme d'authentification.
	$user_login->connector = $connector;

	$user_register = new Notes\Controllers\UserCreation();		// Mécanisme d'inscription.
	$user_register->connector = $connector;

	// On récupère enfin la page demandée.
	$file = htmlentities($_GET["target"] ?? "", ENT_QUOTES);

	if (empty($file))
	{
		// Si la variable est vide ou invalide, on cible la page par défaut.
		$file = "index";
	}
?>