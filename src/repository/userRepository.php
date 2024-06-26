<?php

class User
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function createUser($nom, $prenom, $motDePasse, $email)
    {
        try {
            $stmt = $this->pdo->prepare("INSERT INTO todolist_user (Nom, Prénom, Mot_de_passe, Email) VALUES (?, ?, ?, ?)");        
            $stmt->execute([$nom, $prenom, $motDePasse, $email]);
            return true;
        } catch (PDOException $e) {
            echo "Erreur lors de la création de l'utilisateur : " . $e->getMessage();
            return false;
        }
    }

    public function updateUser($nom, $prenom, $email, $userId)
{
    try {
        $stmt = $this->pdo->prepare("UPDATE todolist_user SET Nom = ?, Prénom = ?, Email = ? WHERE id = ?");
        $stmt->execute([$nom, $prenom, $email, $userId]);
        return true;
    } catch (PDOException $e) {
        echo "Erreur lors de la mise à jour de l'utilisateur : " . $e->getMessage();
        return false;
    }
}

    public function deleteUser($userId)
    {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM todolist_user WHERE id = ?");
            $stmt->execute([$userId]);
            return true;
        } catch (PDOException $e) {
            echo "Erreur lors de la suppression de l'utilisateur : " . $e->getMessage();
            return false;
        }
    }

    public function getUserById($userId){
        try{
            $stmt = $this->pdo->prepare("SELECT * FROM todolist_user WHERE id = ?");
            $stmt->execute([$userId]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            return $user;
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération de l'utilisateur : " . $e->getMessage();
            return false;
        }
    }

    public function getUserByEmailAndPassword($email, $password) {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM todolist_user WHERE Email = ? AND Mot_de_passe = ?");
            $stmt->execute([$email, $password]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            return $user;
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération de l'utilisateur : " . $e->getMessage();
            return false;
        }
    }
    public function getUserInfoById($userId) {
        try {
            $stmt = $this->pdo->prepare("SELECT Nom, Prénom, mot_de_passe, Email FROM todolist_user WHERE Id = ?");
            $stmt->execute([$userId]);
            $userInfo = $stmt->fetch(PDO::FETCH_ASSOC);
            return $userInfo;
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération des informations de l'utilisateur : " . $e->getMessage();
            return false;
        }
    }
}

