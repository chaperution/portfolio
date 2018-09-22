// Ajout de l'API Github avec profil utilisateur

//var linkAPI = "https://api.github.com/users/" + userName;

function Github(userName, APIFrame) {
	this.userName = userName;
	this.APIFrame = APIFrame;
	this.login;
	this.html_url;
	this.avatar_url;
	this.public_repos;
	this.location;

	var that = this;

	ajaxGet("https://api.github.com/users/" + userName, function(reponse){
		var event = JSON.parse(reponse);

		that.login = event.login;
		that.html_url = event.html_url;
		that.avatar_url = event.avatar_url;
		that.public_repos = event.public_repos;
		that.location = event.location;

		var avatarElt = document.createElement("img");
		avatarElt.src = that.avatar_url;
		avatarElt.style.height = "200px";
		avatarElt.style.width = "200px";
		avatarElt.style.borderRadius = "50%";

		var userElt = document.createElement("p");
		var urlElt = document.createElement("a");
		userElt.appendChild(urlElt);	
		urlElt.href = that.html_url;
		urlElt.textContent = that.login;
		urlElt.style.fontWeight = "bold";
		urlElt.style.fontFamily = "Roboto";
		urlElt.style.fontSize = "1.4em";
		urlElt.style.textDecoration = "none";
		urlElt.style.color = "#45aaf2";
		
		var locationElt = document.createElement("p");
		locationElt.innerHTML = "<i class='fas fa-map-marker-alt' aria-hidden='true'></i>  ";
		locationElt.appendChild(document.createTextNode(that.location));
		locationElt.style.fontFamily = "Roboto";
		locationElt.style.fontSize = "1.2em";

		var reposElt = document.createElement("div");
		if (that.public_repos !== 0) {
			reposElt.innerHTML = "<i class='far fa-file-alt'></i>  ";
			reposElt.appendChild(document.createTextNode(that.public_repos + " repositories"));
			reposElt.style.fontFamily = "Roboto";
			reposElt.style.fontSize = "1.2em";
		} else {
			reposElt.textContent = "Pas de repositories !"
		}
		
		APIFrame.appendChild(avatarElt);
		APIFrame.appendChild(userElt);
		APIFrame.appendChild(locationElt);
		APIFrame.appendChild(reposElt);
	});
}

var myGithub = new Github("chaperution", document.getElementById("API"));


console.log(reponse);

//var APIFrame = document.getElementById("API");

//var userName = "chaperution";


//"https://api.github.com/users/" + userName + "/events/public";
//"https://api.github.com/repos/" + userName + "/" + repoName + "/events"