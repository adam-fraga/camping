<?php
session_start();

include 'script/class/event.php';
include 'script/class/option.php';

$staff = '';
if (isset($_SESSION['login'])) {
    $user = $_SESSION['login'];
    $staff = $_SESSION['staff'];
    $userID = $_SESSION['id'];
}

$reservationList = new Event();
$reservationList = $reservationList->reservationList($userID);

?>


<body class="bg__connexion">
    <?php include_once 'header.php'; ?>
    <main class="main-conn">
        <section class="main-res">
            <h1 class="main__title__global">
                Vos réservations
            </h1>
            <table class="txt__label field_tab">
                <?php foreach ($reservationList as $list) {
                    echo '<tr>
<td>Du ' . $list['date_debut'] . '</td>
<td>au ' . $list['date_fin'] . '</td>

</tr>';
                } ?>
            </table>

        </section>

        <div>

        </div>
    </main>
</body>
<footer>

</footer>