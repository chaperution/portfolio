<?php 

namespace CP\Portfolio;

class BackendController {

	private $_twig;

	public function __construct($twig) {
		$this->_twig = $twig;
	}
	
}