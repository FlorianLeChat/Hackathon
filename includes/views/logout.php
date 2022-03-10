<?php
	// Point d'entrée de l'environnement des scripts.
	require_once(__DIR__ . "/../controllers/_main.php");

	// On procède à la déconnexion de l'utilisateur.
	$user_login->destroy();
?>