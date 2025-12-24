<?php
include "config/db.php";
if(!isset($_SESSION['user_id'])) header("Location: auth/login.php");
?>
<link rel="stylesheet" href="style.css">
<div class="container">
<h2>Dashboard</h2>
<a href="news/add_category.php">Ավելացնել թեմա</a><br><br>
<a href="news/add_news.php">Ավելացնել նորություն</a><br><br>
<a href="auth/logout.php">Դուրս գալ</a>
</div>