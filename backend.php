<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');

include 'config.php';
include 'tasks.php';

if (isset($_GET['action'])) {
    $action = $_GET['action'];

    switch ($action) {
        case 'createTask':
            $data = json_decode(file_get_contents('php://input'), true);
        
            if (isset($data['title'], $data['description'], $data['importance'], $data['echeance'])) {
                createTask($data['title'], $data['description'], $data['importance'], $data['echeance']);
                $newTaskId = $pdo->lastInsertId();  
                $newTask = getTaskById($newTaskId); 
                echo json_encode(['message' => 'Task created successfully', 'task' => $newTask]);
            } else {
                echo json_encode(['error' => 'Invalid data for creating task']);
            }
            break;
        
            case 'updateTask':
                $data = json_decode(file_get_contents('php://input'), true);
            
                if (isset($data['taskId'], $data['newData'])) {
                    $taskId = $data['taskId'];
                    $newData = $data['newData'];
            
                    // Extract individual fields from newData
                    $title = $newData['title'] ?? null;
                    $description = $newData['description'] ?? null;
                    $importance = $newData['importance'] ?? null;
                    $echeance = $newData['echeance'] ?? null;
            
                    if (updateTask($taskId, $title, $description, $importance, $echeance)) {
                        echo json_encode(['message' => 'Task updated successfully']);
                    } else {
                        echo json_encode(['error' => 'Failed to update task']);
                    }
                } else {
                    echo json_encode(['error' => 'Invalid data for updating task']);
                }
                break;
            

            case 'getTaskDetails':
                if (isset($_GET['taskId'])) {
                    $taskId = $_GET['taskId'];
                    $taskDetails = getTaskById($taskId);
                    echo json_encode($taskDetails);
                } else {
                    echo json_encode(['error' => 'Task ID not provided']);
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
