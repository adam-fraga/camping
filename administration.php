<?php
session_start();

require 'script/class/user.php';
require 'script/class/staff.php';
require 'script/class/option.php';

$staff = '';
if (isset($_SESSION['login'])) {
    $user = $_SESSION['login'];
    $staff = $_SESSION['staff'];
}

//Redirection if page visitor is not from staff
if ($_SESSION['staff'] != true) {
    $host = $_SERVER['HTTP_HOST'];
    $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    $extra = 'profil.php';
    header("Location: http://$host$uri/$extra");
}

//Page refresher variable
$refresher = false;

//Include user in staff
if (isset($_POST['submit'])) {
    $status = new Staff();
    $login = $_POST['staffInclude'];
    $status = $status->addAdmin($login);
    $refresher = true;
}

//Remove user from staff
if (isset($_POST['submit'])) {
    $status = new Staff();
    $login = $_POST['staffExclude'];
    $status = $status->removeAdmin($login);
    $refresher = true;
}

//Create service
if (isset($_POST['serviceSubmit'])) {
    $serviceName = $_POST['serviceName'];
    $servicePrice = $_POST['servicePrice'];
    $nService = new Option();
    $newService = $nService->createOption($serviceName, $servicePrice);
    $refresher = true;
}

//Amend service name/price
if (isset($_POST['updateOption'])) {
    $updateOption = new Option();
    $optionId = $_POST['optionId'];
    $updateName = $_POST['optionName'];
    $updatePrice = $_POST['optionPrice'];
    $updateOption = $updateOption->update($optionId, $updateName, $updatePrice);
    $refresher = true;
}

//Page refresher
if ($refresher === true) {
    $host = $_SERVER['HTTP_HOST'];
    $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    $extra = 'administration.php';
    header("Location: http://$host$uri/$extra");
}



?>
<main class="main_pro_ter">
    <?php include_once 'header.php' ?>
    <!--Customer list-->
    <section class="main-sec">
        <h2 class="connexion__label">Liste clients</h2>
        <table class="field_tab">
            <?php
            $uList = new Staff();
            $userList = $uList->userList();
            foreach ($userList as $list) {
                echo "<tr><th></th><td>" . $list['login'] . "</td></tr>";
            }
            ?>
        </table>


        <!--Include in staff-->

        <h2 class="connexion__label">Inclure dans le personnel</h2>

        <form method="POST" action="administration.php">

            <legend class="connexion__label">
                Saisir le login à inclure dans le personnel
            </legend>

            <div>
                <label>Login</label>
                <input type="text" name="staffInclude" class="form-control" id="staffInclude" placeholder="Saisir le login" autocomplete="off" required />
            </div>

            <button type="submit" name="submit" value="Submit">Inclure dans le staff</button>

        </form>
    </section>


    <!--Staff list-->
    <section class="main-sec">
        <h2 class="connexion__label">Liste personnel</h2>
        <table class="field_tab">
            <?php
            $staffList = $uList->staffList();
            foreach ($staffList as $slist) {
                echo "<tr><th></th><td>" . $slist['login'] . "</td></tr>";
            }

            ?>
        </table>


        <!--Exclude from staff-->

        <h2 class="connexion__label">Sortir du personnel</h2>

        <form method="POST" action="administration.php">

            <legend>
                Saisir le login à sortir du personnel
            </legend>

            <div>
                <label for="staffExclude">Login</label>
                <input type="text" name="staffExclude" class="form-control" id="staffExclude" placeholder="Saisir le login" autocomplete="off" required />
            </div>

            <button type="submit" name="submit" value="Submit">Sortir du staff</button>

        </form>

    </section>

    <!--Create new service-->
    <section class="main-sec">
        <h2 class="connexion__label">Créer une prestation</h2>

        <form method="POST" action="administration.php">

            <legend>
                Saisir l'option
            </legend>

            <div>
                <label for="serviceName">Nom</label>
                <input type="text" name="serviceName" class="form-control" id="serviceName" placeholder="Saisir le nom" autocomplete="off" required />
            </div>
            <div>
                <label for="servicePrice">Prix</label>
                <input type="number" name="servicePrice" class="form-control" id="servicePrice" placeholder="Saisir le prix" autocomplete="off" required />
            </div>

            <button type="submit" name="serviceSubmit" value="serviceSubmit">Créer</button>

        </form>
    </section>


    <!--Service list-->
    <section class="main-sec">
        <h2 class="connexion__label">Liste des options</h2>
        <table class="field_tab">
            <?php
            $optionList = new Option();
            $optionList = $optionList->optionList();
            foreach ($optionList as $oplist) {
                echo "<tr><th>Prestation : </th><td> Option n° : " . $oplist['id_prestation'] . "  </td><td>Nom : " . $oplist['nom_prestation'] . "</td><td>" . $oplist['cout_prestation'] . " €/jour</td></tr>";
            }

            ?>
        </table>

    </section>
    <!--Amend service-->
    <section class="main-sec">
        <h2 class="connexion__label">Modifier une option</h2>

        <form method="POST" action="administration.php">
            <fieldset>
                <legend>
                    Saisir l'option à modifier
                </legend>
                <div>
                    <label for="optionId">N° Option</label>
                    <input type="text" name="optionId" class="form-control" id="optionId" placeholder="Saisir le numéro" autocomplete="off" required />
                </div>
                <div>
                    <label for="optionName">Nom de l'option</label>
                    <input type="text" name="optionName" class="form-control" id="optionName" placeholder="Saisir le nom" autocomplete="off" required />
                </div>

                <div>
                    <label for="optionPrice">Nouveau prix</label>
                    <input type="number" name="optionPrice" class="form-control" id="optionPrice" placeholder="Prix
                                autocomplete=" off" required />
                </div>

                <button type="submit" name="updateOption" value="updateOption">Modifier</button>
            </fieldset>
        </form>
    </section>

</main>
</body>