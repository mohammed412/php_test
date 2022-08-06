<?php
session_start();
$fields =["name", "email", "subject", "message"];
$errors =[];
if(isset($_POST['send'])){
    foreach($fields as $field){
        if(empty($_POST[$field])){
                $errors[] = $field." is required";
            }
            if($field === "email" && !filter_var($_POST[$field], FILTER_VALIDATE_EMAIL)){
                $errors[] = "Invalide email format";
            }
    }
    
    if (count($errors) == 0) {
        $name = $_POST["name"];
        $subject = $_POST["subject"];
        $email = $_POST["email"];
        $message = $_POST["message"];
        $to = "contact@omg.com";
        $body = "De ".$name ."\r\n".$message;
        $headers =  'MIME-Version: 1.0' . "\r\n";
        $headers .= 'From: Your name'.$email."\r\n";
        $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n"; 
        
        if(mail($to, $subject, $body, $headers))
            echo '<div class="alert alert-success" role="alert">Message send succesfuly</div>';
        
    }
    else{
        foreach ($errors as $error) {
            echo '<div class="alert alert-danger" role="alert">'.$error.'</div>';
        }
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <?php require('partials/head.php') ?>
</head>

<body>
    <div class="container">
        <?php require('partials/navbar.php') ?>
        <!--Section: Contact v.2-->
        <section class="mb-4">

            <!--Section heading-->
            <h2 class="h1-responsive font-weight-bold text-center my-4">Contacter Nous</h2>
            <!--Section description-->

            <div class="row">

                <!--Grid column-->
                <div class="col-md-9 mb-md-0 mb-5" style="margin-left: 140px;">
                    <form id="contact-form" name="contact-form"  method="POST">

                        <!--Grid row-->
                        <div class="row">

                            <!--Grid column-->
                            <div class="col-md-6">
                                <div class="md-form mb-0">
                                    <input type="text" id="name" name="name" class="form-control">
                                    <label for="name" class="">Votre nom</label>
                                </div>
                            </div>
                            <!--Grid column-->

                            <!--Grid column-->
                            <div class="col-md-6">
                                <div class="md-form mb-0">
                                    <input type="text" id="email" name="email" class="form-control">
                                    <label for="email" class="">Votre email</label>
                                </div>
                            </div>
                            <!--Grid column-->

                        </div>
                        <!--Grid row-->

                        <!--Grid row-->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="md-form mb-0">
                                    <input type="text" id="subject" name="subject" class="form-control">
                                    <label for="subject" class="">Objet</label>
                                </div>
                            </div>
                        </div>
                        <!--Grid row-->

                        <!--Grid row-->
                        <div class="row">

                            <!--Grid column-->
                            <div class="col-md-12">

                                <div class="md-form">
                                    <textarea type="text" id="message" name="message" rows="2" class="form-control md-textarea"></textarea>
                                    <label for="message">Votre message</label>
                                </div>

                            </div>
                        </div>
                        <!--Grid row-->
                    <div class="text-center text-md-left">
                                            <input type="submit" name="send" class="btn btn-primary" value="Envoyer" />
                                        </div>
                    </form>

                   
                    <div class="status"></div>
                </div>
                <!--Grid column-->

                

            </div>

        </section>
        <!--Section: Contact v.2-->
    </div>
</body>

</html>