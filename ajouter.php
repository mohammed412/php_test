<?php
session_start();
if (!isset($_SESSION['user']))
    header('Location:login.php', true);


require('functions/db_fn.php');
// errors array
$errors = [];

//input fields
$fields = ["libelle", "image", "id_famille"];

//get All familles to check if the famille id is defined in db 
$query = $con->prepare("SELECT * from famille");
$query->execute();
$familles = $query->fetchAll(PDO::FETCH_OBJ);

// Submit action
if (isset($_POST["ajouter"])) {

            if (empty($_POST['libelle']))
                $errors[] = "Libelle required";
            $extensions = ['jpg', 'jpeg', 'png'];
            if (!in_array(strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION)), $extensions))
                $errors[] = "file should be image";
            
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
    
    
    //check if there is errors
    if (count($errors) === 0) {
        
        $filename = './images/' .time(). $_FILES['image']['name'];
        if (move_uploaded_file($_FILES['image']['tmp_name'], $filename)) {

            $query = $con->prepare("INSERT into article values (default,?,?,?)");
            if ($query->execute([strip_tags($_POST['libelle']), $filename, $_POST['id_famille']])) {
                header('Location:articles.php', true);
            }
        }

    } else {
        foreach ($errors as $error) {
            echo '<div class="alert alert-danger" role="alert"> ' . $error . ' </div>';
        }
        
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<?php require('partials/head.php') ?>

<body>
    <div class="container">
        <?php require('partials/navbar.php') ?>
        <form method="POST" class="container d-flex flex-column" style="margin-left:200px;" enctype="multipart/form-data">
            <div class="form-group ">
                <label for="exampleInputEmail1">Libelle</label>
                <input type="text" name="libelle" class="form-control col-6" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Libelle">
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
                            <option value="<?= $fm->id ?>"><?= $fm->nom ?></option>
                    <?php
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
                <button name="ajouter" type="submit" class="btn btn-primary">Ajouter</button>
            </div>
        </form>

    </div>

</body>

</html>