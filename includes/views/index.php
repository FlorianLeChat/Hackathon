<?php
	// On vérifie si l'utilisateur est connecté.
	if (!$user_login->isConnected())
	{
		http_response_code(401);
		header("Location: index.php?target=login");
		exit();
	}
?>