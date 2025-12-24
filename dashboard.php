<?php
session_start();
if(!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

require_once 'classes.php';
$db = new Database();
$conn = $db->getConnection();
$user_id = $_SESSION['user']['id'];

// Ջնջել նորություն
if(isset($_GET['delete'])) {
    $news_id = (int)$_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM news WHERE id=:id AND author_id=:author_id");
    $stmt->bindParam(':id', $news_id);
    $stmt->bindParam(':author_id', $user_id);
    $stmt->execute();
    header("Location: dashboard.php");
    exit;
}

// Օգտատիրոջ բոլոր նորությունները
$stmt = $conn->prepare("SELECT * FROM news WHERE author_id=:author_id ORDER BY created_at DESC");
$stmt->bindParam(':author_id', $user_id);
$stmt->execute();
$myNews = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container">
<h1>Իմ նորությունները</h1>
<a href="index.php">Գլխավոր էջ</a> | <a href="add_news.php">Ավելացնել նորություն</a> | <a href="logout.php">Ելք</a>
<hr>

<?php if(count($myNews) == 0): ?>
<p>Դեռ ոչ մի նորություն չեք ավելացրել։</p>
<?php else: ?>
<?php foreach($myNews as $news): ?>
<div class="news-item">
    <h2><?= htmlspecialchars($news['title']) ?></h2>
    <p><?= nl2br(htmlspecialchars($news['content'])) ?></p>
    <small>Ստեղծվել է: <?= $news['created_at'] ?></small><br>
    <a href="dashboard.php?delete=<?= $news['id'] ?>" onclick="return confirm('Ջնջե՞լ այս նորությունը?')">Ջնջել</a>
</div>
<hr>
<?php endforeach; ?>
<?php endif; ?>
</div>