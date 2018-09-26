<?php

// autoload les 2 contrôleurs
use \CP\Portfolio\controller\FrontendController;
require __DIR__ . '/vendor/autoload.php';

require_once('vendor/autoload.php');
$loader = new \Twig_Loader_Filesystem('app/view');
$twig = new \Twig_Environment($loader, array('cache' => false, 'debug' => true));
$twig->addExtension(new Twig_Extension_Debug());

$frontendController = new FrontendController($twig);

try {
	if (isset($_GET['action'])) {
		if ($_GET['action'] == 'accueil') {
			$frontendController->displayHome();
		}
		elseif ($_GET['action'] == 'listPosts') {
			$frontendController->listPosts();
		}
		elseif ($_GET['action'] == 'post') {
			if (isset($_GET['id']) && $_GET['id'] > 0 && is_numeric($_GET['id'])) {
				$frontendController->post();
			} else {
				throw new Exception('Aucun identifiant de billet envoyé');
			}
		}
		elseif ($_GET['action'] == 'addComment') {
			if (isset($_GET['id']) && $_GET['id'] > 0) {
	            if (!empty($_SESSION['pseudo']) && !empty($_POST['comment'])) {
	                $frontendController->addComment($_GET['id'], $_SESSION['pseudo'], $_POST['content']);
	            }
	            else {
                    throw new Exception('Tous les champs ne sont pas remplis !');
	            }
	        }else {
                throw new Exception('Aucun identifiant de billet envoyé');
	        }
		}
	} else {
		$frontendController->displayHome();
	}
}
catch(Exception $e) {
	echo 'Erreur : ' . $e->getMessage();
}