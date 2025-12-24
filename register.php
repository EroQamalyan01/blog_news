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
        echo "Գրանցումը հաջողվեց, հիմա կարող եք մուտք գործել։";
    } else {
        echo "Սխալ գրանցման ժամանակ։";
    }
}
?>

<form method="POST">
<input type="text" name="username" placeholder="Անուն" required><br>
<input type="email" name="email" placeholder="Email" required><br>
<input type="password" name="password" placeholder="Գաղտնաբառ" required><br>
<button type="submit">Գրանցվել</button>
</form>