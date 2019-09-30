<?php 

namespace CP\Portfolio\controller;

use \CP\Portfolio\model\PostManager;
use \CP\Portfolio\model\CommentManager;
use \CP\Portfolio\model\MemberManager;
use \CP\Portfolio\model\Pagination;

class FrontendController {
	private $_twig;
	private $_commentsPerPage = 3;
	private $_myMail = "contact@charlotteperution.fr";
	private $_subjectMail = "CONTACT - Portfolio charlotteperution.fr";
	private $_headerFrom = 'From:"charlotteperution.fr"<support@charlotteperution.fr>';
	

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
		$template = $this->_twig->load('frontend/homeView.html.twig');
		echo $template->render(array(
			'posts' => $posts,
		));
	}

	public function post() {
		$postManager = new PostManager();
		//$commentManager = new CommentManager();
		$pagination = new Pagination();

		//$nbComments = $pagination->getCommentsPagination($_GET['id']);
		//$nbPage = $pagination->getCommentsPages($nbComments, $this->_commentsPerPage);

		/*if (isset($_GET['page']) && $_GET['page'] > 0 && $_GET['page'] <= $nbPage) {
				$cPage = (intval($_GET['page']) - 1) * $this->_commentsPerPage;
			}
		else {
			$cPage = 0;
		}*/

		$post = $postManager->getPost($_GET['id']);
		//$comments = $commentManager->getComments($_GET['id'], $cPage, $this->_commentsPerPage);

		$template = $this->_twig->load('frontend/postView.html.twig');
		echo $template->render(array(
			'post' => $post,
			//'comments' => $comments,
			//'nbPage' => $nbPage,
		));
	}

	public function addComment($postId, $author, $content) {
		$commentManager = new CommentManager();

		$req = $commentManager->postComment($postId, $author, $content);

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
		$memberManager = new MemberManager();

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
				header('Location: index.php?accountStatus=account-successfully-created');
			}
		}	
	}

	public function loginSubmit($pseudo, $pass) {
		$memberManager = new MemberManager();

		$member = $memberManager->loginMember($pseudo);

		$isPasswordCorrect = password_verify($_POST['pass'], $member['pass']);

		if (!$member) {
	        header('Location: index.php?action=login&accountStatus=unsuccess-login');
	    }
	    else {
	    	if ($isPasswordCorrect) {
	    		$_SESSION['id'] = $member['id'];
	    		$_SESSION['pseudo'] = ucfirst(strtolower($pseudo));
	    		header('Location: index.php');
	    	}
	        else {
	        	header('Location: index.php?action=login&accountStatus=unsuccess-login');
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

	public function displayPrivacy(){
		$template = $this->_twig->load('frontend/privacyView.html.twig');
		echo $template->render();
	}

	public function displayContact() {
		$template = $this->_twig->load('frontend/contactView.html.twig');
		echo $template->render();
	}

	public function sendContact() {
		$postManager = new PostManager();
		$reCaptcha = $postManager->getReCaptcha($_POST['g-recaptcha-response']);

		if (isset($_POST['mailform']))  {
			if ($reCaptcha->success == true) {
				if (!empty($_POST['nom']) && !empty($_POST['mail']) && !empty($_POST['message']) && !empty($_POST['consent'])) {
			
					// Récupération des variables et sécurisation des données
					// htmlentities() convertit des caractères "spéciaux" en équivalent HTML
					$nom     = htmlentities($_POST['nom']); 
					$email   = htmlentities($_POST['mail']);
					$message = htmlentities($_POST['message']);

					$header = "MIME-Version: 1.0\r\n";
					$header.= $this->_headerFrom."\n";
					$header.='Content-Type:text/html; charset="utf-8"'."\n";
					$header.='Content-Tranfer-Encoding: 8bit';

					$message = '
						<html>
							<body>
								<div align="center">
									<p>Nom de l\'expéditeur :</p>' .$_POST['nom'].'<br />
									<p>Adresse mail de l\'expéditeur :</p>' .$_POST['mail'].'<br />
									'.nl2br($_POST['message']).'
								</div>
							</body>
						</html>
					';

					mail($this->_myMail, $this->_subjectMail , $message, $header);

					header('Location: index.php?sendContact=success#contact');
					
				} else {
					header('Location: index.php?sendContact=error#contact');
				}
			} else {
				header('Location: index.php?sendContact=error#contact');
			}
		}		
	}
}