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

	// création d'un nouveau post dans la table Post
    public function createPost($title, $content) {
        $req = $this->db->prepare('INSERT INTO posts(title, content, creation_date, update_date) VALUES (?, ?, NOW(), NOW())');
        $newPost = $req->execute(array($title, $content));

        if ($newPost === false) {
        	return false;
        }

        return $this->db->lastInsertId();
    }

	// insertion de l'image liée au post
    public function updatePostImage($id, $post_image) {
        $req = $this->db->prepare('UPDATE posts SET post_image = ? WHERE id = ?');
        $update = $req->execute(array($post_image, $id));

        return $update;
    }

    // envoie la modification du post en fonction de son ID et en ajoutant une date de modification
    public function updatePost($title, $content, $postId) {
        $req = $this->db->prepare('UPDATE posts SET title = ?, content = ?, update_date = NOW() WHERE id = ?');
        $updated = $req->execute(array($title, $content, $postId));

        return $updated;
    }

    // supprime un post selon son ID dans la table Post
    public function deletePost($postId) {
        $req = $this->db->prepare('DELETE FROM posts WHERE id = ?');
        $deletedPost = $req->execute(array($postId));

        foreach (glob($GLOBALS['root']. "public/img/upload/" .$postId .".*") as $filename) {
		    unlink($filename);
		}

        return $deletedPost;
    }

}