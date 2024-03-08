<?php
header('Content-Type: application/json');

include 'config.php';
include 'tasks.php';

if (isset($_GET['action'])) {
    $action = $_GET['action'];

    switch ($action) {
        case 'createTask':
            $data = json_decode(file_get_contents('php://input'), true);
        
            if (isset($data['title'], $data['description'], $data['importance'])) {
                createTask($data['title'], $data['description'], $data['importance']);
                $newTaskId = $pdo->lastInsertId();  
                $newTask = getTaskById($newTaskId); 
                echo json_encode(['message' => 'Task created successfully', 'task' => $newTask]);
            } else {
                echo json_encode(['error' => 'Invalid data for creating task']);
            }
            break;
        
        

        case 'fetchTasks':
            $tasks = getTasks();
            echo json_encode($tasks);
            break;
        default:
            echo json_encode(['error' => 'Invalid action']);
    }
} else {
    echo json_encode(['error' => 'Action parameter not set']);
}
?>
