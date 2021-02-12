<?php
session_start();
//$_SESSION['staff'] = false;

$staff = '';
if (isset($_SESSION['login'])) {
    $user = $_SESSION['login'];
    $staff = $_SESSION['staff'];
}

//Unset previous date variables
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
    <main class="container_section">
        <div class="bg_index">
            <?php include_once 'header.php'; ?>
            <section class="section_camping">
                <h2 class="main_title_index">Bienvenue en Ardèche</h2>
            </section>
            <section class="section_reservation">
                <h2 class="title_sejour">Réserver votre séjour</h2>
                <form class="form_index" action="" method="POST">
                    <div>
                        <label class="index__label" for="date_debut">Date de début de votre séjour</label>
                        <input class="index__date" type="date" id="date_debut" name="startDate">
                    </div>
                    <div>
                        <label class="index__label" for="date_fin">Date de fin de votre séjour</label>
                        <input class="index__date" type="date" id="date_fin" name="endDate">
                    </div>
                    <div>
                        <div class="container__logement">
                            <p class="index__label">Votre moyen de logement:</p>
                            <input type="radio" id="camp_one" name="camp" value="1" required>
                            <label for="camp_one">Tente</label>
                            <input type="radio" id="camp_two" name="camp" value="2" required>
                            <label for="camp_two">Camping-car</label>
                        </div>
                    </div>
                    <div class="container_button">
                        <button class="index__button" type="submit" name="dateSend" value="dateSend">Réserver</button>
                    </div>
                </form>
            </section>
        </div>
        <section class="section_activite">
            <h2 class="title__activite">Découvrez nos activités!</h2>
            <div class="container_card">
                <div class="card">
                    <div class="index_article">
                        <div class="container__pic">
                            <img class="elec__pic " src="img/elec.jpg" alt="borne electrique campingcar">
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="index_article">
                        <div class="container__pic">
                            <img class="club__pic" src="img/club.jpg" alt="club dansant">
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="index_article">
                        <div class="container__pic">
                            <img class="club__pic" src="img/yoga.jpg" alt="club dansant">
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="index_article">
                        <div class="container__pic">
                            <img class="ski__pic" src="img/nautique.jpg" alt="garçon ski nautique">
                        </div>
                    </div>
                </div>
            </div>
            <article class="article__activite">
                <h2 class="title__activite">Choisissez le meilleur pour vos vacances!</h2>
                <p class="p__activte"> Du disco au Club "les Girelles Dansantes" animé par l'un des plus célèbre DJ de la région,
                    aux randonnées dans des lieux ou la verdure saura vous rappeler la beauté de nos régions,
                    vous aurez aussi le choix de notre formule comprennant: des parcours de Ski-nautique, des activités de
                    Freesby pour vos enfants ou encore des moments de détentes lors de nos cours de yoga en pleine nature
                    profitez pleinement de votre séjour, nous mettons également à votre disposition
                    une borne electrique qui saura satisfaire votre confort. Alors n'attendez plus
                    et reservez dés maintenant</p>
            </article>
        </section>
    </main>
</body>
<?php include_once 'footer.php'; ?>

</html>