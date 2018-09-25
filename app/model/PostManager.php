<?php 

namespace CP\Portfolio;

require_once("model/Database.php");

class PostManager extends Database {

	public function getPosts() {
		$db = $this->dbConnect();
		$req = $bdd->query('SELECT id, title, content, DATE_FORMAT(creation_date, "%d/%m/%Y %H:%i:%s") AS date_fr, DATE_FORMAT(update_date, "%d/%m/%Y %H:%i:%s") AS update_date_fr FROM posts ORDER BY creation_date DESC');
		return $req;
	}

	public function getPost($postId) {
		$db = $this->dbConnect();
		$req = $bdd->prepare('SELECT id, title, content, DATE_FORMAT(creation_date, "%d/%m/%Y %H:%i:%s") AS date_fr, DATE_FORMAT(update_date, "%d/%m/%Y %H:%i:%s") AS update_date_fr FROM posts WHERE id = ?');
        $req->execute(array($postId));
        $post = $req->fetch();
        return $post;
	}
}