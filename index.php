<?php

// autoload les 2 contrôleurs
use \CP\Portfolio\controller\FrontendController;
require __DIR__ . '/vendor/autoload.php';

require_once('vendor/autoload.php');
$loader = new \Twig_Loader_Filesystem('app/view');
$twig = new \Twig_Environment($loader, array('cache' => false));

$frontendController = new FrontendController($twig);

try {
	if (isset($_GET['action'])) {
		if ($_GET['action'] == 'accueil') {
			$frontendController->displayHome();
		}
		elseif ($_GET['action'] == 'listPosts') {
			$frontendController->listPosts();
		}
	} else {
		$frontendController->displayHome();
	}
}
catch(Exception $e) {
	echo 'Erreur : ' . $e->getMessage();
}