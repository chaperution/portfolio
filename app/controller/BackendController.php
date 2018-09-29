<?php 

namespace CP\Portfolio\controller;

use \CP\Portfolio\model\PostManager;
use \CP\Portfolio\model\CommentManager;
use \CP\Portfolio\model\MemberManager;

class BackendController {

	private $_twig;
	private $_commentsPerPage = 6;

	public function __construct($twig) {
		$this->_twig = $twig;
	}

	// affiche la page de connexion au panneau d'administration
	public function displayLoginAdmin() {
		$template = $this->_twig->load('backend/adminLoginView.html.twig');
		echo $template->render();
	}

	// permet la connexion au panneau d'administration
	public function loginAdmin() {
		if (isset($_POST['pass']) AND $_POST['pass'] == "TESTCHA") {
			header('Location: index.php?action=admin');
		} else {
			// possible de resaisir le mdp après 1 seconde
			sleep(1);
			header('Location: index.php?action=admin-login-view&accountStatus=unsuccess-login');
		}
	}

	// affiche la page d'administration
	public function displayAdmin() {
		$postManager = new PostManager(); 
		$memberManager = new MemberManager();
		//$pagination = new Pagination();

		/*$nbPosts = $pagination->getPostsPagination();
		$nbPage = $pagination->getPostsPages($nbPosts, $postsPerPage);

		if (!isset($_GET['page'])) {
			$cPage = 0;
		} else {
			if (isset($_GET['page']) && $_GET['page'] > 0 && $_GET['page'] <= $nbPage) {
				$cPage = (intval($_GET['page']) - 1) * $postsPerPage;
			}
		}*/
		
	    $posts = $postManager->getPosts();
	 
	    $members = $memberManager->getMembers();

		$template = $this->_twig->load('backend/adminLoginView.html.twig');
		echo $template->render(array(
			'posts' => $posts,
			'comments' => $comments,
			'members' => $members,
		));
	}
	
}