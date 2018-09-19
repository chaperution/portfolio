<?php

// autoload les 2 contrôleurs 

try {
	if (isset($_GET['action'])) {
		if ($_GET['action'] == 'accueil') {
			// fonction du contrôleur
		}
	} else {
		//fonction du contrôleur
	}
}
catch(Exception $e) {
	echo 'Erreur : ' . $e->getMessage();
}