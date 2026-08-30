<?php
session_start();
require_once __DIR__ . '/db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? '';

    $pdo = getPdo();

    $stmt = $pdo->prepare('SELECT id, user_id FROM posts WHERE id = :id');
    $stmt->execute(['id' => $id]);
    $post = $stmt->fetch();

    if (!$post || $post['user_id'] !== $_SESSION['user_id']) {
        header('Location: index.php');
        exit;
    }

    $stmt = $pdo->prepare('DELETE FROM posts WHERE id = :id');
    $stmt->execute(['id' => $id]);

    header('Location: index.php');
    exit;
}

header('Location: index.php');
exit;
