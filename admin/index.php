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
			if (isset($_SESSION['id'])) {
				$backendController->displayAdmin();
			} else {
				throw new Exception("Vous devez vous connecter !");
			}
		}
		elseif ($_GET['action'] == 'createPost') {
			if (isset($_SESSION['id'])) {
				$backendController->displayCreatePost();
			} else {
				throw new Exception("Vous devez vous connecter !");
			}
		}
		elseif ($_GET['action'] == 'submitPost') {
			if (!empty($_POST['title']) && !empty($_POST['content']) && !empty($_FILES['upload']['name'])) {
				$backendController->newPost($_POST['title'], $_POST['content'], $_FILES['upload']['name']);
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
			$backendController->submitUpdate($_POST['title'], $_POST['content'], $_GET['id'], $_FILES['upload']['name']);
		}
	} else {
		$backendController->displayLoginAdmin();
	}
}
catch(Exception $e) {
	echo 'Erreur : ' . $e->getMessage();
}