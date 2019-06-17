// Ajout de l'API Github avec profil utilisateur et liste des 5 derniers commits

/*function Github(userName, profilAPI, eventsAPI) {

	var that = this;

	this.initProfil = function() {
		ajaxGet("https://api.github.com/users/" + userName, function(reponse){
			var event = JSON.parse(reponse);

			var avatarElt = document.createElement("img");
			avatarElt.src = event.avatar_url;
			avatarElt.style.height = "200px";
			avatarElt.style.width = "200px";
			avatarElt.style.borderRadius = "50%";

			var userElt = document.createElement("p");
			var urlElt = document.createElement("a");
			userElt.appendChild(urlElt);	
			urlElt.href = event.html_url;
			urlElt.textContent = event.login;
			urlElt.style.fontWeight = "bold";
			urlElt.style.fontFamily = "Roboto";
			urlElt.style.fontSize = "1.4em";
			urlElt.style.textDecoration = "none";
			urlElt.style.color = "#45aaf2";
			
			var locationElt = document.createElement("p");
			locationElt.innerHTML = "<i class='fas fa-map-marker-alt' aria-hidden='true'></i>  ";
			locationElt.appendChild(document.createTextNode(event.location));
			locationElt.style.fontFamily = "Roboto";
			locationElt.style.fontSize = "1.2em";

			var reposElt = document.createElement("p");
			if (that.public_repos !== 0) {
				reposElt.innerHTML = "<i class='far fa-file-alt'></i>  ";
				reposElt.appendChild(document.createTextNode(event.public_repos + " repositories"));
				reposElt.style.fontFamily = "Roboto";
				reposElt.style.fontSize = "1.2em";
			} else {
				reposElt.textContent = "Pas de repositories !"
			}
			
			profilAPI.appendChild(avatarElt);
			profilAPI.appendChild(userElt);
			profilAPI.appendChild(locationElt);
			profilAPI.appendChild(reposElt);
		});
	}
	
	this.initEvents = function() {
		ajaxGet("https://api.github.com/users/" + userName + "/events", function(reponse){
			var events = JSON.parse(reponse);
			// filtre les éléments selon le type
			events = events.filter(function(el){ return el.type == "PushEvent"; });

			for (i = 0; i < 5 && i < events.length; i++) {
				// récupération de la date avec transformation au format FR
				var dateEvent = document.createElement("em");
				dateEvent.textContent = events[i].created_at;
				dateEvent.style.fontFamily = "Roboto";
				dateFormat = events[i].created_at.slice(0, 10);
				hourFormat = events[i].created_at.slice(11, 16);
				splitDate = dateFormat.split("-");
				dateFr = splitDate[2] + ' ' + splitDate[1] + ' ' + splitDate[0] + ' à ' + hourFormat.replace(':', 'h');
				dateEvent.textContent = dateFr;

				var nameRepo = document.createElement("p");
				nameRepo.innerHTML = "<i class='far fa-file-alt'></i>  ";
				nameRepo.appendChild(document.createTextNode("Repository : " + events[i].repo.name));
				nameRepo.style.fontFamily = "Roboto";
				nameRepo.style.fontSize = "1.2em";
				nameRepo.style.color = "#45aaf2";

				var commits = events[i].payload.commits;
				for (a = 0; a < commits.length; a++) {
					var messageEvent = document.createElement("p");
					messageEvent.textContent = "Commit : " + commits[a].message;
					messageEvent.fontFamily = "Roboto";
					messageEvent.style.fontSize = "1.2em";
				}

				eventsAPI.appendChild(nameRepo);
				eventsAPI.appendChild(dateEvent);
				eventsAPI.appendChild(messageEvent);	
			}
		});
	}
	this.initProfil();
	this.initEvents();	
}

var myGithub = new Github("chaperution", document.getElementById("profilAPI"), document.getElementById("eventsAPI"));
*/


/*$('a[href^="#"]').click(function () {
	var the_id = $(this).attr("href");
	if (the_id === '#') {
		return;
	}
	$('html, body').animate({
		scrollTop: $(the_id).offset().top
	}, 'slow');
	return false;
});*/


/*var left = $('#pannel1').offset().left;

$(window).ready(function() {
	$("#pannel1").css({left:left}).animate({ left: "400px" }, "slow");
});*/


var hasMoved = false;
$(window).scroll(function () {
	let pannel1 = $('#pannel1');
	let hauteurPannel1 = Number.parseInt(pannel1.css("height").substring(0, pannel1.css("height").length - 2));
	if (!hasMoved && $('#pannel1').offset().top < $(window).scrollTop() + hauteurPannel1)
	{
		hasMoved = true;
		pannel1.animate({ left: '-=' + pannel1.css("left") }, 2000);
		$('#pannel2').animate({ right: '-=' + $('#pannel2').css("right") }, 2000);
	}
});