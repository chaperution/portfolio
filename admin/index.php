<?php

session_start();

use \CP\Portfolio\controller\BackendController;
use \CP\Portfolio\config\Project_Twig_Extension;

require '../vendor/autoload.php';

require_once('../vendor/autoload.php');
$loader = new \Twig_Loader_Filesystem('../app/view');
$twig = new \Twig_Environment($loader, array('cache' => false, 'debug' => true));
$twig->addExtension(new Twig_Extension_Debug());
$twig->addExtension(new Project_Twig_Extension());

$backendController = new BackendController($twig);

// pour les chemins
$root = '../';

try {
	if (isset($_GET['action'])) {
		if ($_GET['action'] == 'admin-login-view') {
			$backendController->displayLoginAdmin();
		}
		elseif ($_GET['action'] == 'adminLogin') {
			$backendController->loginAdmin();
		}
		elseif ($_GET['action'] == 'admin') {
			$backendController->displayAdmin();
		}
	} else {
		$backendController->displayLoginAdmin();
	}
}
catch(Exception $e) {
	echo 'Erreur : ' . $e->getMessage();
}