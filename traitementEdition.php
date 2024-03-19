<?php
require_once 'config.php';
require_once './src/repository/UserRepository.php';

class TraitementEdition {
    private $userRepository;

    public function __construct($pdo) {
        $this->userRepository = new User($pdo);
    }

    public function handleFormSubmission() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Read JSON data from the request body
            $json_data = file_get_contents('php://input');
            $data = json_decode($json_data, true);

            // Access the data fields
            $nom = $data['nom'] ?? '';
            $prenom = $data['prenom'] ?? '';
            $email = $data['email'] ?? '';

            echo "<div id='returnUser'> Nom: $nom, Prénom: $prenom, Email: $email</div>";
            error_log("Received data - Nom: $nom, Prénom: $prenom, Email: $email");
            error_log('Received POST data: ' . print_r($data, true)); 

            return $this->updateUser($nom, $prenom, $email);
        } else {
            return false;
        }
    }

    private function updateUser($nom, $prenom, $email) {
        try {
            session_start();
            if (isset($_SESSION['user_id'])) {
                $userId = $_SESSION['user_id'];
                error_log("User ID: " . $userId);
                return $this->userRepository->updateUser($nom, $prenom, $email, $userId);
            } else {
                error_log("Break point");
                return false;
            }
        } catch (PDOException $e) {
            // Handle the exception or log the error
            return false;
        }
    }
}

$traitementEdition = new TraitementEdition($pdo);
$success = $traitementEdition->handleFormSubmission();

if ($success) {
    // Redirect to a success page or display a success message
    header('Location: connected.php');
    exit;
} else {
    // Handle the error
    echo "Error updating user information";
}
?>
