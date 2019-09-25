// Gestion des messages d'erreur et de succès

var flashMessageSuccess = document.getElementById('success');

var flashMessageError = document.getElementById('error');

if (flashMessageSuccess !== null) {
	setTimeout(function(){flashMessageSuccess.style.display = 'none'}, 10000);
}

if (flashMessageError !== null) {
	setTimeout(function(){flashMessageError.style.display = 'none'}, 10000);
}