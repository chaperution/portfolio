<?php 

namespace CP\Portfolio\model;

class Comment {

	private $_id;
	private $_id_post;
	private $_author;
	private $_content;
	private $_comment_date;

	// GETTERS

	public function id() {
		return $this->_id;
	}

	public function id_post() {
		return $this->_id_post;
	}

	public function author() {
		return $this->_author;
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

	public function setAuthor($author) {
		$this->_author = $author;
	}

	public function setContent($content) {
		$this->_content = $content;
	}

	public function setComment_date($comment_date) {
		$this->_comment_date = $comment_date;
	}
}