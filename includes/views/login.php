<?php
	// Point d'entrée de l'environnement des scripts.
	require_once(__DIR__ . "/../controllers/_main.php");

	// On tente de connecter l'utilisateur si ce
	//	n'est pas déjà le cas et si la requête actuelle
	//	 est une requête POST.
	$message = "";
	$connected = $user_login->isConnected();

	if (!$connected && $_SERVER["REQUEST_METHOD"] == "POST")
	{
		$type = $_POST["type"] ?? true;

		if ($type)
		{
			$connected = $user_login->authenticate($_POST);

			// Si le script continue ici, alors l'authentification
			//	semble avoir échouée, on affiche un message d'erreur.
			echo("L'authentification a échouée. Veuillez recommencer.");
		}
		else
		{
			$user_register->requestNewPassword($_POST);

			// On signale à l'utilisateur qu'un mail de récupération va
			//	être envoyé pour retrouver un mot de passe.
			echo("Un mail va être envoyé sous peu pour récupérer votre mot de passe.")
		}
	}
	else
	{
		// Dans le cas contraire, on tente de connecter l'utilisateur
		//	s'il possède un jeton d'authentification.
		if (isset($_SERVER["HTTPS"]) && !empty($_COOKIE["generated_token"]))
		{
			$connected = $user_login->compareToken($_COOKIE["generated_token"]);

			// La session de token peut avoir expirée depuis, donc on prépare
			//	un message pour avertir l'utilisateur.
			echo("Votre session de connexion a expirée. Une reconnexion est nécessaire.");
		}
	}

	// On vérifie enfin si l'utilisateur est authentifié.
	// 	Note : l'utilisateur peut être déjà connecté et/ou avoir
	//		été authentifié lors de l'étape précédente.
	if ($connected)
	{
		if (isset($_POST["remember_me"]))
		{
			// L'utilisateur peut demander de se souvenir de sa connexion
			//	lors de sa prochaine venue sur la page.
			$token = bin2hex(random_bytes(32));
			$user_login->storeToken($token);

			setcookie("generated_token", $token, time() + $user_login::EXPIRATION_TIME, "/", $_SERVER["HTTP_HOST"], true);
		}

		http_response_code(302);
		header("Location: index.php");
		exit();
	}
?>