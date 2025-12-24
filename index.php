<?php
session_start();
require_once 'classes.php';

$db = new Database();
$conn = $db->getConnection();

$newsObj = new News($conn);
$allNews = $newsObj->getAllNews();
?>

<!DOCTYPE html>
<html lang="hy">
<head>
<meta charset="UTF-8">
<title>Նորությունների կայք</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
<h1>Նորություններ</h1>

<?php if(isset($_SESSION['user'])): ?>
<p>Բարև, <?= htmlspecialchars($_SESSION['user']['username']) ?>! <a href="logout.php">Ելք</a></p>
<a href="add_news.php">Ավելացնել նորություն</a>
<?php else: ?>
<p><a href="register.php">Գրանցվել</a> | <a href="login.php">Մուտք</a></p>
<?php endif; ?>

<hr>

<?php foreach($allNews as $news): ?>
<div class="news-item">
    <h2><?= htmlspecialchars($news['title']) ?></h2>
    <p><?= nl2br(htmlspecialchars($news['content'])) ?></p>
    <small>Հեղինակ: <?= htmlspecialchars($news['username']) ?> | <?= $news['created_at'] ?></small>
</div>
<hr>
<?php endforeach; ?>
</div>
</body>
</html>