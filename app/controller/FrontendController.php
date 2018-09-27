<?php 

namespace CP\Portfolio\controller;

use \CP\Portfolio\model\PostManager;
use \CP\Portfolio\model\CommentManager;
use \CP\Portfolio\model\MemberManager;

class FrontendController {
	private $_twig;

	public function __construct($twig) {
		$this->_twig = $twig;
	}

	public function displayHome() {
		$template = $this->_twig->load('frontend/homeView.html.twig');
		echo $template->render();
	}

	public function listPosts() {
		$postManager = new PostManager();
		$posts = $postManager->getPosts();
		$template = $this->_twig->load('frontend/postsView.html.twig');
		echo $template->render(array(
			'posts' => $posts,
		));
	}

	public function post() {
		$postManager = new PostManager();
		$commentManager = new commentManager();

		$post = $postManager->getPost($_GET['id']);
		$comments = $commentManager->getComments($_GET['id']);

		$template = $this->_twig->load('frontend/postView.html.twig');
		echo $template->render(array(
			'post' => $post,
			'comments' => $comments,
		));
	}

	public function addComment($id_post, $author, $content) {
		$commentManager = new CommentManager();

		$req = $commentManager->postComment($id_post, $author, $content);

		if ($req === false) {
			throw new Exception("Impossible d'ajouter le commentaire !");
		} else {
			header('Location: index.php?action=post&id=' . $postId . '#commentsFrame');
		}
	}

	public function displaySubscribe() {
		$template = $this->_twig->load('frontend/subscribeView.html.twig');
		echo $template->render();
	}

	public function addMember($pseudo, $pass, $mail) {
		$MemberManager = new MemberManager();

		$usernameValidity = $memberManager->checkPseudo($pseudo);
		$mailValidity = $memberManager->checkMail($mail);

		if ($usernameValidity) {
			header('Location: index.php?action=subscribe&error=invalidUsername');	
		}

		if ($mailValidity) {
			header('Location: index.php?action=subscribe&error=invalidMail');
		}

		if (!$usernameValidity && !$mailValidity) {
			if ($_POST['pass'] == $_POST['pass_confirm']) {
				// Hachage du mot de passe
				$pass = password_hash($_POST['pass'], PASSWORD_DEFAULT);
				
				$newMember = $memberManager->createMember($pseudo, $pass, $mail);
				
				// redirige vers page d'accueil avec le nouveau paramètre
				header('Location: index.php?account-status=account-successfully-created');
			} else {
				header('Location: index.php?action=subscribe&error=pass');
			}
		}	
	}

	public function loginSubmit($pseudo, $pass) {
		$memberManager = new MemberManager();

		$member = $memberManager->loginMember($pseudo);

		$isPasswordCorrect = password_verify($_POST['pass'], $member['pass']);

		if (!$member) {
	        header('Location: index.php?action=login&account-status=unsuccess-login');
	    }
	    else {
	    	if ($isPasswordCorrect) {
	    		$_SESSION['id'] = $member['id'];
	    		$_SESSION['pseudo'] = ucfirst(strtolower($pseudo));
	    		$_SESSION['groups_id'] = $member['groups_id'];
	    		header('Location: index.php');
	    	}
	        else {
	        	header('Location: index.php?action=login&account-status=unsuccess-login');
	        }
	    }
	}

	public function displayLogin() {
		$template = $this->_twig->load('frontend/loginView.html.twig');
		echo $template->render();
	}

	public function logout() {
		$_SESSION = array();
		setcookie(session_name(), '', time() - 42000);
		session_destroy();

		header('Location: index.php?logout=success');
	}
}