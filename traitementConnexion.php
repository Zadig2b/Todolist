<?php
require_once 'config.php';
require_once './src/repository/UserRepository.php';

class TraitementConnexion {
    
    public static function connectUser($userId) {
        global $pdo;
        $userRepository = new User($pdo);
        $user = $userRepository->getUserById($userId);

        if ($user) {
            // L'utilisateur est connecté avec succès
            // Maintenant, récupérez les tâches de l'utilisateur
            $tasks = getTasksByUserId($userId);
            return $tasks;
        } else {
            // Erreur lors de la récupération de l'utilisateur
            return false;
        }
    }
}

?>
