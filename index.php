<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<?php include('./partials/head.php') ?>

<body>
    <div class="container">
    <?php include('partials/navbar.php') ?>

    <?php
    if(isset($_SESSION['user'])){
        
        echo '<h1 align="center">Welcome Back '.$_SESSION['user']->nom.'</h1>';
    }
    ?>
    
</div>
</body>

</html>