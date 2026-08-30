<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$error = $_SESSION['error'] ?? '';
unset($_SESSION['error']);
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>新規投稿</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <h1>新規投稿</h1>

        <?php if ($error !== ''): ?>
            <p class="error-message"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>

        <form action="post_process.php" method="post">
            <textarea name="content" rows="5" placeholder="投稿内容を入力"></textarea>
            <button type="submit">投稿する</button>
        </form>

        <a href="index.php">一覧に戻る</a>
    </div>
</body>

</html>
