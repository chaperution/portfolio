<?php

namespace CP\Portfolio\model;

class Pagination extends Database {

	// recupère le nb de posts contenu dans la table posts
	public function getCommentsPagination($postId) {
        $totalComments = $this->db->prepare('SELECT COUNT(id) AS nbComments FROM comments WHERE id_post = :postId');
   		$totalComments->execute(array('postId' => $postId));
        return $totalComments->fetch()['nbComments'];
    }

    // défini le nombre de pages
    public function getCommentsPages($nbComments , $commentsPerPage) {  
        $nbPage = ceil($nbComments/$commentsPerPage);

        return $nbPage;
    }
}