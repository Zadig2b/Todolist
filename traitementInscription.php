<?php
require_once 'config.php';
require_once './src/repository/UserRepository.php';

session_start();

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Initialiser un tableau pour stocker les erreurs
    $errors = array();

    // Récupérer et valider les données du formulaire
    $nom = htmlspecialchars($_POST['nom']);
    $prenom = htmlspecialchars($_POST['prenom']);
    $motDePasse = htmlspecialchars($_POST['motDePasse']);
    $email = htmlspecialchars($_POST['email']);
    
    // Valider l'e-mail
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    if (empty($email)) {
    $errors[] = "Le champ Email est requis.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) < 3 || strlen($email) > 80) {
    $errors[] = "L'adresse e-mail n'est pas valide.";
    }


    // Valider la longueur du mot de passe
    if (strlen($motDePasse) < 7) {
        $errors[] = "Le mot de passe doit contenir au moins 7 caractères.";
    }

// Valider le nom
if (empty($nom)) {
    $errors[] = "Le champ Nom est requis.";
} elseif (strlen($nom) < 3 || strlen($nom) > 50) {
    $errors[] = "Le champ Nom doit contenir entre 3 et 50 caractères.";
}
// Valider le prénom
if (strlen($prenom) > 0 && (strlen($prenom) < 3 || strlen($prenom) > 50)) {
    $errors[] = "Le champ Prénom doit contenir entre 3 et 50 caractères.";
}
    // TODO: Vous pouvez ajouter des validations supplémentaires ici, par exemple pour le format de l'e-mail, la longueur du mot de passe, etc.

    // Si aucune erreur n'est détectée, ajouter l'utilisateur à la base de données
    if (empty($errors)) {
        // Créer une instance de UserRepository
        $userRepository = new User($pdo);

        // Créer un nouvel utilisateur dans la base de données
        $result = $userRepository->createUser($nom, $prenom, $motDePasse, $email);

        // Vérifier si l'opération d'ajout de l'utilisateur a réussi
        if ($result) {
            // Rediriger l'utilisateur vers une page de succès ou afficher un message de réussite
            header("Location: inscription_success.php");
            exit();
        } else {
            // Afficher un message d'erreur en cas d'échec de l'ajout de l'utilisateur
            $errors[] = "Une erreur s'est produite lors de la création de l'utilisateur. Veuillez réessayer.";
        }
    }
}

// Si des erreurs sont présentes, les afficher dans le formulaire
if (!empty($errors)) {
    // afficher les erreurs dans le formulaire
}
?>
