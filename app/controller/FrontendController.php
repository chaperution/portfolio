<?php 

namespace CP\Portfolio;

use \CP\Portfolio\PostManager;

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
		echo $template->render();
	}

}