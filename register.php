<?php
session_start();
include_once('functions/db_fn.php');

$fileds = ['name', 'email', 'password', 'cf_password'];
$errors = [];
if (isset($_POST['register'])) {
    foreach ($fileds as $filed) {
        if (!isset($_POST[$filed]) || empty($_POST[$filed])) {
            $errors[] = $filed . " is required";
        }
    }
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
        $errors[] = "incorrect email format";

    if ($_POST['password'] != $_POST['cf_password'])
        $errors[] = "password incorrect";

    if (count($errors) == 0) {
        if (checkEmail($_POST['email'])) {
            
            $_SESSION['user'] = addUser($_POST['name'], $_POST['email'], $_POST['password']);
            header('Location:index.php', true);
        } else
            $errors[] = "this email is used before";
    }
    if (count($errors) != 0) {
        foreach ($errors as $error) {
            echo '<div class="alert alert-danger" role="alert"> ' . $error . ' </div>';
        }
    }
}

?>


<!DOCTYPE html>
<html lang="en">


<?php include('partials/head.php') ?>


<body>
    <div>

        <section class="vh-100" >

            <div class="container h-100">
                <?php include('partials/navbar.php') ?>
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-xl-9">
                        <form method="post">
                            <h1 class="text-white mb-4">Register</h1>

                            <div class="card" style="border-radius: 15px;">
                                <div class="card-body">

                                    <div class="row align-items-center pt-4 pb-3">
                                        <div class="col-md-3 ps-5">

                                            <h6 class="mb-0">Nom</h6>

                                        </div>
                                        <div class="col-md-9 pe-5">

                                            <input type="text" name="name" class="form-control form-control-lg" placeholder="Votre Nom" />

                                        </div>
                                    </div>

                                    <hr class="mx-n3">

                                    <div class="row align-items-center py-3">
                                        <div class="col-md-3 ps-5">

                                            <h6 class="mb-0">Email address</h6>

                                        </div>
                                        <div class="col-md-9 pe-5">

                                            <input type="email" name="email" class="form-control form-control-lg" placeholder="example@example.com" />

                                        </div>
                                    </div>

                                    <hr class="mx-n3">

                                    <div class="row align-items-center py-3">
                                        <div class="col-md-3 ps-5">

                                            <h6 class="mb-0">Mot de pass</h6>

                                        </div>
                                        <div class="col-md-9 pe-5">

                                            <input type="password" name="password" class="form-control form-control-lg" placeholder="*************" />

                                        </div>
                                    </div>

                                    <hr class="mx-n3">

                                    <div class="row align-items-center py-3">
                                        <div class="col-md-3 ps-5">

                                            <h6 class="mb-0">Confirm Le mot de pass</h6>

                                        </div>
                                        <div class="col-md-9 pe-5">

                                            <input type="password" name="cf_password" class="form-control form-control-lg" placeholder="*************" />

                                        </div>
                                    </div>

                                    <hr class="mx-n3">

                                    <div class="px-5 py-4">
                                        <button type="submit" name="register" class="btn btn-primary btn-lg">Register</button>
                                    </div>

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
</body>

</html>