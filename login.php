<?php
session_start();
require('functions/db_fn.php');

if(isset($_SESSION['user'])){
    header('Location:index.php');
}
if (isset($_POST['login'])) {
    if(!empty($_POST['email']) && !empty($_POST['password'])){
        if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
            echo "<div class='alert alert-danger' role='alert'>Email Format invalide </div>";
        }
        else{
            try{
            $query = $con->prepare("SELECT * from users where email = :EMAIL");
            $query->execute([":EMAIL"=>$_POST["email"]]);
            $data=$query->fetch(PDO::FETCH_OBJ);
            
            if($data && password_verify($_POST['password'], $data->password)){
                $_SESSION['user']=$data;
                header('Location:index.php');
            }else{
                    echo "<div class='alert alert-danger' role='alert'>Email or Password incorrect </div>";
            }
            }catch(PDOException $e){
                die('error:'.$e->getMessage());
            }
        }
    }
    else{
        echo "<div class='alert alert-danger' role='alert'>Email and password required </div>";
    }
}

?>






<!DOCTYPE html>
<html lang="en">
<?php include('partials/head.php') ?>

<body>

    <div class="container">
        <?php include('partials/navbar.php') ?>
        <section class="vh-100">
            <div class="container-fluid h-custom">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-md-9 col-lg-6 col-xl-5">
                        <img src="./images/draw2.webp" class="img-fluid" alt="Sample image">
                    </div>
                    <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
                        <form method="POST">
                            <div class="d-flex flex-row align-items-center justify-content-center justify-content-lg-start">
                                <p class="lead fw-normal mb-0 me-3"></p>
                                
                            </div>

                            <div class="divider d-flex align-items-center my-4">
                                <p class="text-center fw-bold mx-3 mb-0"></p>
                            </div>

                            <!-- Email input -->
                            <div class="form-outline mb-4">
                                <input type="email" name="email" id="form3Example3" class="form-control form-control-lg" placeholder="Enter votre Email" />
                                <label class="form-label" for="form3Example3">Email address</label>
                            </div>

                            <!-- Password input -->
                            <div class="form-outline mb-3">
                                <input name="password" type="password" id="form3Example4" class="form-control form-control-lg" placeholder="Enter votre mot de pass" />
                                <label class="form-label" for="form3Example4">Mot de pass</label>
                            </div>

                            

                            <div class="text-center text-lg-start mt-4 pt-2">
                                <button type="submit" class="btn btn-primary btn-lg" name="login" style="padding-left: 2.5rem; padding-right: 2.5rem;">Login</button>
                                <p class="small fw-bold mt-2 pt-1 mb-0"><a href="register.php" class="link-danger">Register</a></p>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
            
        </section>
    </div>

</body>

</html>