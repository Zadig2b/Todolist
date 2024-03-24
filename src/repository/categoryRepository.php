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
            error_log('Catégorie insérée avec succès. Name: ' . $name . ', Img: ' . $img);
        } else {
            error_log('Échec de l\'insertion de la catégorie. Name: ' . $name . ', Img: ' . $img);
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

$categoryRepository = new Category($pdo);
?>
