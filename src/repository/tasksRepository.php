<?php
include './config.php';

class TaskRepository {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function createTask($title, $description, $importance, $echeance, $userId) {
        $formattedDate = date('Y-m-d', strtotime($echeance));
        $stmt = $this->pdo->prepare('INSERT INTO tasks (title, description, importance, echeance, id_utilisateur ) VALUES (?, ?, ?, ?, ?)');
        $stmt->execute([$title, $description, $importance, $formattedDate, $userId]);
    }

    public function getTasks() {
        $stmt = $this->pdo->query('SELECT * FROM tasks');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateTask($taskId, $title, $description, $importance, $echeance) {
        $stmt = $this->pdo->prepare('UPDATE tasks SET title = ?, description = ?, importance = ?, echeance = ? WHERE id = ?');
        $stmt->execute([$title, $description, $importance, $echeance, $taskId]);
    }

    public function deleteTask($taskId) {
        $stmt = $this->pdo->prepare('DELETE FROM tasks WHERE id = ?');
        $stmt->execute([$taskId]);
    }

    public function getTaskById($taskId) {
        $stmt = $this->pdo->prepare('SELECT * FROM tasks WHERE id = ?');
        $stmt->execute([$taskId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getTasksByUserId($userId) {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM tasks WHERE id_utilisateur = ?");
            $stmt->execute([$userId]);
            $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $tasks;
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération des tâches de l'utilisateur : " . $e->getMessage();
            return false;
        }
    }
}

// Instantiate TaskRepository
$taskRepository = new TaskRepository($pdo);
?>
