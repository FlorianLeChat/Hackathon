<?php
	// Point d'entrée de l'environnement des scripts.
	require_once(__DIR__ . "/../controllers/_main.php");

	// On vérifie si l'utilisateur est connecté.
	if (!$user_login->isConnected())
	{
		http_response_code(401);
		header("Location: index.php?target=login");
		exit();
	}
?>