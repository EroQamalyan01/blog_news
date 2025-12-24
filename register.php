<?php
session_start();
require_once 'classes.php';

$db = new Database();
$conn = $db->getConnection();
$userObj = new User($conn);

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    if($userObj->register($username, $email, $password)) {
        echo "Գրանցումը հաջողվեց, հիմա կարող եք <a href='login.php'>մուտք գործել</a>։";
    } else {
        echo "Սխալ գրանցման ժամանակ։";
    }
}
?>

<div class="container">
<h2>Գրանցվել</h2>
<form method="POST">
<input type="text" name="username" placeholder="Անուն" required>
<input type="email" name="email" placeholder="Email" required>
<input type="password" name="password" placeholder="Գաղտնաբառ" required>
<button type="submit">Գրանցվել</button>
</form>
</div>