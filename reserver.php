<?php
session_start();

$staff = '';
if (isset($_SESSION['login'])) {
    $user = $_SESSION['login'];
    $staff = $_SESSION['staff'];
}

include 'script/class/event.php';
//Unset variables of date
unset($_SESSION['startDate']);
unset($_SESSION['endDate']);

if (isset($_POST['dateSend'])) {
    $_SESSION['startDate'] = $_POST['startDate'];
    $_SESSION['endDate'] = $_POST['endDate'];
    $_SESSION['camp'] = $_POST['camp'];
    //redirect for next form according to user's camp choice
    if ($_POST['camp'] == 1) {
        //If user choosed a tent
        $host = $_SERVER['HTTP_HOST'];
        $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
        $extra = 'reserver-emplacement.php';
        header("Location: http://$host$uri/$extra");
    } else {
        //If user choosed a camping-car
        $host = $_SERVER['HTTP_HOST'];
        $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
        $extra = 'reserver-emplacements.php';
        header("Location: http://$host$uri/$extra");
    }
}

?>

<body>

    <section class="main_pro">
        <?php include_once 'header.php'; ?>
        <form method="POST" action="reserver.php">


            <fieldset class="">
                <div class="main-ter">
                    <p class="connexion__label">Sélectionnez votre type de logement : </p>
                    <div>
                        <input type="radio" id="camp_one" name="camp" value="1" required>
                        <label for="camp_one">Tente</label>

                        <input type="radio" id="camp_two" name="camp" value="2" required>
                        <label for="camp_two">Camping-car</label>
                    </div>
                </div>
                <div>
                    <label class="connexion__label" for="startDate">Date du début de votre séjour</label><br />

                    <input type="date" name="startDate" class="main-sec-inp" id="startDate" required />
                </div>
                <div>
                    <label class="connexion__label" for="endDate">Date de fin de votre séjour</label><br />

                    <input type="date" name="endDate" class="main-sec-inp" id=" endDate" required />
                </div>

            </fieldset>





            <button class="index__button" type="submit" name="dateSend" value="dateSend">Envoyer</button>


        </form>


    </section>