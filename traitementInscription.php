<?php

require_once 'config.php';
require_once './src/repository/UserRepository.php';

class Traitement {
    
    public static function traiterDonnees($pdo) {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $errors = self::validateFormData($_POST);

            if (empty($errors)) {
                $userRepository = new User($pdo);
                
                // Creation de l'utilisateur dans la base de données
                $result = $userRepository->createUser($_POST['nom'], $_POST['prenom'], $_POST['motDePasse'], $_POST['email']);

                if ($result) {
                    $email = $_POST["email"] ?? "";
                    $password = $_POST["motDePasse"] ?? "";
                    $user = $userRepository->getUserByEmailAndPassword($email, $password);
                    if ($user) {
                        session_start();
                 // Démarrage de la session
                        $_SESSION['user_id'] = $user['id'];
                 // Stockage de l'ID de l'utilisateur dans la session
                        header("Location: connected.php");
                        exit(); 
            
                    } else {
                        $_SESSION['error_message'] = "échec de la connexion utilisateur";
                        header("Location: index.php");
                        exit();
                    }
                } else {
                    $errors[] = "Une erreur s'est produite lors de la création de l'utilisateur. Veuillez réessayer.";
                }
            } else {
                header("Location: index.php?signup=0");
                exit(); 
            }
        }

        // affiche les erreurs 
        foreach ($errors as $error) {
            echo '<div class="alert alert-danger" role="alert">' . $error . '</div>';
        }
    }

    private static function validateFormData($formData) {
        $errors = array();

        // Validate email
        $email = filter_var($formData['email'], FILTER_SANITIZE_EMAIL);
        if (empty($email)) {
            $errors[] = "Le champ Email est requis.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) < 3 || strlen($email) > 80) {
            $errors[] = "L'adresse e-mail n'est pas valide.";
        }

        // Validate password
        if (strlen($formData['motDePasse']) < 7) {
            $errors[] = "Le mot de passe doit contenir au moins 7 caractères.";
        }

        // Validate nom
        if (empty($formData['nom'])) {
            $errors[] = "Le champ Nom est requis.";
        } elseif (strlen($formData['nom']) < 3 || strlen($formData['nom']) > 50) {
            $errors[] = "Le champ Nom doit contenir entre 3 et 50 caractères.";
        }

        // Validate prenom
        if (!empty($formData['prenom']) && (strlen($formData['prenom']) < 3 || strlen($formData['prenom']) > 50)) {
            $errors[] = "Le champ Prénom doit contenir entre 3 et 50 caractères.";
        }

        return $errors;
    }
}

Traitement::traiterDonnees($pdo);

?>
