<?php 

namespace CP\Portfolio\controller;

use \CP\Portfolio\model\PostManager;
use \CP\Portfolio\model\CommentManager;
use \CP\Portfolio\model\MemberManager;

class BackendController {

	private $_twig;

	public function __construct($twig) {
		$this->_twig = $twig;
	}

	// affiche la page de connexion au panneau d'administration
	public function displayLoginAdmin() {
		// détruis la session en cours lorsque l'on veut accéder à la page Administration
		$_SESSION = array();
		setcookie(session_name(), '', time() - 42000);
		session_destroy();

		$template = $this->_twig->load('backend/adminLoginView.html.twig');
		echo $template->render();
	}

	// permet la connexion au panneau d'administration
	public function loginAdmin() {
		if (isset($_POST['pass']) AND $_POST['pass'] == "TESTCha34.") {
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
	public function newPost($title, $content, $resume, $url, $post_image) {
		$postManager = new PostManager();

		if (isset($_FILES['upload'])  AND !empty($_FILES['upload']['name'])){
			$maxSize = 3000000; // 3Mo
			$validExtensions = array('jpg', 'jpeg', 'png');
			if ($_FILES['upload']['size'] <= $maxSize) {
				$extensionUpload = strtolower(substr(strrchr($_FILES['upload']['name'], '.'), 1));
				if (in_array($extensionUpload, $validExtensions)) {
					$id = $postManager->createPost($title, $content, $resume, $url);
					if ($id !== false)
					{
						$root = "../public/img/upload/" . $id . "." . $extensionUpload;
						$result = move_uploaded_file($_FILES['upload']['tmp_name'], $root);
						if ($result) {
							$update = $postManager->updatePostImage($id, $id.".".$extensionUpload);
							if ($udpate !== false)
							{
							Header('Location: index.php?action=admin&newPost=success');
							}
							else 
							{
								$deletePost = $postManager->deletePost($id);
								Header('Location: index.php?action=admin&newPost=error');
							}
						} else {
							Header('Location: index.php?action=admin&newPost=error-import');
						}
					}
					else 
					{
						Header('Location: index.php?action=admin&request=error');
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

		Header('Location: index.php?action=admin&removePost=success');
	}

	public function displayUpdate() {
		$postManager = new PostManager();

		$post = $postManager->getPost($_GET['id']);

		$template = $this->_twig->load('backend/updatePostView.html.twig');
		echo $template->render(array(
			'post' => $post, 
		));
	}

	public function submitUpdate($title, $content, $resume, $url, $postId, $post_image) {
		$postManager = new PostManager();

		$result = $postManager->updatePost($title, $content, $resume, $url, $postId);
		if ($result !== false) {
			if (isset($_FILES['upload'])  AND !empty($_FILES['upload']['name'])){
				// supprime l'ancien fichier
	        	foreach (glob($GLOBALS['root']. "public/img/upload/" .$postId .".*") as $filename) 
					unlink($filename);
				$maxSize = 3000000; // 3Mo
				if ($_FILES['upload']['size'] <= $maxSize) {
					$extensionUpload = strtolower(substr(strrchr($_FILES['upload']['name'], '.'), 1));
					$validExtensions = array('jpg', 'jpeg', 'png');
					if (in_array($extensionUpload, $validExtensions)) {
							$root = "../public/img/upload/" . $postId . "." . $extensionUpload;
							$result = move_uploaded_file($_FILES['upload']['tmp_name'], $root);
							if ($result) {
								$update = $postManager->updatePostImage($postId, $postId.".".$extensionUpload);
								if ($udpate !== false)
								{
								Header('Location: index.php?action=admin&updateStatus=success');
								}
								else 
								{
									Header('Location: index.php?action=admin&updateStatus=error');
								}
							} else {
								Header('Location: index.php?action=admin&updateStatus=error-import');
							}
					} else {
						Header('Location: index.php?action=updatePost&id=' .$postId. '&error=format');
					}
				} else {
					Header('Location: index.php?action=updatePost&id=' .$postId. '&error=size');
				}
			}	
			else
				Header('Location: index.php?action=admin&updateStatus=success');
		}
		else 
		{
			Header('Location: index.php?action=admin&request=error');
		}
	}

	// permet la modération d'un commentaire signalé
	public function removeComment($commentId) {
		$commentManager = new CommentManager();

		$deletedComment = $commentManager->deleteComment($commentId);

		Header('Location: index.php?action=admin&removeComment=success');
	}
	
	// permet de supprimer un membre
	public function removeMember($memberId) {
		$memberManager = new MemberManager();

		$deletedMember = $memberManager->deleteMember($memberId);

		Header('Location: index.php?action=admin&removeMember=success');	
	}
}