<?php
session_start();
include_once 'header.php';
include 'script/class/event.php'

?>

<body>

    <section>
        <form method="POST" action="reserver-emplacement.php">

            <legend>
                Réservez votre séjour et sélectionnez vos options
            </legend>
            <fieldset class="dateSelect">
                <div>
                    <label for="startDate">Date du début de votre séjour</label><br />

                    <input type="date" name="startDate" class="inputStartDate" id="startDate" />
                </div>
                <div>
                    <label for="endDate">Date de fin de votre séjour</label><br />

                    <input type="date" name="endDate" class="inputEndDate" id="endDate" />
                </div>
            </fieldset>
            <button type="submit" name="dateSend" value="dateSent">Envoyer</button>





        </form>


        <fieldset>
            <div>
                <p>Sélectionnez votre type de logement ainsi que les options désirées: </p>

                <input type="radio" id="camp_one" name="camp">
                <label for="camp_one">Tente</label>

                <input type="radio" id="camp_two" name="camp">
                <label for="camp_two">Camping-car</label>

            </div>

            <div>
                <p>Sélectionnez vos options</p>
                <div>
                    <input type="checkbox" id="borne" name="borne">
                    <label for="borne">Accès à la borde électrique</label>
                </div>

                <div>
                    <input type="checkbox" id="disco" name="disco">
                    <label for="disco">Accès au disco-club</label>
                </div>

                <div>
                    <input type="checkbox" id="activity" name="activity">
                    <label for="activity">Accès au yoga, freesbee et ski nautique</label>
                </div>
            </div>


            <button type="submit" name="send" value="Submit" class="btn btn-primary">Envoyer</button>

        </fieldset>
        </form>


    </section>

    <section>
        <article>
            <table>
                <th>Options</th>
                <th>Tarifs (par jour)</th>
                <tr>
                    <td>Emplacement (obligatoire)</td>
                    <td>10€</td>
                </tr>
                <tr>
                    <td>Borne électrique</td>
                    <td>17€</td>
                </tr>
                <tr>
                    <td>Disco-club "Les Girelles Dansantes"</td>
                    <td>17€</td>
                </tr>
                <tr>
                    <td>Yoga, Frisbee, Ski nautique</td>
                    <td>30€</td>
                </tr>

            </table>
        </article>
    </section>
    <?php include_once 'footer.php' ?>