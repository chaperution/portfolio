<?php 

namespace CP\Portfolio\model;

class MemberManager extends Database {

	// permet la connexion d'un membre en recherchant par son pseudo enregistré dans la table members
    public function loginMember($pseudo)
    {
        $req = $this->db->prepare('SELECT id, pass FROM members WHERE pseudo = ?');
        $req->execute(array($pseudo));
        $member = $req->fetch();

        return $member;
    }

    // créée un nouveau membre dans la table en enregistrant son pseudo, son mdp et son mail
    public function createMember($pseudo, $pass, $mail)
    {
        $newMember = $this->db->prepare('INSERT INTO members(pseudo, pass, mail, subscribe_date) VALUES (?, ?, ?, CURDATE())');
        $newMember->execute(array($pseudo, $pass, $mail));

        return $newMember;
    }	
}