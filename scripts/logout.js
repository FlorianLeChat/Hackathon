$( document ).ready( function ()
{
	// On réalise une redirection automatique après 3 secondes.
	setTimeout( function ()
	{
		window.location.href = "/hackathon/?target=login";
	}, 3000 );
} );