<?php
require_once '../config/database.php';

// GET semua tugas
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $result = $conn->query("SELECT * FROM todo_list");
    echo json_encode($result->fetch_all(MYSQLI_ASSOC));
}

// POST untuk menambah tugas
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    $stmt = $conn->prepare("INSERT INTO todo_list (task_name, description) VALUES (?, ?)");
    $stmt->bind_param("ss", $data['task_name'], $data['description']);
    $stmt->execute();
    echo json_encode(["message" => "Task added successfully"]);
}

// PUT untuk mengedit tugas
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $data = json_decode(file_get_contents("php://input"), true);
    $stmt = $conn->prepare("UPDATE todo_list SET task_name = ?, description = ?, status = ? WHERE id = ?");
    $stmt->bind_param("sssi", $data['task_name'], $data['description'], $data['status'], $data['id']);
    $stmt->execute();
    echo json_encode(["message" => "Task updated successfully"]);
}

// DELETE untuk menghapus tugas
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $data = json_decode(file_get_contents("php://input"), true);
    $stmt = $conn->prepare("DELETE FROM todo_list WHERE id = ?");
    $stmt->bind_param("i", $data['id']);
    $stmt->execute();
    echo json_encode(["message" => "Task deleted successfully"]);
}
?>
