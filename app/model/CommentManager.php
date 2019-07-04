<?php 

namespace CP\Portfolio\model;

class CommentManager extends Database {

	// recupère les commentaires d'un post en fonction de son ID + pagination
    public function getComments($id_post, $cPage, $commentsPerPage)
    {
        $comments = $this->db->prepare("SELECT comments.id AS id, id_post, members.pseudo AS author, content, DATE_FORMAT(comment_date, '%d/%m/%Y %H:%i:%s') AS date_fra FROM comments LEFT JOIN members ON members.id = comments.id_member WHERE id_post = ? ORDER BY comment_date DESC LIMIT ".intval($cPage).", ".intval($commentsPerPage));
        $comments->execute(array($id_post));
        $commentList = array();
        $className = "Comment";
        while($line = $comments->fetch(PDO::FETCH_ASSOC)) {
            $comment = new $className();
            $comment->hydrate($line);
            $commentList[] = $comment;
        }
        var_dump($commentList);

        return $commentList;
    }

    public function getAllComments() {
        $comments = $this->db->query('SELECT comments.id AS id, id_post, members.pseudo AS author, content, DATE_FORMAT(comment_date, "%d/%m/%Y %H:%i:%s") AS date_fr FROM comments LEFT JOIN members ON members.id = comments.id_member ORDER BY comment_date DESC');
        return $comments;
    }

    // ajoute un nouveau commentaire dans la table comments en fonction de l'ID du post
    public function postComment($postId, $author, $content)
    {
        $comments = $this->db->prepare('INSERT INTO comments(id_post, id_member, content, comment_date) VALUES(?, ?, ?, NOW())');
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