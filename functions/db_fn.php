<?php 

$dbHost = "localhost";
$dbUser = "root";
$dbPassword = "";
$dbName = "vpidb";

try {

    $con = new PDO("mysql:host=$dbHost;dbname=$dbName",$dbUser,$dbPassword);

} catch (\Throwable $th) {
    echo('here');
    echo $th->getMessage();   
    
    exit(); 
}

function checkEmail($eamil){
    global $con;
    $checkEmail = $con->prepare("SELECT * from users where email = :EMAIL");
    $checkEmail->execute([":EMAIL"=>$eamil]);
    $data=$checkEmail->fetch(PDO::FETCH_OBJ);
    if(!$data){
        return true;
    }
    return false;
}

function addUser($name, $email, $password){
    global $con;
    $pass = password_hash($password, PASSWORD_DEFAULT);
    $addUser = $con->prepare("INSERT into users values (default,?,?,?)");
    $addUser->execute([strip_tags($name), $email, $pass]);
    $getUser = $con->prepare("SELECT * from users where email = :EMAIL");
    $getUser->execute([":EMAIL"=>$email]);
    return $getUser->fetch(PDO::FETCH_OBJ);
}



?>