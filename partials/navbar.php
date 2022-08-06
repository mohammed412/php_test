
<nav class="navbar navbar-expand-lg bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">VPI Info</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <?php
                    if (isset($_SESSION['user']))
                        echo '<a class="nav-link" href="articles.php">Articles</a>';
                    else
                        echo '<a class="nav-link" href="login.php">Login</a>';
                    ?>
                </li>
                <li class="nav-item">
                    <?php
                    if (isset($_SESSION['user']))
                        echo '<a class="nav-link" href="logout.php">Logout</a>';
                    else
                        echo '<a class="nav-link" href="register.php">Register</a>';
                    ?>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contact.php">Contact</a>
                </li>

                

            </ul>

        </div>
    </div>
</nav>