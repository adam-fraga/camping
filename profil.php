<?php
session_start();
require 'script/class/user.php';
// MODIFY START
$staff = '';
if (isset($_SESSION['login'])) {
    $user = $_SESSION['login'];
    $id = $_SESSION['id'];
    $staff = $_SESSION['staff'];
}


if (isset($_POST['submit'])) {
    $user = new User();
    $newLogin = $_POST['newLogin'];
    $newPassword = $_POST['newPassword'];
    $update = $user->update($id, $newLogin, $newPassword);
    session_destroy();
    $host = $_SERVER['HTTP_HOST'];
    $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    $extra = 'connexion.php';
    header("Location: http://$host$uri/$extra");
}
//MODIFY END
?>

<main class="main_pro">
    <?php include_once 'header.php' ?>
    <section class="main-sec">
        <h1></h1>
        <form method="POST" action="profil.php">
            <fieldset>
                <legend class="main__title__global">
                    Bonjour <?php echo $user . ".<br />" ?>
                </legend>


                <div>
                    <label class="connexion__label" for="login">Nouveau login</label>
                    <input type="text" name="newLogin" class="main-sec-inp" id="login" value="<?php echo ($user) ?>" onFocus="this.value='';" autocomplete="off" />
                </div>

                <div>
                    <label class="connexion__label" for="password1">Nouveau mot de passe</label>
                    <input type="password" name="newPassword" class="main-sec-inp" id="password" placeholder="Mot de passe" />
                </div>

                <button class="index__button" type="submit" name="submit" value="Submit">Envoyer</button>
                <br />
                <small>Mettre à jour vos informations vous déconnectera</small>
            </fieldset>
        </form>
    </section>
</main>
<?php include_once 'footer.php' ?>