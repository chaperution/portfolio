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
		elseif ($_GET['action'] == 'createPost') {
			$backendController->displayCreatePost();
		}
		elseif ($_GET['action'] == 'submitPost') {
			if (!empty($_POST['title']) && !empty($_POST['content']) && !empty($_POST['resume']) && !empty($_POST['url']) && !empty($_FILES['upload']['name'])) {
				$backendController->newPost($_POST['title'], $_POST['content'], $_POST['resume'], $_POST['url'], $_FILES['upload']['name']);
			} else {
				throw new Exception('Contenu vide !');
			}
		}
		elseif ($_GET['action'] == 'deletePost') {
			$backendController->removePost($_GET['id']);
		}
		elseif ($_GET['action'] == 'updatePost') {
			if (isset($_GET['id']) && $_GET['id'] > 0) {
				if (isset($_SESSION)) {
					$backendController->displayUpdate();
				}  
	        } else {
				throw new Exception('Projet non trouvé.');
			}
		}
		elseif ($_GET['action'] == 'submitUpdate') {
			$backendController->submitUpdate($_POST['title'], $_POST['content'], $_POST['resume'], $_POST['url'], $_GET['id'], $_FILES['upload']['name']);
		}
		elseif ($_GET['action'] == 'deleteComment') {
			$backendController->removeComment($_GET['id']);
		}
		elseif ($_GET['action'] == 'deleteMember') {
			$backendController->removeMember($_GET['id']);
		}
	} else {
		$backendController->displayLoginAdmin();
	}
}
catch(Exception $e) {
	echo 'Erreur : ' . $e->getMessage();
}