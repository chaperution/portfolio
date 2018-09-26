<?php 

namespace CP\Portfolio\controller;

use \CP\Portfolio\model\PostManager;

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
		$post = $postManager->getPost($_GET['id']);
		$template = $this->_twig->load('frontend/postView.html.twig');
		echo $template->render(array(
			'post' => $post,
		));
	}

}