<?php
require_once 'config.php';
require_once './src/repository/UserRepository.php';

class TraitementConnexion {
    
    public static function connectUser($email, $password) {
        global $pdo;
        $userRepository = new User($pdo);
        $user = $userRepository->getUserByEmailAndPassword($email, $password);

        if ($user) {
            session_start();

            // Store the user's ID in the session
            $_SESSION['user_id'] = $user['id'];

            // Redirect the user to index.php on successful login
            header("Location: connected.php");
            exit(); // Make sure to exit after redirecting

        } else {
            // If login fails, display a toast message
            $_SESSION['error_message'] = "Connection failed. Please check your credentials.";
            header("Location: index.php");
            exit();
        }
    }
}
// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get the email and password from the form submission
    $email = $_POST["email"] ?? "";
    $password = $_POST["motDePasse"] ?? "";

    // Call the method to process the user login
    TraitementConnexion::connectUser($email, $password);
} else {
    // If the form hasn't been submitted, redirect to index.php
    header("Location: index.php");
    exit();
}
?>
