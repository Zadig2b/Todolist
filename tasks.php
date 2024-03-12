<?php
include 'config.php';

function createTask($title, $description, $importance, $echeance) {
    global $pdo;
    $formattedDate = date('Y-m-d', strtotime($echeance));
    $stmt = $pdo->prepare('INSERT INTO tasks (title, description, importance, echeance) VALUES (?, ?, ?, ?)');
    $stmt->execute([$title, $description, $importance, $formattedDate]);
}


function getTasks() {
    global $pdo;
    $stmt = $pdo->query('SELECT * FROM tasks');
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function updateTask($taskId, $title, $description, $importance, $echeance) {
    global $pdo;
    $stmt = $pdo->prepare('UPDATE tasks SET title = ?, description = ?, importance = ?, echeance = ? WHERE id = ?');
    $stmt->execute([$title, $description, $importance, $echeance, $taskId]);
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
