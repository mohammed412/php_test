<?php
session_start();
require('functions/db_fn.php');

if (!isset($_SESSION['user'])) {
    header('Location:login.php', true);
}
echo "we are here";
$id = $_GET['id'];
$query = $con->prepare("DELETE from article where id = :id");
if($query->execute([":id"=>$id]))
    header("Location:articles.php", true);

?>