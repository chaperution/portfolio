<?php 

namespace CP\Portfolio\model;

class Comment {

	private $_id;
	private $_id_post;
	private $_id_member;
	private $_content;
	private $_comment_date;

	public function __construct(array $donnees)
  	{
    	$this->hydrate($donnees);
  	}

  	// hydratation
	public function hydrate(array $donnees)
	{
	    foreach ($donnees as $key => $value)
	    {
	      	$method = 'set'.ucfirst($key);
	      
	    if (method_exists($this, $method))
	    {
	        $this->$method($value);
	    }
    }

	// GETTERS

	public function id() {
		return $this->_id;
	}

	public function id_post() {
		return $this->_id_post;
	}

	public function id_member() {
		return $this->_id_member;
	}

	public function content() {
		return $this->_content;
	}

	public function comment_date() {
		return $this->_comment_date;
	}

	// SETTERS

	public function setId($id) {
		$id = (int) $id;

		if ($id > 0) {
			$this->_id = $id;
		}
	}

	public function setId_post($id_post) {
		$id = (int) $id;

		if ($id > 0) {
			$this->_id = $id;
		}
	}

	public function setId_member($id_member) {
		$this->_id_member = $id_member;
	}

	public function setContent($content) {
		$this->_content = $content;
	}

	public function setComment_date($comment_date) {
		$this->_comment_date = $comment_date;
	}
}