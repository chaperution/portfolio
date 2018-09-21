<?php 

namespace CP\Portfolio;

class FrontendController {
	private $_twig;

	public function __construct($twig) {
		$this->_twig = $twig;
	}

	public function displayHome() {
		$template = $this->_twig->load('frontend/homeView.html.twig');
		echo $template->render();
		
	}

}