<?php
	//
	// Contrôleur de gestion des données utilisateurs.
	//
	namespace Notes\Controllers;

	require_once(__DIR__ . "/../models/user.php");

	use Notes\Models\User;

	// Classe permettant de créer un utilisateur.
	final class UserCreation extends User
	{
		//
		// Permet de créer une nouvelle inscription.
		//
		public function storeNewUser(string $email, string $password): void
		{
			$query = $this->connector->prepare("INSERT IGNORE INTO `users` (`email`, `password`) VALUES (?, ?);");
			$query->execute([$email, $password]);

			$this->setEmail($email);
			$this->setPassword($password);
		}

		//
		// Permet de recevoir les demandes de création d'un nouveau mot de passe.
		//
		public function requestNewPassword(string $email): void
		{
			// On vérifie si la demande se réalise sur le serveur principal ou sur
			//	le serveur de développement (WAMP).
			if (str_contains($_SERVER["SERVER_NAME"], "florian-dev.fr"))
			{
				$to = $email;
				$subject = "Demande de récupération d'un nouveau mot de passe";
				$message = "Voici le lien de récupération : https://www.florian-dev.fr/hackathon/?target=login&new_password=$email";
				$headers = array(
					"From" => "Hackathon <admin@florian-dev.fr>",
					"X-Mailer" => "PHP/" . phpversion()
				);

				mb_send_mail($to, $subject, $message, $headers);
			}
		}
	}

	// Classe permettant d'authentifier un utilisateur.
	final class UserAuthentication extends User
	{
		// Temps d'expiration du jeton d'authentification (en secondes).
		public const EXPIRATION_TIME = 60 * 60 * 24 * 31;

		//
		// Permet de comparer et de valider un jeton d'authentification
		//	envoyé par un utilisateur connecté précédemment.
		//
		public function compareToken(string $token): bool
		{
			// On exécute une requête SQL pour récupérer le jeton
			//	d'authentification enregistré dans la base de données.
			$query = $this->connector->prepare("SELECT `email`, `password`, `creation_time` FROM `users` WHERE `access_token` = ?;");
			$query->execute([$token]);

			$result = $query->fetch();

			// On vérifie alors le résultat de la requête.
			if (is_array($result) && count($result) > 0 && strtotime($result["creation_time"]) + $this::EXPIRATION_TIME > time())
			{
				// Si elle est valide, on assigne certaines variables
				//	à l'utilisateur.
				$this->setEmail($result["email"]);
				$this->setPassword($result["password"]);
				$this->setToken($token);

				return true;
			}

			// Dans le cas contraire, on signale que le jeton est invalide.
			return false;
		}

		//
		// Permet d'enregistrer le jeton d'authentification de l'utilisateur
		//	dans la base de données.
		//
		public function storeToken(string $token): void
		{
			$query = $this->connector->prepare("UPDATE `users` SET `access_token` = ? WHERE `email` = ?;");
			$query->execute([$token, $this->getEmail()]);
		}

		//
		// Permet d'authentifier un utilisateur au niveau de la
		//	base de données.
		//
		public function authenticate(string $email, string $password): bool
		{
			// On effectue une requête SQL pour vérifier
			//	si un enregistrement est présent avec les identifiants
			//	donnés lors de l'étape précédente.
			$query = $this->connector->prepare("SELECT `password` FROM `users` WHERE `email` = ?;");
			$query->execute([$email]);

			$result = $query->fetch();

			// On vérifie le résultat de la requête SQL avant
			//	de comparer le mot de passe hashé par l'entrée utilisateur.
			if (is_array($result) && count($result) > 0 && password_verify($password, $result["password"]))
			{
				// L'authentification a réussie.
				$this->setEmail($email);
				$this->setPassword($result["password"]);

				return true;
			}

			// L'authentification a échouée.
			return false;
		}

		//
		// Permet de déconnecter l'utilisateur de l'interface.
		//
		public function destroy(): void
		{
			// On supprime le jeton d'authentification de l'utilisateur
			//	aussi bien côté client que dans la base de données.
			$this->storeToken("");

			setcookie("generated_token", "", 1, "/", $_SERVER["HTTP_HOST"]);

			// On supprime toutes les informations utilisateurs sauvegardées
			// 	dans les sessions.
			unset($_SESSION["email"]);
		}
	}
?>