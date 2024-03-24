<?php
session_start();
include './config.php';
include './src/repository/tasksRepository.php';
include './src/repository/userRepository.php';

// Vérifiez s'il y a un message d'erreur dans la session
$error_message = isset($_SESSION['error_message']) ? $_SESSION['error_message'] : '';
// Vérifiez si l'utilisateur est connecté
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '';

//Si l'utilisateur est connecté, récupère les tâches pour l'utilisateur connecté
if ($user_id) {
    $tasksRepository = new TaskRepository($pdo);
    $tasks = $tasksRepository->getTasksByUserId($user_id);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<body>

<?php include './public/navbarConnected.php'; ?>
<div id="list">
<h1>Liste des tâches</h1>
<ul class="list-group" id="taskList">
</ul></div>
<div id="TaskformDiv">
<?php include './public/taskCreationForm.php'; ?>
</div>
<div id="CatformDiv">
<?php include './public/CategoryCreationForm.php'; ?>
</div>
<?php include './public/modal.php'; ?>
<div id="toastContainer" class="toast position-fixed bottom-0 end-0 p-3">
    <div class="toast-body"></div>
</div>
</body>
</html>
<script src="script.js"></script>
<script src="user.js"></script>
<script src="fetchCategory.js"></script>

