<?php

class Event
{
    //ATTRIBUTES

    private $_startDate;
    private $_endDate;
    private $_eventId;
    private $_userId;
    private $_placeNumber;

    //METHODS

    /**
     * Liste toute les réservations de l'utilisateur connecté
     */
    public function reservationList($userId)
    {
        $this->_userId = $userId;
        $pdo = $this->dbConnect();
        $query = $pdo->prepare("SELECT * FROM reservations WHERE id_client = :idClient");
        $query->bindValue(':idClient', $userId);
        $query->execute();
        $result = $query->fetchAll();
        return $result;
    }

    /*
     * Teste tous les emplacements dans un intervalle de date
     * Effectue une requête retournant un tableau contenant la liste des emplacements non réservables
     *
     */
    public function testAllPlace($startDate, $endDate)
    {
        //teste tous les emplacements réservés à une date donnée par l'utilisateur
        $this->_startDate = $startDate;
        $this->_endDate = $endDate;
        //Connect
        $pdo = $this->dbConnect();
        $query = $pdo->prepare("SELECT id_emplacement FROM reservations WHERE (:datestart and :dateend BETWEEN date_debut AND date_fin) OR (date_debut and date_fin BETWEEN :datestart and :dateend )");
        $query->bindValue(':datestart', $startDate);
        $query->bindValue(':dateend', $endDate);
        $query->execute();
        $result = $query->fetchAll();
        return $result;
    }

    //Book tent
    /*
     * Requete pour réserver une tente
     */
    public function createReservationTent($startDate, $endDate, $userId, $placeNumber)
    {
        //Methode pour réserver une tente, ne prenant qu'un emplacement

        $this->_startDate = $startDate; //comes from form
        $this->_endDate = $endDate; //comes from form
        $this->_userId = $userId; //comes from session_ID
        $this->_placeNumber = $placeNumber;
        $token = 1;

        $pdo = $this->dbConnect();

        $query = $pdo->prepare("INSERT INTO reservations (id_client,date_debut,date_fin,id_emplacement,token) VALUES (:idclient,:datedebut,:datefin,:idplace,:token)");
        $query->bindValue(':idclient', $userId);
        $query->bindValue(':datedebut', $startDate);
        $query->bindValue(':datefin', $endDate);
        $query->bindValue(':idplace', $placeNumber);
        $query->bindValue(':token', $token);
        $query->execute();
        $queryT = $pdo->prepare("SELECT * FROM reservations WHERE (id_client,date_debut,date_fin,id_emplacement,token) = (:idclient,:datedebut,:datefin,:idplace,:token)");
        $queryT->bindValue(':idclient', $userId);
        $queryT->bindValue(':datedebut', $startDate);
        $queryT->bindValue(':datefin', $endDate);
        $queryT->bindValue(':idplace', $placeNumber);
        $queryT->bindValue(':token', $token);
        $queryT->execute();
        $result = $queryT->fetchAll();

        return $result;
    }


    //Book camping-car
    /*
     * Requete pour réserver un camping-car
     */
    public function createReservationCampingCar($startDate, $endDate, $userId, $placeNumberOne, $placeNumberTwo)
    {
        //Methode pour réserver un camping car, prenant deux emplacements
        $this->_startDate = $startDate; //comes from form
        $this->_endDate = $endDate; //comes from form
        $this->_userId = $userId; //comes from session_ID
        $this->_placeNumber = $placeNumberOne; //comes from placeChoice
        $placeNumberTwo = $placeNumberOne - 1;
        $token = 2;

        $pdo = $this->dbConnect();

        $query = $pdo->prepare("INSERT INTO reservations (id_client,date_debut,date_fin,id_emplacement,token)  VALUES (:idclient,:datedebut,:datefin,:idplace,:token),(:idclient,:datedebut,:datefin,:idplacetwo,:token)");
        $query->bindValue(':idclient', $userId);
        $query->bindValue(':datedebut', $startDate);
        $query->bindValue(':datefin', $endDate);
        $query->bindValue(':idplace', $placeNumberOne);
        $query->bindValue('idplacetwo', $placeNumberTwo);
        $query->bindValue(':token', $token);
        $query->execute();
        $queryC = $pdo->prepare("SELECT * FROM reservations WHERE (id_client,date_debut,date_fin,id_emplacement,token) = (:idclient,:datedebut,:datefin,:idplace,:token)");
        $queryC->bindValue(':idclient', $userId);
        $queryC->bindValue(':datedebut', $startDate);
        $queryC->bindValue(':datefin', $endDate);
        $queryC->bindValue(':idplace', $placeNumberOne);
        $queryC->bindValue(':token', $token);
        $queryC->execute();
        $result = $queryC->fetchAll();

        return $result;
    }

    public function setOption($idOption)
    {
        //retourne les informations d'une option sélectionnée

        $pdo = $this->dbConnect();
        $query = $pdo->prepare("SELECT cout_prestation FROM prestations WHERE id_prestation = :idoption");
        $query->bindValue(':idoption', $idOption, PDO::PARAM_INT);
        $query->execute();
        $result = $query->fetchAll();

        return $result;
    }

    /*
     * Insere en database les options réservées par l'utilisateur
     * choisies dans le formulaire liées à l'id de la réservation
     */
    public function optionBooking($array, $reservationId)
    {
        $pdo = $this->dbConnect();

        $idResa = $reservationId;

        foreach ($array as $idPresta) {
            $idPresta = (int)$idPresta;
            $querya = $pdo->prepare("SELECT cout_prestation FROM prestations WHERE id_prestation = :idoption");
            $querya->bindValue(':idoption', $idPresta, PDO::PARAM_INT);
            $querya->execute();
            $result = $querya->fetchAll();
            foreach ($result as $c) {
                $queryb = $pdo->prepare("INSERT INTO total (id_reservations,id_prestation,cost) VALUES (:id_reservations,:id_prestation,:cost)");
                $queryb->bindValue('id_prestation', $idPresta, PDO::PARAM_INT);
                $queryb->bindValue('id_reservations', $idResa, PDO::PARAM_INT);
                $queryb->bindValue('cost', $c['cout_prestation'], PDO::PARAM_INT);
                $insertIsOk = $queryb->execute();
                if ($insertIsOk != true) {
                    echo 'Data NOT inserted in DB, please check !! <br />';
                }
            }
        }
    }


    //GETTER

    //SETTER

    //DBCo
    protected function dbConnect()
    {
        //Change variables according to the database used
        $dbtype = 'mysql';
        $dbhost = 'localhost';
        $dbname = 'camping';
        $dbusername = 'root';
        $dbpassword = '';

        $dsn = $dbtype . ':host=' . $dbhost . ';dbname=' . $dbname;

        try {
            $pdo = new \PDO($dsn, $dbusername, $dbpassword);
        } catch (PDOException $pe) {
            echo 'Connection error :' . $pe->getMessage();
        }
        return $pdo;
    }
}
