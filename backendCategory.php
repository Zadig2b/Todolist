<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');

include 'config.php';
include './src/repository/CategoryRepository.php';

// Instantiate CategoryRepository
$categoryRepository = new Category($pdo);

if (isset($_GET['action'])) {
    $action = $_GET['action'];

    switch ($action) {
        case 'createCategory':
            $data = json_decode(file_get_contents('php://input'), true);
            
            if (isset($data['name'], $data['img'])) {
                // Log received data
                error_log('Received data for creating category: ' . json_encode($data));
        
                $categoryRepository->createCategory($data['name'], $data['img']); 
                $newCategoryId = $pdo->lastInsertId();  
                $newCategory = $categoryRepository->getCategoryById($newCategoryId); 
                
                if ($newCategory) {
                    // Log successful creation
                    error_log('Category created successfully: ' . json_encode($newCategory));
                    echo json_encode(['message' => 'Category created successfully', 'category' => $newCategory]);
                } else {
                    // Log failure to retrieve newly created category
                    error_log('Failed to retrieve newly created category');
                    echo json_encode(['error' => 'Failed to retrieve newly created category']);
                }
            } else {
                // Log invalid data
                error_log('Invalid data for creating category: ' . json_encode($data));
                echo json_encode(['error' => 'Invalid data for creating category']);
            }
            break;            $data = json_decode(file_get_contents('php://input'), true);
            
            if (isset($data['name'], $data['img'])) {
                $categoryRepository->createCategory($data['name'], $data['img']); 
                $newCategoryId = $pdo->lastInsertId();  
                $newCategory = $categoryRepository->getCategoryById($newCategoryId); 
                echo json_encode(['message' => 'Category created successfully', 'category' => $newCategory]);
            } else {
                echo json_encode(['error' => 'Invalid data for creating category']);
            }
            break;
        

        case 'updateCategory':
            $data = json_decode(file_get_contents('php://input'), true);
        
            if (isset($data['categoryId'], $data['name'])) {
                $categoryId = $data['categoryId'];
                $name = $data['name'];
        
                if ($categoryRepository->updateCategory($categoryId, $name)) {
                    echo json_encode(['message' => 'Category updated successfully']);
                } else {
                    echo json_encode(['error' => 'Failed to update category']);
                }
            } else {
                echo json_encode(['error' => 'Invalid data for updating category']);
            }
            break;

        case 'deleteCategory':
            if (isset($_GET['categoryId'])) {
                $categoryId = $_GET['categoryId'];
                if ($categoryRepository->deleteCategory($categoryId)) {
                    echo json_encode(['success' => true, 'message' => 'Category deleted successfully']);
                } else {
                    echo json_encode(['success' => false, 'error' => 'Failed to delete category']);
                }
            }
            break;

        case 'fetchCategories':
            $categories = $categoryRepository->getCategories();
            echo json_encode($categories);
            break;

        default:
            echo json_encode(['error' => 'Invalid action']);
            break;
    }
} else {
    echo json_encode(['error' => 'Action parameter not set']);
}
?>
