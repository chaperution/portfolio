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

	public function displayLoginAdmin() {
		$template = $this->_twig->load('backend/adminLoginView.html.twig');
		echo $template->render();
	}
	
}