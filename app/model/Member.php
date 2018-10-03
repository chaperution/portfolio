<?php 

namespace CP\Portfolio\model;

class Member {

	private $_id;
	private $_pseudo;
	private $_pass;
	private $_mail;
	private $_subscribe_date;

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

	public function pseudo() {
		return $this->_pseudo;
	}

	public function pass() {
		return $this->_pass;
	}

	public function mail() {
		return $this->_mail;
	}

	public function subsribe_date() {
		return $this->_subscribe_date;
	}

	// SETTERS

	public function setId($id) {
		$id = (int) $id;

		if ($id > 0) {
			$this->_id = $id;
		}
	}

	public function setPseudo($pseudo) {
		$this->_pseudo = $pseudo;
	}

	public function setPass($pass) {
		$this->_pass = $pass;
	}

	public function setMail($mail) {
		$this->_mail = $mail;
	}

	public function setSubsribe_date($subscribe_date) {
		$this->_subscribe_date = $subscribe_date;
	}