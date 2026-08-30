<?php
session_start();
require_once __DIR__ . '/db.php';

$pdo = getPdo();

$stmt = $pdo->prepare('
    SELECT posts.id, posts.content, posts.created_at, posts.user_id, users.name
    FROM posts
    JOIN users ON posts.user_id = users.id
    ORDER BY posts.created_at DESC
');
$stmt->execute();
$posts = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>掲示板</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <h1>掲示板</h1>

        <div class="header-menu">
            <?php if (isset($_SESSION['user_id'])): ?>
                <span>ようこそ、<?php echo htmlspecialchars($_SESSION['user_name']); ?>さん</span>
                <a href="post.php">新規投稿</a>
                <a href="logout.php">ログアウト</a>
            <?php else: ?>
                <a href="login.php">ログイン</a>
                <a href="register.php">会員登録</a>
            <?php endif; ?>
        </div>

        <ul class="post-list">
            <?php if (empty($posts)): ?>
                <li class="empty">まだ投稿がありません</li>
            <?php else: ?>
                <?php foreach ($posts as $post): ?>
                    <li>
                        <div class="post-header">
                            <span class="post-author"><?php echo htmlspecialchars($post['name']); ?></span>
                            <span class="post-date"><?php echo htmlspecialchars($post['created_at']); ?></span>
                        </div>
                        <p class="post-content"><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>

                        <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] === $post['user_id']): ?>
                            <div class="post-actions">
                                <a href="post_edit.php?id=<?php echo htmlspecialchars($post['id']); ?>">編集</a>
                                <form action="post_delete.php" method="post" class="delete-form">
                                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($post['id']); ?>">
                                    <button type="submit">削除</button>
                                </form>
                            </div>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            <?php endif; ?>
        </ul>
    </div>
</body>

</html>
