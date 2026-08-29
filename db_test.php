<?php

try {
    $pdo = new PDO(
        'mysql:host=127.0.0.1;port=3306;dbname=board_db;charset=utf8mb4',
        'board_user',
        'board_pass123'
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "DB接続成功";
} catch (PDOException $e) {
    echo "DB接続失敗: " . $e->getMessage();
}
