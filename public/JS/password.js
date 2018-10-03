// vérification du format du mot de passe lors de l'inscription d'un nouveau membre

var form = document.querySelector("form");
form.addEventListener("submit", function(e) {
	
	var mdp1 = form.elements.pass.value; 
	var mdp2 = form.elements.pass_confirm.value;

	var message = "";
	if (mdp1 === mdp2) {
		if (mdp1.length >= 8) {
			var regexMdp = /\d+/;
			if (!regexMdp.test(mdp1)) {
				message = "Erreur : Le mot de passe doit contenir au moins un chiffre.";
				e.preventDefault();
			}
		} else {
			message = "Erreur : Le mot de passe doit contenir au moins 8 caractères.";
			e.preventDefault();
		}
	} else {
		message = "Erreur : Les deux mots de passe ne sont pas identiques.";
		e.preventDefault();
	}
	document.getElementById("infoMdp").textContent = message;
});