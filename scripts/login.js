$( document ).ready( function ()
{
	// Formulaire d'inscription
	const displayform = _( "displayform" );
	const forLogin = _( "forLogin" );
	const loginForm = _( "loginForm" );
	const forRegister = _( "forRegister" );
	const registerForm = _( "registerForm" );
	const formContainer = _( "formContainer" );

	forLogin.addEventListener( "click", () =>
	{
		forLogin.classList.add( "active" );
		forRegister.classList.remove( "active" );

		if ( loginForm.classList.contains( "toggleform" ) )
		{
			formContainer.style.transform = "translate(0%)";
			formContainer.style.transition = "transform .5s";
			registerForm.classList.add( "toggleform" );
			loginForm.classList.remove( "toggleform" );
		}
	} );

	forRegister.addEventListener( "click", () =>
	{
		forLogin.classList.remove( "active" );
		forRegister.classList.add( "active" );

		if ( registerForm.classList.contains( "toggleform" ) )
		{
			formContainer.style.transform = "translate(-100%)";
			formContainer.style.transition = "transform .5s";
			registerForm.classList.remove( "toggleform" );
			loginForm.classList.add( "toggleform" );
		}
	} );

	function _( e )
	{
		return document.getElementById( e );
	}

	// Formulaire de connexion
	const form = document.getElementById( "registerForm" );
	const email = document.getElementById( "email" );
	const password = document.getElementById( "password" );
	const password2 = document.getElementById( "password2" );

	form.addEventListener( "submit", e =>
	{
		e.preventDefault();

		checkInputs();
	} );

	function checkInputs()
	{
		// trim to remove the whitespaces
		const emailValue = email.value.trim();
		const passwordValue = password.value.trim();
		const password2Value = password2.value.trim();

		if ( emailValue === "" )
		{
			setErrorFor( email, "le champs email est vide" );
		}
		else if ( !isEmail( emailValue ) )
		{
			setErrorFor( email, "le mail n est pas valide" );
		}
		else
		{
			setSuccessFor( email );
		}

		if ( passwordValue === "" )
		{
			setErrorFor( password, "le champs du mot de passe est vide" );
		}
		else
		{
			setSuccessFor( password );
		}

		if ( password2Value === "" )
		{
			setErrorFor( password2, "le champs de la confirmation du mot de passe est vide" );
		}
		else if ( passwordValue !== password2Value )
		{
			setErrorFor( password2, "le mot de passe ne corresponds pas" );
		}
		else
		{
			setSuccessFor( password2 );
		}
	}

	function setErrorFor( input, message )
	{
		const formControl = input.parentElement;
		const small = formControl.querySelector( "small" );
		formControl.className = "form-control error";
		small.innerText = message;
	}

	function setSuccessFor( input )
	{
		const formControl = input.parentElement;
		formControl.className = "form-control success";
	}

	function isEmail( email )
	{
		return /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test( email );
	}

	//
	// Permet d'afficher en clair le mot de passe entré dans le champ de saisie.
	//
	const login_password = $( "#login_password" );
	const login_clear = $( "#showmdp" );

	const register_password = $( "#password" );
	const register_clear = $( "#showmdp1" );

	login_clear.click( function ( _event )
	{
		if ( login_password.attr( "type" ) === "password" )
		{
			login_password.attr( "type", "text" );
		}
		else
		{
			login_password.attr( "type", "password" );
		}
	} );

	register_clear.click( function ( _event )
	{
		if ( register_password.attr( "type" ) === "password" )
		{
			register_password.attr( "type", "text" );
		}
		else
		{
			register_password.attr( "type", "password" );
		}
	} );

	// Permet d'envoyer le mail de récupération en cas de perte du mot de passe.
	$( "#missing_password" ).click( function ( event )
	{
		const email_value = prompt( "Saisissez votre adresse électronique." ).toLowerCase();

		$.post( "includes/views/login.php", { email: email_value, type: 2 }, function ( _data, _status )
		{
			alert( "Vous allez recevoir un mail d'ici quelques instants." );
		} );

		event.preventDefault();
	} );

	// Permet de gérer le système de connexion de l'utilisateur.
	$( "#loginForm" ).submit( function ( event )
	{
		const email_value = $( "#login_email" ).val();
		const password_value = $( "#login_password" ).val();

		$.post( "includes/views/login.php", { email: email_value, password: password_value, type: 1 }, function ( data, _status )
		{
			$( ".jquery" ).remove();
			$( "#loginForm" ).append( `<p class=\"jquery\">${ data }</p>` );
		} );

		event.preventDefault();
	} );

	// Permet de gérer le système d'inscription du site.
	$( "#registerForm" ).submit( function ( event )
	{
		const email_value = $( "#email" ).val();
		const password_value = $( "#password" ).val();

		$.post( "includes/views/login.php", { email: email_value, password: password_value, type: 3 }, function ( data, _status )
		{
			$( ".jquery" ).remove();
			$( "#registerForm" ).append( `<p class=\"jquery\">${ data }</p>` );
		} );

		event.preventDefault();
	} );

} );