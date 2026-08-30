<?php
session_start();
require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $content = $_POST['content'] ?? '';
    $error = validatePostContent($content);

    if ($error !== '') {
        $_SESSION['error'] = $error;
        header('Location: post.php');
        exit;
    }

    $pdo = getPdo();

    $stmt = $pdo->prepare('INSERT INTO posts (user_id, content) VALUES (:user_id, :content)');
    $stmt->execute([
        'user_id' => $_SESSION['user_id'],
        'content' => $content,
    ]);

    header('Location: index.php');
    exit;
}

header('Location: post.php');
exit;
