<?php
session_start();

include 'script/class/event.php';
include 'script/class/option.php';

$staff = '';
if (isset($_SESSION['login'])) {
    $user = $_SESSION['login'];
    $staff = $_SESSION['staff'];
}

//Page variables
$userID = $_SESSION['id'];
$startDate = $_SESSION['startDate'];
$endDate = $_SESSION['endDate'];
$camp = $_SESSION['camp'];
$reservationID = $_SESSION['reservationId'];


$duration = new Option();
$day = $duration->duration($startDate, $endDate);

$optRecap = $duration->recapPresta($reservationID);

//$priceList = $duration->reservedOptionList($optRecap);
$opt = $duration->setOption($day);
$opt2 = $duration->bookedOptionList($reservationID);
$tt = $day * $opt2;


?>

<body class="bg__connexion">
    <?php include_once 'header.php'; ?>
    <main class="main-conn">
        <section class="main-res">>
            <h1 class="main__title__global">
                Récapitulatif de votre réservation
            </h1>
            <p class="connexion__label">Merci pour votre réservation. Vous retrouverez ci-dessous le récapitulatif concernant votre séjour</p>
            <h2 class="connexion__label">Durée de votre séjour</h2>
            <p class="connexion__label">La durée de votre séjour est de <?php echo $day; ?> jour(s)</p>
            <h2 class="connexion__label">Vos prestations</h2>
            <p class="connexion__label">Vos prestations vous coutent <?php echo $opt2; ?> € par jour, soit un total de <?php echo $tt ?> €</p>

        </section>

        <div>

        </div>
    </main>
</body>
<footer>

</footer>