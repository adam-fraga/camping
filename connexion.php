<?php
session_start();
$staff = '';
require 'script/class/user.php';
if (isset($_SESSION['login'])) {
    $user = $_SESSION['login'];
    $staff = $_SESSION['staff'];
}

//CONNECTION START

//Get form data
$connstat = true; //variable to test and display credentials issue
if (isset($_POST['submit'])) {
    if ((isset($_POST['login'])) && isset($_POST['password'])) {

        $user = new User();
        $connect = $user->connect($_POST['login'], $_POST['password']);
        if ($connect == false) {
            $connstat = false;
        } else {
            foreach ($connect as $info) {
                //$info['id_utilisateur'];
            }
            $_SESSION['id'] = $info['id_utilisateur'];
            $_SESSION['login'] = $info['login'];
            $_SESSION['staff'] = $info['staff'];
            $_SESSION['password'] = $info['password'];

            //Redirection according to user's rights
            if ($_SESSION['staff'] == true) {
                //Staff member
                $host = $_SERVER['HTTP_HOST'];
                $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
                $extra = 'administration.php';
                header("Location: http://$host$uri/$extra");
            } else {
                //Not staff member
                $host = $_SERVER['HTTP_HOST'];
                $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
                $extra = 'profil.php';
                header("Location: http://$host$uri/$extra");
            }
        }
    }
}
//CONNECTION END
?>
<div class="bg__connexion">
    <?php include_once 'header.php'; ?>
    <main class="main-conn">
        <article class="article__connexion">
            <h1 class="main__title__global">
                Page de connexion
            </h1>
            <p class="p__form">
                Connectez vous afin de pouvoir gérer vos réservations
            </p>
        </article>
        <section>
            <form class="form__connexion" method="POST" action="connexion.php">
                <fieldset class="shadow__block container__conn">
                    <legend class="connexion__legend">
                        Connectez vous à votre profil
                    </legend>

                    <div>
                        <label class="connexion__label" for="login">Login</label>
                        <input type="text" name="login" class="form-control" id="login" placeholder="Login" autocomplete="off" required />
                    </div>

                    <div>
                        <label class="connexion__label" for="password">Mot de passe</label>
                        <input type="password" name="password" class="form-control" id="password" placeholder="Mot de passe" required />
                    </div>

                    <button class="index__button" type="submit" name="submit" value="Submit">Connexion</button>
                </fieldset>
            </form>
            <?php
            if ($connstat == false) {
                echo '
                    <div class="alert alert-dismissible alert-danger mt-5">
                    <strong>Vous avez entré un mauvais nom login ou un mauvais mot de passe !!!
                    </div>';
            }
            ?>

        </section>
    </main>
</div>
<?php include_once 'footer.php' ?>