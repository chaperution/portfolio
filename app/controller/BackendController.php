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
		$commentManager = new CommentManager();
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
	    $comments = $commentManager->getAllComments();
	    $members = $memberManager->getMembers();

		$template = $this->_twig->load('backend/adminView.html.twig');
		echo $template->render(array(
			'posts' => $posts,
			'comments' => $comments,
			'members' => $members,
		));
	}

	public function displayCreatePost() {
		$template = $this->_twig->load('backend/createPostView.html.twig');
		echo $template->render();
	}

	// permet la création d'un nouveau post avec ajout de l'image
	public function newPost($title, $content, $post_image) {
		$postManager = new PostManager();

		if (isset($_FILES['upload'])  AND !empty($_FILES['upload']['name'])){
			$maxSize = 2097152; // 2Mo
			$validExtensions = array('jpg', 'jpeg', 'png');
			if ($_FILES['upload']['size'] <= $maxSize) {
				$extensionUpload = strtolower(substr(strrchr($_FILES['upload']['name'], '.'), 1));
				if (in_array($extensionUpload, $validExtensions)) {
					$id = $postManager->createPost($title, $content);
					if ($id !== false)
					{
						$root = "../public/img/upload/" . $id . "." . $extensionUpload;
						$result = move_uploaded_file($_FILES['upload']['tmp_name'], $root);
						if ($result) {
							$update = $postManager->updatePostImage($id, $id.".".$extensionUpload);
							if ($udpate !== false)
							{
							Header('Location: index.php?action=admin&new-post=success');
							}
							else 
							{
								$deletePost = $postManager->deletePost($id);
								Header('Location: index.php?action=admin&new-post=error');
							}
						} else {
							Header('Location: index.php?action=admin&new-post=error-import');
						}
					}
					else 
					{
						// Erreur requête
					}
				} else {
					Header('Location: index.php?action=createPost&error=format');
				}
			} else {
				Header('Location: index.php?action=createPost&error=size');
			}
		}	
	}

	public function removePost($postId) {
		$postManager = new PostManager();

		$deletedPost = $postManager->deletePost($postId);

		Header('Location: index.php?action=admin&remove-post=success');
	}
	
}