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

    // recherche dans la table members si le pseudo est déjà existant
    public function checkPseudo($pseudo) {
		$req = $this->db->prepare('SELECT pseudo FROM members WHERE pseudo = ?');
		$req->execute(array($pseudo));
		$usernameValidity = $req->fetch();

		return $usernameValidity;
	}

    // recherche dans la table members si le mail est déjà existant
	public function checkMail($mail) {
		$req = $this->db->prepare('SELECT mail FROM members WHERE mail = ?');
		$req->execute(array($mail));
		$mailValidity = $req->fetch();

		return $mailValidity;
	}
}