<?php
if (!isset($_SESSION['user'])) {
    header('Location:login.php');
}

session_start();
session_unset();
session_destroy();

header('Location:login.php', true);

?>