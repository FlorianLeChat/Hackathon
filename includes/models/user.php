<?php
	//
	// Modèle des données représentatives d'un utilisateur.
	//
	namespace Notes\Models;

	abstract class User
	{
		protected string $email = "";
		protected string $password = "";
		protected string $avatar = "";
		protected string $token = "";

		// Adresse électronique.
		public function setEmail(string $email)
		{
			$this->email = $email;

			if (isset($_SESSION))
			{
				// Enregistrement dans la session active.
				$_SESSION["email"] = $this->email;
			}
		}

		public function getEmail(): string
		{
			if (!empty($_SESSION["email"]))
			{
				// Récupération dans la session active.
				$this->email = $_SESSION["email"];
			}

			return $this->email;
		}

		// Mot de passe (hashé) de l'utilisateur.
		public function setPassword(string $password)
		{
			$this->password = $password;
		}

		public function getPassword(): string
		{
			return $this->password;
		}

		// Avatar.
		public function setAvatar(string $avatar)
		{
			$this->avatar = $avatar;
		}

		public function getAvatar(): string
		{
			return $this->avatar;
		}

		// Jeton d'authentification.
		public function setToken(string $token)
		{
			$this->token = $token;
		}

		public function getToken(): string
		{
			return $this->token;
		}

		// État de la connexion.
		public function isConnected(): bool
		{
			return !empty($this->getEmail());
		}
	}
?>