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
            // Préparer la requête SQL pour insérer un nouvel utilisateur
            $stmt = $this->pdo->prepare("INSERT INTO todolist_user (Nom, Prénom, Mot_de_passe, Email) VALUES (?, ?, ?, ?)");
            
            // Exécuter la requête avec les valeurs fournies
            $stmt->execute([$nom, $prenom, $motDePasse, $email]);

            // Retourner vrai si l'insertion a réussi
            return true;
        } catch (PDOException $e) {
            // En cas d'erreur, afficher un message d'erreur et retourner faux
            echo "Erreur lors de la création de l'utilisateur : " . $e->getMessage();
            return false;
        }
    }

    public function updateUser($userId, $nom, $prenom, $email)
    {
        try {
            // Préparer la requête SQL pour mettre à jour l'utilisateur
            $stmt = $this->pdo->prepare("UPDATE todolist_user SET Nom = ?, Prénom = ?, Email = ? WHERE Id = ?");

            // Exécuter la requête avec les valeurs fournies
            $stmt->execute([$nom, $prenom, $email, $userId]);

            // Retourner vrai si la mise à jour a réussi
            return true;
        } catch (PDOException $e) {
            // En cas d'erreur, afficher un message d'erreur et retourner faux
            echo "Erreur lors de la mise à jour de l'utilisateur : " . $e->getMessage();
            return false;
        }
    }
    public function deleteUser($userId)
    {
        try {
            // Préparer la requête SQL pour supprimer l'utilisateur
            $stmt = $this->pdo->prepare("DELETE FROM todolist_user WHERE Id = ?");

            // Exécuter la requête avec l'ID de l'utilisateur
            $stmt->execute([$userId]);

            // Retourner vrai si la suppression a réussi
            return true;
        } catch (PDOException $e) {
            // En cas d'erreur, afficher un message d'erreur et retourner faux
            echo "Erreur lors de la suppression de l'utilisateur : " . $e->getMessage();
            return false;
        }
    }

    public function getUserById($userId){
        try{
            // Préparer la requête SQL pour récupérer l'utilisateur
            $stmt = $this->pdo->prepare("SELECT * FROM todolist_user WHERE Id = ?");

            // Exécuter la requête avec l'ID de l'utilisateur
            $stmt->execute([$userId]);

            // Récupérer les données de l'utilisateur
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Retourner l'utilisateur
            return $user;
        } catch (PDOException $e) {
            // En cas d'erreur, afficher un message d'erreur et retourner faux
            echo "Erreur lors de la récupération de l'utilisateur : " . $e->getMessage();
            return false;
        }
    }
}

