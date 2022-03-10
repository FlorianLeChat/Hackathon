/* When the user clicks on the button,
toggle between hiding and showing the dropdown content */
function myFunction()
{
	document.getElementById( "myDropdown" ).classList.toggle( "show" );
}

// Close the dropdown menu if the user clicks outside of it
window.onclick = function ( event )
{
	if ( !event.target.matches( '.pp' ) )
	{

		var dropdowns = document.getElementsByClassName( "dropdown-content" );
		var i;
		for ( i = 0; i < dropdowns.length; i++ )
		{
			var openDropdown = dropdowns[ i ];
			if ( openDropdown.classList.contains( 'show' ) )
			{
				openDropdown.classList.remove( 'show' );
			}
		}
	}
};

function ouvrir()
{
	document.getElementById( 'creation' ).style.display = "block";
}


$( document ).ready( function ()
{

	function ajouter()
	{
		let newdiv = $( "<div></div>" );
		$.post( "sendnote.php",
			{ creator: $( "#creator" ).val(), titre: $( "#titre" ).val(), description: $( "#description" ).val(), action: $( "input[name=action]" ).val() },
			function ( data, status )
			{
				if ( status == "success" )
				{
					let info = $.parseJSON( data );
					newdiv.html( "<h2>" + info[ "titre" ] + "</h2><p>" + info[ "note" ] + "</p> <img src='" + info[ "avatar" ] + "' alt='Avatar du créateur'>" );
					$( "#todo" ).append( newdiv );
				}
			} );
		$( ".divnote .delete" ).click( supprimer );
	}

	function supprimer()
	{
		if ( confirm( "Etes vous sûr de vouloir supprimer cette note ?" ) )
		{
			let div = $( this ).parent();
			$.post( "sendnote.php",
				{ note_id: div.data( "id" ), action: $( this ).val() },
				function ( data, status )
				{
					if ( status == "success" )
					{
						div.remove();
					}
				} );
		}

	}

	function modifier( idnote )
	{
		if ( confirm( "Etes vous sûr de vouloir sauvegarder les modifications ?" ) )
		{
			let titremodif = $( "#modification #titremodif" ).val();
			let descriptionmodif = $( "#modification #descriptionmodif" ).val();
			$.post( "sendnote.php",
				{ note_id: idnote, action: $( "#modification #savemodif" ).val(), titre: titremodif, description: descriptionmodif },
				function ( data, status )
				{
					if ( status == "success" )
					{
						$( "#modification" ).css( "display", "none" );
						location.reload(); //manque de temps...
					}
				} );
		}
	}

	function fait()
	{
		if ( confirm( "Etes vous sûr de vouloir des passer cette tâches dans la catégorie 'FAIT' ?" ) )
		{
			let div = $( this ).parent();
			$.post( "sendnote.php",
				{ do: "Terminé", action: $( ".divnote .end" ).val(), note_id: $( this ).parent().data( "id" ) },
				function ( data, status )
				{
					if ( status == "success" )
					{
						$( "#done" ).append( div );
					}
				} );
		}
	}

	$( "#creation input[type=button]" ).click( ajouter );
	$( ".divnote .delete" ).click( supprimer );
	$( ".divnote .end" ).click( fait );


	$( ".divnote .modify" ).click( function ()
	{
		let idnote = $( this ).parent().data( "id" );
		$( "#modification #titremodif" ).val( $( this ).parent().children( "h2" ).text() );
		$( "#modification #descriptionmodif" ).val( $( this ).parent().children( "p" ).text() );
		$( "#modification" ).css( "display", "block" );
		$( "#modification #savemodif" ).click( function () { modifier( idnote ); } );
	} );


} );