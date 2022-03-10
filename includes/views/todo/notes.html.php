<?php
    include("BDD.php");
    $nootes = $pdo->query("SELECT avatar_url,title,description,state,note_id FROM users JOIN notes ON client_id = creator_id")->fetchall();
?>
 
 <!DOCTYPE html>
  <head>  
   	<!-- meta -->
	  <meta charset="utf-8" />
	  <meta name="keywords" content="notes"/>
	  <meta name="description" content="organisation" />
	  <meta name="author" content="auteur">


	  <!-- include -->
	<!-- {#  <link rel="stylesheet" href="output_css/notes.css" />	 #} -->
     <title> Mes notes </title> 
     <script src="https://kit.fontawesome.com/b2ac465a5f.js" crossorigin="anonymous"></script>
   <!-- {#   // <script src="js/{{script_js}}.js" defer></script> #} -->

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script src="note.js"></script>
	<link rel="stylesheet" href="style.css">
  </head> 


  <header>

	<form method='POST' action='page_check.php'>
			<input type='submit' name='deconnexion' value='Se déconnecter '/>
	</form>

  </header>
  

<body> 




{# Bouton deconnexion #}

 <form method='POST' action='page_check.php'>
			  <input type='submit' name='deconnexion' value='Se déconnecter '/>
 </form>


{# Colonne à faire #}

<section id="todo">

	<?php 

		for($i = 0;$i <count($nootes);$i++){
			echo "<div class='divnote note' data-id='".$nootes[$i]['note_id']."'>\n
			<h2>".$nootes[$i]['title']."</h2>
			<p>".$nootes[$i]['description']."</p>
			<div class='avatar'>\n
			<img src='".$nootes[$i]['avatar_url']."' alt='Avatar du créateur'>\n
			</div>

			{# Les boutons d'actions #}
			<div class='dropdown'>

				{# Appuie sur le ... pour voir toutes les actions #}

			<button onclick='myFunction()' class='dropbtn' > <i class='fa-solid fa-ellipsis'></i></button>
			<div id='myDropdown' class='dropdown-content'>
				<a id='modifer'>Modifier</a>
				<a id='Supprimer'>Supprimer</a>
				<a id='Exporter'>Exporter</a>
				<a id='Partager'>Partager</a>
			</div>
			</div>
			
			<input type='button' value='Supprimer' class='delete'>\n
			<input type='button' value='Modifier' class='modify'>\n
			<input type='button' value='Exporter' class='export'>\n
			<input type='button' value='Partager' class='share'>\n
			<input type='button' value='Terminer' class='end'>\n
			
			</div>";

		}

	?>
	<!-- <div>
		{# Les boutons d'actions #}
		<div class="dropdown">

			{# Appuie sur le ... pour voir toutes les actions #}

		<button onclick="myFunction()" class="dropbtn" > <i class="fa-solid fa-ellipsis"></i></button>
		<div id="myDropdown" class="dropdown-content">
			<a id="modifer">Modifier</a>
			<a id="Supprimer">Supprimer</a>
			<a id="Exporter">Exporter</a>
			<a id="Partager">Partager</a>
		</div>
	</div> -->





<!-- {# Bouton + pour ajouter une notes qui fait apparaître le form  #} -->
<i class="fa-solid fa-plus" id="addnote"></i>
 

</section> 



<section id="done">

<i class="fa-solid fa-plus"></i>

</section> 

<form id="creation">
	<input type="text" name="titre" id="titre" >
	<textarea name="description" id="description" cols="30" rows="10"></textarea>
	<input type="button" name="action" value="Ajouter">
</form>

<form id="modification" style="display:none">
	<input type="hidden" id="idnote" value="">
	<input type="text" name="titre" id="titremodif" >
	<textarea name="description" id="descriptionmodif" cols="30" rows="10"></textarea>
	<input type="button" name="action" id="savemodif" value="Sauvegarder">
</form>


<footer id="footer-general">

    <!-- {# <img class="logo_arbre" alt="logo" src="./output_css/images/inspi_logo.png" width="250"> #} -->

    <a href="#"> Mentions légales  </a>
    <a href="#"> CGU </a>
    <a href="#"> Plan du Site </a>

    <span> Copyright &copy; 2022 LP Imapp - Equipe présidentielle- Tous droits r&eacute;serv&eacute;s. </span>
    <br>
    <span> Edition spéciale : Hackathon by Marc Gaëtano </span>

  
    
</footer> 
  
</body>  
</html>  

