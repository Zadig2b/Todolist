<?php
include './config.php';

class Category {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function createCategory($name, $img) {
        $stmt = $this->pdo->prepare('INSERT INTO category (name, img) VALUES (?, ?)');
        $success = $stmt->execute([$name, $img]);
    
        if ($success) {
            // Log successful insertion
            error_log('Category inserted successfully. Name: ' . $name . ', Img: ' . $img);
        } else {
            // Log insertion failure
            error_log('Failed to insert category. Name: ' . $name . ', Img: ' . $img);
        }
    }
    

    public function getCategories() {
        $stmt = $this->pdo->query('SELECT * FROM category');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateCategory($categoryId, $name) {
        $stmt = $this->pdo->prepare('UPDATE category SET name = ? WHERE id = ?');
        $stmt->execute([$name, $categoryId]);
    }

    public function deleteCategory($categoryId) {
        $stmt = $this->pdo->prepare('DELETE FROM category WHERE id = ?');
        $stmt->execute([$categoryId]);
    }

    public function getCategoryById($categoryId) {
        $stmt = $this->pdo->prepare('SELECT * FROM category WHERE id = ?');
        $stmt->execute([$categoryId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

// Instantiate CategoryRepository
$categoryRepository = new Category($pdo);
?>
