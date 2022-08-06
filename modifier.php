<?php
session_start();
require('functions/db_fn.php');

if (!isset($_SESSION['user'])) {
    header('Location:login.php');
}

$errors=[];

$query = $con->prepare("SELECT * from famille");
$query->execute();
$familles = $query->fetchAll(PDO::FETCH_OBJ);

$id = $_GET['id'];
$query = $con->prepare("SELECT * from article where id = :id");
if ($query->execute([":id" => $id]))
    $article = $query->fetch(PDO::FETCH_OBJ);

if (isset($_POST["modifier"])) {

    var_dump($_POST);
    
            if (empty($_POST['libelle']))
                $errors[] = "Libelle required";
            
            $extensions = ['jpg', 'jpeg', 'png'];
            if (!in_array(strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION)), $extensions))
                $errors[] = "file should be image";

            pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $count = 1;
            $famCount = count($familles);
            foreach ($familles as $famille) {
                if ($famille->id == $_POST['id_famille']) {
                    break;
                }

                if ($count == $famCount)
                    $errors[] = "invalide famille";
                $count++;
            }
    
    if (count($errors) === 0) {
        if(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION) == ""){
            $query = $con->prepare("UPDATE article set libelle = :LIBELLE, id_famille = :ID_F WHERE id = :ID");
            if ($query->execute([":LIBELLE"=>$_POST['libelle'], ":ID_F"=> $_POST['id_famille'], ":ID"=>$article->id])) {
                header('Location:articles.php', true);
            }
        }
        else{
            unlink($article->photo);
            $filename = './images/' .time(). $_FILES['image']['name'];
        if (move_uploaded_file(strip_tags($_FILES['image']['tmp_name']), $filename)) {
            $query = $con->prepare("UPDATE article set libelle = :LIBELLE, id_famille = :ID_F, photo = :PHOTO WHERE id = :ID");

            if ($query->execute([":LIBELLE"=>$_POST['libelle'], ":PHOTO"=> $filename,":ID_F"=> $_POST['id_famille'], ":ID" => $article->id])) {
                header('Location:articles.php', true);
            }
        }}
    } else {
        foreach ($errors as $error) {
            echo '<div class="alert alert-danger" role="alert"> ' . $error . ' </div>';
        }
    }
    
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php require('partials/head.php')?>
</head>

<body>
    <div class="container">
        <?php require('partials/navbar.php') ?>
        <form method="POST" class="container d-flex flex-column" style="margin-left:200px;" enctype="multipart/form-data">
            <div class="form-group ">
                <label for="exampleInputEmail1">Libelle</label>
                <input type="text" value="<?= $article->libelle?>" name="libelle" class="form-control col-6" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Libelle">
            </div>

            <div class="form-group ">
                <label for="exampleInputEmail1">Famille</label>
                <select name="id_famille">
                    <?php
                    $stm = $con->prepare("SELECT * from famille");
                    $stm->execute();
                    $data = $stm->fetchAll(PDO::FETCH_OBJ);
                    if ($data) :
                        foreach ($data as $fm) :

                    ?>
                            
                    <?php
                        if($fm->id === $article->id_famille)
                            echo '<option selected value="'. $fm->id .'">'.$fm->nom .'</option>';
                        else
                            echo '<option value="'. $fm->id ='">'. $fm->nom .'</option>';
                        
                        endforeach;
                    endif;
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="exampleFormControlFile1">Image</label>
                <input type="file" accept="image/*" name="image" class="form-control-file" id="exampleFormControlFile1">
            </div>



            <div class="container col-12">
                <button name="modifier" type="submit" class="btn btn-primary">Ajouter</button>
            </div>
        </form>

    </div>
</body>

</html>