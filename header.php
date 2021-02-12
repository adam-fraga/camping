<?php

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="site/style.css">
    <link rel="stylesheet" href="site/formstyle.css" </head>

<body>
    <header class="header">
        <nav class="navbar">
            <div class="container_logos">
                <a class="header_link" href="index.php">
                    <img src="img/fish3.png" height="90px" alt="Poisson orange qui sourit">
                </a>
            </div>
            <div class="container_link">
                <!--User is not connecter-->
                <?php
                if (!isset($_SESSION['login'])) {
                    echo '<li>
                    <a href="connexion.php">Connexion</a>
                </li>';
                }
                ?>
                <!--User is not connecter-->
                <?php
                if (!isset($_SESSION['login'])) {
                    echo '<li>
                    <a href="inscription.php">Inscription</a>
                </li>';
                }
                ?>
                <!--User connected is from staff-->
                <?php
                if ($staff == true) {
                    echo '<li>
                    <a href="administration.php">Administration</a>
                </li>';
                }
                ?>

                <!--User is connected-->
                <?php
                if (isset($_SESSION['login'])) {
                    echo '
                    <li>
                    <a href="profil.php">Profil</a>
                    </li>
                    <li >
                    <a href="reserver.php">Réserver</a>
                    </li>
                    <li>
                    <a href="reservation.php">Vos réservations</a>
                    </li>
                
                <form method="POST" action="">
                    <button type="submit" name="logout" value="logout" class="btn btn-primary">Déconnexion</button></form>';

                    if (isset($_POST['logout'])) {
                        session_destroy();
                        $host = $_SERVER['HTTP_HOST'];
                        $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
                        $extra = 'connexion.php';
                        header("Location: http://$host$uri/$extra");
                    }
                }; ?>
            </div>
        </nav>
    </header>