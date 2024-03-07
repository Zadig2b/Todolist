<?php
include 'config.php';

function createTask($title, $description, $importance) {
    global $pdo;
    $stmt = $pdo->prepare('INSERT INTO tasks (title, description, importance) VALUES (?, ?, ?)');
    $stmt->execute([$title, $description, $importance]);
}

function getTasks() {
    global $pdo;
    $stmt = $pdo->query('SELECT * FROM tasks');
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function updateTask($taskId, $title, $description, $importance) {
    global $pdo;
    $stmt = $pdo->prepare('UPDATE tasks SET title = ?, description = ?, importance = ? WHERE id = ?');
    $stmt->execute([$title, $description, $importance, $taskId]);
}

function deleteTask($taskId) {
    global $pdo;
    $stmt = $pdo->prepare('DELETE FROM tasks WHERE id = ?');
    $stmt->execute([$taskId]);
}

function getTaskById($taskId) {
    global $pdo;
    $stmt = $pdo->prepare('SELECT * FROM tasks WHERE id = ?');
    $stmt->execute([$taskId]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
