<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');

include 'config.php';
include './src/repository/tasksRepository.php';
$taskRepository = new TaskRepository($pdo);

if (isset($_GET['action'])) {
    $action = $_GET['action'];

    switch ($action) {
        case 'createTask':
            $data = json_decode(file_get_contents('php://input'), true);
        
            if (isset($data['title'], $data['description'], $data['importance'], $data['echeance'], $data['user_id'], $data['cat_id'])) {
                $taskId = $taskRepository->createTask($data['title'], $data['description'], $data['importance'], $data['echeance'], $data['user_id'], $data['cat_id']);
                $newTaskId = $pdo->lastInsertId();  
                $newTask = $taskRepository->getTaskById($newTaskId); 
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
            
                    if ($taskRepository->updateTask($taskId, $title, $description, $importance, $echeance)) {
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
                    $taskDetails = $taskRepository->getTaskById($taskId);
                    echo json_encode($taskDetails);
                } else {
                    echo json_encode(['error' => 'Task ID not provided']);
                }
                break;

        case 'fetchTasks':
            $tasks = $taskRepository->getTasks();
            echo json_encode($tasks);
            break;

            case 'fetchTasksByUserId':
                session_start(); 
                if (isset($_SESSION['user_id'])) {
                    $userId = $_SESSION['user_id']; 
                    $tasks = $taskRepository->getTasksByUserId($userId);
                    echo json_encode($tasks);
                } else {
                    echo json_encode(['error' => 'User ID not found in session']);
                }            
                break;
          
        default:
            echo json_encode(['error' => 'Invalid action']);

case 'deleteTask':
    if (isset($_GET['taskId'])) {
        $taskId = $_GET['taskId'];
        if ($taskRepository->deleteTask($taskId)) {
            echo json_encode(['success' => true, 'message' => 'Tâche supprimée avec succès']);
        } else {
            echo json_encode(['success' => false, 'error' => 'Failed to delete task']);
        }
    }
    break;

    }
} else {
    echo json_encode(['error' => 'Action parameter not set']);
}
?>
