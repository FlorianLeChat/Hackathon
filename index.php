<!DOCTYPE html>

<?php
	// Point d'entrée de l'environnement des scripts.
	require_once("includes/controllers/_main.php");

	// En-tête de la page.
	$head_html = $twig->render("_head.twig",
	[
		"url" => $_SERVER["SERVER_NAME"],
		"file" => $file,
		"language" => "FR",
		"keywords" => "presidents, macron, biden, notes, application, badass",
		"description" => "Une application de prises de notes présidentielles."
	]);

	// Page entière.
	require_once("includes/views/$file.php");

	$html = $twig->render("$file.twig",
	[
		"head_html" => $head_html
	]);

	echo($html);
?>