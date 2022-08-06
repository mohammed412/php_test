<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location:login.php', true);
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<?php require('partials/head.php') ?>

<body>

    <div class="container">
        <?php require('partials/navbar.php') ?>
        <div class="container d-flex justify-content-center mb-3 mt-3">
            <button type="button" class="btn btn-primary"><a class="text-light" style="text-decoration:none;" href="ajouter.php">Ajouter Article</a></button>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Code</th>
                    <th scope="col">Libelle</th>
                    <th scope="col">Nome Famille</th>
                    <th scope="col">Photo</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                require('functions/db_fn.php');
                $query = $con->prepare('SELECT * from article');
                $query->execute();
                $articles = $query->fetchAll(PDO::FETCH_OBJ);
                if ($articles) :
                    foreach ($articles as $articl) :
                ?>
                        <tr>
                            <th scope="row"><?= $articl->id ?></th>
                            <td><?= $articl->libelle ?></td>
                            <td><?php
                                $stm = $con->prepare("SElECT nom from famille where id=:id ");
                                $stm->execute([':id' => $articl->id_famille]);
                                $obj = $stm->fetch(PDO::FETCH_OBJ);
                                if ($obj)
                                    echo $obj->nom;
                                else
                                    echo 'error';
                                ?></td>
                            <td><img src="<?= $articl->photo ?>" alt="ArticleImg"></td>
                            <th scope="row">
                                <a href="modifier.php?id=<?= $articl->id;  ?>"><button class="btn btn-success">Modifier</button></a>
                                <a href="supprimer.php?id=<?= $articl->id;  ?>"><button class="btn btn-danger">Delete</button></a>
                            </th>
                        </tr>
                <?php
                        
                    endforeach;
                endif;
                ?>
            </tbody>
        </table>
    </div>


</body>

</html>