<?php
session_start();
require_once __DIR__ . '/db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$id = $_GET['id'] ?? '';

$pdo = getPdo();
$stmt = $pdo->prepare('SELECT id, user_id, content FROM posts WHERE id = :id');
$stmt->execute(['id' => $id]);
$post = $stmt->fetch();

if (!$post) {
    header('Location: index.php');
    exit;
}

if ($post['user_id'] !== $_SESSION['user_id']) {
    header('Location: index.php');
    exit;
}

$error = $_SESSION['error'] ?? '';
unset($_SESSION['error']);
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>投稿を編集</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <h1>投稿を編集</h1>

        <?php if ($error !== ''): ?>
            <p class="error-message"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>

        <form action="post_update.php" method="post">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($post['id']); ?>">
            <textarea name="content" rows="5"><?php echo htmlspecialchars($post['content']); ?></textarea>
            <button type="submit">更新する</button>
        </form>

        <a href="index.php">キャンセルして一覧に戻る</a>
    </div>
</body>

</html>