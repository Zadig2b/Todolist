<?php
require_once 'config.php';
require_once './src/repository/UserRepository.php';

class TraitementConnexion {
    
    public static function connectUser($userId) {
        global $pdo;
        $userRepository = new User($pdo);
        $user = $userRepository->getUserById($userId);

        if ($user) {
            session_start();

            // stocke l'ID de l'utilisateur dans la session
            $_SESSION['user_id'] = $userId;

            // L'utilisateur est connecté avec succès
            // Maintenant, récupérez les tâches de l'utilisateur
            header("Location: index.php");

            $tasks = getTasksByUserId($userId);
            return $tasks;
        } else {
            // Erreur lors de la récupération de l'utilisateur
            return false;
        }
    }
}
?>
