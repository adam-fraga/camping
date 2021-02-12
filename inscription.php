<?php
session_start();
require 'script/class/user.php';
$staff = '';
if (isset($_SESSION['login'])) {
    $user = $_SESSION['login'];
    $staff = $_SESSION['staff'];
}

//REGISTER START
if (isset($_POST['submit'])) {
    //test if the password match with password repeat
    if ($_POST['password'] === $_POST['repeatPassword']) {
        //Password test : success
        //If the login and password are filled
        if ((isset($_POST['login'])) && isset($_POST['password'])) {
            //call new object user
            $user = new User();
            //call the register method & redirect the user
            $register = $user->register($_POST['login'], $_POST['password']);
            //Redirection
            $host = $_SERVER['HTTP_HOST'];
            $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
            $extra = 'connexion.php';
            header("Location: http://$host$uri/$extra");
        }
    } else {
        //Password test : fail
        echo 'Les mots de passe doivent être identiques';
    }
}
//REGISTER END
?>
<div class="bg__inscription">
    <?php include_once 'header.php' ?>
    <main>
        <article class="article__connexion">
            <h1 class="main__title__global">Créez votre compte</h1>
            <p class="p__form">Créer votre compte afin de pouvoir réserver votre séjour</p>
        </article>
        <section>
            <form class="form__connexion" method="POST" action="inscription.php">
                <fieldset class="shadow__block container__conn">
                    <legend class="connexion__legend">
                        Veuillez remplir ce formulaire afin de vous inscrire
                    </legend>
                    <small>* Tous les champs sont obligatoires</small>
                    <div>
                        <label class="connexion__label" for="login">Login</label>
                        <input type="text" name="login" class="form-control" id="login" placeholder="Login" autocomplete="off" required />
                    </div>

                    <div>
                        <label class="connexion__label" for="password">Mot de passe</label>
                        <input type="password" name="password" class="form-control" id="password" placeholder="Mot de passe" required />
                    </div>

                    <div>
                        <label class="connexion__label" for="repeatPassword">Confirmer le mot de passe</label>
                        <input type="password" name="repeatPassword" class="form-control" id="repeatPassword" placeholder="Confirmer le mot de passe" required />
                    </div>

                    <button class="index__button" type="submit" name="submit" value="Submit">Envoyer</button>

                </fieldset>
            </form>
        </section>
    </main>
</div>
<?php include_once 'footer.php' ?>