<?php

session_start();
if (!isset($_SESSION['user_email'])){
    header("Location: login.php");
    exit();
}
echo "Hello {$_SESSION['user_email']}";
session_unset();
session_destroy();