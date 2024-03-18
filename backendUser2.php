<?php
require_once 'config.php';
require_once './src/repository/UserRepository.php';

// Vérifiez si une action est spécifiée dans la requête
if (isset($_GET['action'])) {
    // Exécutez l'action appropriée en fonction de ce qui est demandé
    switch ($_GET['action']) {
        case 'fetchUserById':
            // Vérifiez si l'ID de l'utilisateur est spécifié dans la requête
            if (isset($_GET['userId'])) {
                // Récupérez l'ID de l'utilisateur à partir de la requête
                $userId = $_GET['userId'];

                // Créez une instance du référentiel d'utilisateurs
                $userRepository = new User($pdo);

                // Récupérez les informations de l'utilisateur par son ID
                $user = $userRepository->getUserById($userId);

                // Vérifiez si l'utilisateur existe
                if ($user) {
                    // Retournez les informations de l'utilisateur au format JSON
                    echo json_encode($user);
                } else {
                    // Retournez une erreur si l'utilisateur n'existe pas
                    echo json_encode(['error' => 'Utilisateur non trouvé']);
                }
            } else {
                // Retournez une erreur si l'ID de l'utilisateur n'est pas spécifié
                echo json_encode(['error' => 'ID utilisateur non spécifié']);
            }
            break;
        default:
            // Retournez une erreur si l'action demandée n'est pas valide
            echo json_encode(['error' => 'Action non valide']);
            break;
    }
} else {
    // Retournez une erreur si aucune action n'est spécifiée dans la requête
    echo json_encode(['error' => 'Aucune action spécifiée']);
}
?>