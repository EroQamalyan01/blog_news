<?php
session_start();
if(!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

require_once 'classes.php';
$db = new Database();
$conn = $db->getConnection();
$newsObj = new News($conn);

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $author_id = $_SESSION['user']['id'];
    if($newsObj->addNews($title, $content, $author_id)) {
        header("Location: index.php");
        exit;
    } else {
        echo "Սխալ նորություն ավելացնելիս։";
    }
}
?>

<form method="POST">
<input type="text" name="title" placeholder="Վերնագիր" required><br>
<textarea name="content" placeholder="Բովանդակություն" required></textarea><br>
<button type="submit">Ավելացնել</button>
</form>