<?php
session_start();
require_once 'classes.php';

$db = new Database();
$conn = $db->getConnection();
$userObj = new User($conn);

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $user = $userObj->login($username, $password);
    if($user) {
        $_SESSION['user'] = $user;
        header("Location: index.php");
        exit;
    } else {
        echo "Սխալ մուտքագրում։";
    }
}
?>

<form method="POST">
<input type="text" name="username" placeholder="Անուն" required><br>
<input type="password" name="password" placeholder="Գաղտնաբառ" required><br>
<button type="submit">Մուտք գործել</button>
</form>