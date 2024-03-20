<?php
require_once 'config.php';
require_once './src/repository/UserRepository.php';
session_start();

// Check if an action is specified in the request
if (isset($_GET['action'])) {
    // Execute the appropriate action based on what is requested
    switch ($_GET['action']) {
        case 'fetchUserById':
            // Check if the user ID is specified in the session
            if (isset($_SESSION['user_id'])) {
                // Retrieve the user ID from the session
                $userId = $_SESSION['user_id'];

                // Create an instance of the user repository
                $userRepository = new User($pdo);

                // Retrieve user information by user ID
                $user = $userRepository->getUserById($userId);

                // Check if the user exists
                if ($user) {
                    // Return the user information as JSON
                    echo json_encode($user);
                } else {
                    // Return an error if the user does not exist
                    echo json_encode(['error' => 'User not found']);
                }
            } else {
                // Return an error if the user ID is not specified
                echo json_encode(['error' => 'User ID not specified']);
            }
            break;
        case 'createTaskUserId':
            // Check if the user ID is set in the session
            if (isset($_SESSION['user_id'])) {
                // Retrieve the user ID from the session
                $userId = $_SESSION['user_id'];

                // Return the user ID as JSON data
                echo json_encode(['userId' => $userId]);
            } else {
                // If the user ID is not set in the session, return an error
                echo json_encode(['error' => 'User ID not found in session']);
            }
            break;
        default:
            // Return an error if the requested action is not valid
            echo json_encode(['error' => 'Invalid action']);
            break;
    }
} else {
    // Return an error if no action is specified in the request
    echo json_encode(['error' => 'No action specified']);
}

?>