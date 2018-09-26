<?php 

namespace CP\Portfolio\model;

require_once("Database.php");

class PostManager extends Database {

	public function getPosts() {
		$req = $this->db->query('SELECT id, title, content, DATE_FORMAT(creation_date, "%d/%m/%Y %H:%i:%s") AS date_fr, DATE_FORMAT(update_date, "%d/%m/%Y %H:%i:%s") AS update_date_fr, post_image FROM posts ORDER BY creation_date DESC');
		return $req;
	}

	public function getPost($postId) {
		$req = $this->db->prepare('SELECT id, title, content, DATE_FORMAT(creation_date, "%d/%m/%Y %H:%i:%s") AS date_fr, DATE_FORMAT(update_date, "%d/%m/%Y %H:%i:%s") AS update_date_fr, post_image  FROM posts WHERE id = ?');
        $req->execute(array($postId));
        $post = $req->fetch();
        return $post;
	}
}