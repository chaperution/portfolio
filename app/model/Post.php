<?php 

namespace CP\Portfolio\model;

class Post {

	private $_id;
	private $_title;
	private $_content;
	private $_resume;
	private $_url;
	private $_creation_date;
	private $_update_date;
	private $_post_image;

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

	public function title() {
		return $this->_title;
	}

	public function content() {
		return $this->_content;
	}

	public function resume()
	{
		return $this->_resume;
	}
	public function url()
	{
		return $this->_url;
	}

	public function creation_date() {
		return $this->_creation_date;
	}

	public function update_date() {
		return $this->_update_date;
	}

	public function post_image() {
		return $this->_post_image;
	}

	// SETTERS

	public function setId($id) {
		$id = (int) $id;

		if ($id > 0) {
			$this->_id = $id;
		}
	}

	public function setTitle($title) {
		$this->_title = $title;
	}

	public function setContent($content) {
		$this->_content = $content;
	}

	public function setResume($resume)
	{
		$this->_resume = $resume;
	}

	public function setUrl($url)
	{
		$this->_url = $url;
	}

	public function setCreation_date($creation_date) {
		$this->_creation_date = $creation_date;
	}

	public function setUpdate_date($update_date) {
		$this->_update_date = $update_date;
	}

	public function setPost_image($post_image) {
		$this->_post_image = $post_image;
	}
}