<?php

function getPdo(): PDO
{
    $host = '127.0.0.1';
    $port = '3306';
    $dbname = 'board_db';
    $username = 'board_user';
    $password = 'board_pass123';

    $dsn = "mysql:host={$host};port={$port};dbname={$dbname};charset=utf8mb4";

    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    return $pdo;
}
