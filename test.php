<?php 
include_once('functions/db_fn.php');

$checkEmail = $con->prepare("insert into vpidb.users(nom, email, password) values ('Hello', 'Hello', 'Hello')" );
$checkEmail->execute();
var_dump($checkEmail);

?>