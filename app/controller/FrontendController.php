<?php 

namespace CP\Portfolio\controller;

use \CP\Portfolio\model\PostManager;
use \CP\Portfolio\model\CommentManager;

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
}