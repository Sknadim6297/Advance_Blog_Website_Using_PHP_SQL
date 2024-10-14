<?php
session_start();


session_unset();


session_destroy();


if (isset($_COOKIE['login_username'])) {
    setcookie("login_username", "", time() - 3600, "/");
}

if (isset($_COOKIE['login_id'])) {
    setcookie("login_id", "", time() - 3600, "/");
}
header('location:../Home.php');
exit;
