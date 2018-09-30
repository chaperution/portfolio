<?php 

namespace CP\Portfolio\model;

class CommentManager extends Database {

	// recupère les commentaires d'un post en fonction de son ID
    public function getComments($id_post)
    {
        $comments = $this->db->prepare('SELECT id, id_post, author, content, DATE_FORMAT(comment_date, "%d/%m/%Y") AS date_fra FROM comments WHERE id_post = ? ORDER BY comment_date DESC');
        $comments->execute(array($id_post));

        return $comments;
    }

    public function getAllComments() {
        $comments = $this->db->query('SELECT id, id_post, author, content, DATE_FORMAT(comment_date, "%d/%m/%Y %H:%i:%s") AS date_fr FROM comments ORDER BY comment_date DESC');
        return $comments;
    }

    // ajoute un nouveau commentaire dans la table comments en fonction de l'ID du post
    public function postComment($postId, $author, $content)
    {
        $comments = $this->db->prepare('INSERT INTO comments(id_post, author, content, comment_date) VALUES(?, ?, ?, NOW())');
        $req = $comments->execute(array($postId, $author, $content));

        return $req;
    }

     // supprime un commentaire dans la table comments en fonction de son ID
    public function deleteComment($commentId) {
        $req = $this->db->prepare('DELETE FROM comments WHERE id = ?');
        $deletedComment = $req->execute(array($commentId));

        return $deletedComment;
    }
}