<?php

session_start();

use \CP\Portfolio\controller\FrontendController;
use \CP\Portfolio\config\Project_Twig_Extension;

require __DIR__ . '/vendor/autoload.php';

require_once('vendor/autoload.php');
$loader = new \Twig_Loader_Filesystem('app/view');
$twig = new \Twig_Environment($loader, array('cache' => false, 'debug' => true));
$twig->addExtension(new Twig_Extension_Debug());
$twig->addExtension(new Project_Twig_Extension());

$frontendController = new FrontendController($twig);

// pour les chemins
$root = '';

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
	            if (!empty($_SESSION['pseudo']) && !empty($_POST['content'])) {
	                $frontendController->addComment($_GET['id'], $_SESSION['pseudo'], $_POST['content']);
	            }
	            else {
                    throw new Exception('Tous les champs ne sont pas remplis !');
	            }
	        }else {
                throw new Exception('Aucun identifiant de billet envoyé');
	        }
		}
		elseif ($_GET['action'] == 'subscribe') {
			$frontendController->displaySubscribe();
		}
		elseif ($_GET['action'] == 'addMember') {
			if (!empty($_POST['pseudo']) && !empty($_POST['pass']) && !empty($_POST['pass_confirm']) && !empty($_POST['mail'])) {
				if (filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) {
					$frontendController->addMember(strip_tags($_POST['pseudo']), strip_tags($_POST['pass']), strip_tags($_POST['mail']));	
				} else {
					throw new Exception('Pas d\'adresse mail valide.');
				}
			} else {
				throw new Exception('Tous les champs ne sont pas remplis !');
			}
		}
		elseif ($_GET['action'] == 'login') {
			$frontendController->displayLogin();
		}
		elseif ($_GET['action'] == 'loginSubmit') {
			$frontendController->loginSubmit(strip_tags($_POST['pseudo']), strip_tags($_POST['pass']));
		}
		elseif ($_GET['action'] == 'logout') {
			$frontendController->logout();
		}
		elseif ($_GET['action'] == 'privacy') {
			$frontendController->displayPrivacy();
		}
		elseif ($_GET['action'] == 'contact') {
			$frontendController->displayContact();
		}
		elseif ($_GET['action'] == 'sendContact') {
			$frontendController->sendContact();
		}
	} else {
		$frontendController->displayHome();
	}
}
catch(Exception $e) {
	echo 'Erreur : ' . $e->getMessage();
}