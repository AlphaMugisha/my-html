<?php
session_start();

// fake login (no password for simplicity)
$_SESSION['user'] = "Tiger";
$_SESSION['login_time'] = time();

// session expires after 30 seconds
$_SESSION['expire'] = $_SESSION['login_time'] + 10;

header("Location: index.php");
exit();
