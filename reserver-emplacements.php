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

//Calling method to show all reserved places from dates of previous form
$datePlace = new Event();
$datePlace = $datePlace->testAllPlace($startDate, $endDate);

//When submit, go through a series of test
if (isset($_POST['submit'])) {
    //Setting form variables
    $place = $_POST['reserve'];
    $placeTwo = $place - 1;
    $cBooking = new Event();
    $campBooking = $cBooking->createReservationCampingCar($startDate, $endDate, (int)$userID, (int)$place, (int)$placeTwo);
    foreach ($campBooking as $info) {
        echo $info['id_reservation'];
        echo $info['token'];
    }
    $_SESSION['reservationId'] = $info['id_reservation'];
    if (isset($_POST['option'])) {

        $option = $_POST['option'];
        echo '<pre>';
        var_dump($option);
        echo '</pre>';
        $optBooking = $cBooking->optionBooking($option, $info['id_reservation']);
    }
    //Redirection
    $host = $_SERVER['HTTP_HOST'];
    $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    $extra = 'recap.php';
    header("Location: http://$host$uri/$extra");
}


?>

<body>

    <section class="main_pro_sec">
        <?php include_once 'header.php'; ?>
        <form method="POST" action="reserver-emplacements.php">
            <fieldset class="main-res">
                <div>
                    <p>Sélectionnez vos options</p>
                    <div>
                        <input type="checkbox" id="campingCar" name="option[]" value="5" onclick="return false" checked>
                        <label class="connexion__label" for="borne">Emplacement camping-car</label>
                    </div>
                    <div>
                        <input type="checkbox" id="borne" name="option[]" value="2">
                        <label class="connexion__label" for="borne">Accès à la borne électrique</label>
                    </div>

                    <div>
                        <input type="checkbox" id="disco" name="option[]" value="3">
                        <label class="connexion__label" for="disco">Accès au disco-club</label>
                    </div>

                    <div>
                        <input type="checkbox" id="activity" name="option[]" value="4">
                        <label class="connexion__label" for="activity">Accès au yoga, freesbee et ski nautique</label>
                    </div>
                </div>


            </fieldset>
            <section>
                <article class="field_tab">
                    <table class="txt__label">
                        <?php
                        $optionList = new Option();
                        $optionList = $optionList->optionList();
                        foreach ($optionList as $oplist) {
                            echo "<tr><th>Prestation : </th><td>" . $oplist['nom_prestation'] . "</td><td>" . $oplist['cout_prestation'] . " €/jour</td></tr>";
                        }

                        ?>
                    </table>
                </article>
            </section>
            <fieldset class="field_tab main-res">
                <table class="txt__label">
                    <th>La Plage 1</th>
                    <?php
                    $pl = 0;
                    for ($emplacement = 1; $emplacement < 2; $emplacement++) {
                        $set = false;
                        foreach ($datePlace as $idPlace) {
                            if ($idPlace['id_emplacement'] == $emplacement) {
                                $set = true;
                            }
                        }
                        if ($set == true) {
                            $pl++;
                        }
                    }
                    if ($pl < 1) {
                        echo '<tr><td><input type="radio" name="reserve" id="place" value="' . $emplacement . '" required><label>Emplacement n°' . $emplacement . '</label></td></tr>';
                    } else {
                        echo '<tr><td>Emplacement réservé</td></tr>';
                    }

                    ?>
                </table>
                <table class="txt__label">
                    <th>La Plage 2</th>
                    <?php
                    $pl = 0;
                    for ($emplacement = 3; $emplacement < 4; $emplacement++) {
                        $set = false;
                        foreach ($datePlace as $idPlace) {
                            if ($idPlace['id_emplacement'] == $emplacement) {
                                $set = true;
                            }
                        }
                        if ($set == true) {
                            $pl++;
                        }
                    }
                    if ($pl < 1) {
                        echo '<tr><td><input type="radio" name="reserve" id="place" value="' . $emplacement . '" required><label>Emplacement n°' . $emplacement . '</label></td></tr>';
                    } else {
                        echo '<tr><td>Emplacement réservé</td></tr>';
                    }

                    ?>
                </table>


                <table class="txt__label">
                    <th>Les Pins 1</th>
                    <?php
                    $pl = 0;
                    for ($emplacement = 5; $emplacement < 6; $emplacement++) {
                        $set = false;
                        foreach ($datePlace as $idPlace) {
                            if ($idPlace['id_emplacement'] == $emplacement) {
                                $set = true;
                            }
                        }
                        if ($set == true) {
                            $pl++;
                        }
                    }
                    if ($pl < 1) {
                        echo '<tr><td><input type="radio" name="reserve" id="place" value="' . $emplacement . '" required><label>Emplacement n°' . $emplacement . '</label></td></tr>';
                    } else {
                        echo '<tr><td>Emplacement réservé</td></tr>';
                    }

                    ?>
                </table>

                <table class="txt__label">
                    <th>Les Pins 2</th>
                    <?php
                    $pl = 0;
                    for ($emplacement = 7; $emplacement < 8; $emplacement++) {
                        $set = false;
                        foreach ($datePlace as $idPlace) {
                            if ($idPlace['id_emplacement'] == $emplacement) {
                                $set = true;
                            }
                        }
                        if ($set == true) {
                            $pl++;
                        }
                    }
                    if ($pl < 1) {
                        echo '<tr><td><input type="radio" name="reserve" id="place" value="' . $emplacement . '" required><label>Emplacement n°' . $emplacement . '</label></td></tr>';
                    } else {
                        echo '<tr><td>Emplacement réservé</td></tr>';
                    }

                    ?>
                </table>

                <table class="txt__label">
                    <th>Le Maquis 1</th>
                    <?php
                    $pl = 0;
                    for ($emplacement = 9; $emplacement < 10; $emplacement++) {
                        $set = false;
                        foreach ($datePlace as $idPlace) {
                            if ($idPlace['id_emplacement'] == $emplacement) {
                                $set = true;
                            }
                        }
                        if ($set == true) {
                            $pl++;
                        }
                    }
                    if ($pl < 1) {
                        echo '<tr><td><input type="radio" name="reserve" id="place" value="' . $emplacement . '" required><label>Emplacement n°' . $emplacement . '</label></td></tr>';
                    } else {
                        echo '<tr><td>Emplacement réservé</td></tr>';
                    }

                    ?>
                </table>

                <table class="txt__label">
                    <th>Le Maquis 2</th>
                    <?php
                    $pl = 0;
                    for ($emplacement = 11; $emplacement < 12; $emplacement++) {
                        $set = false;
                        foreach ($datePlace as $idPlace) {
                            if ($idPlace['id_emplacement'] == $emplacement) {
                                $set = true;
                            }
                        }
                        if ($set == true) {
                            $pl++;
                        }
                    }
                    if ($pl < 1) {
                        echo '<tr><td><input type="radio" name="reserve" id="place" value="' . $emplacement . '" required><label>Emplacement n°' . $emplacement . '</label></td></tr>';
                    } else {
                        echo '<tr><td>Emplacement réservé</td></tr>';
                    }

                    ?>
                </table>

            </fieldset>
            <button class="index__button" type="submit" name="submit" value="Submit" class="btn btn-primary">Envoyer</button>
        </form>
    </section>


</body>