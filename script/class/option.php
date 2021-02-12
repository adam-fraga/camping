<?php

class Option
{
    //ATTRIBUTES
    private $_price;
    private $_name;

    //METHODS

    /*
     * Calcule le nombre de jours réservés selon les dates entrées par l'utilisateur
     * Retourne un entier
     * Sert à multiplier le total des options pour calculer le total facturé au client
     */
    public function duration($startDate, $endDate)
    {
        //Return the number of day
        $this->_startDate = $startDate;
        $this->_endDate = $endDate;

        $start = new DateTime($startDate);
        $end = new DateTime($endDate);

        $dayDiff = $end->diff($start)->format("%a");
        $dayDiff = $dayDiff + 1;

        return (int)$dayDiff;
    }

    public function recapPresta($reservationID)
    {
        //Récapitule la liste des options choisies pour la réservation

        $pdo = $this->dbConnect();
        $query = $pdo->prepare("SELECT * FROM total WHERE id_reservations = :reservationid");
        $query->bindValue(':reservationid', $reservationID);
        $query->execute();
        $result = $query->fetchAll();

        return $result;
    }

    public function reservedOptionList($array)
    {
        //Récupère les prix des options

        $pdo = $this->dbConnect();
        foreach ($array as $idPresta) {
            $query = $pdo->prepare("SELECT cout_prestation FROM prestations WHERE id_prestation = :idPresta");
            $query->bindValue(':idPresta', $idPresta['cout_prestation']);
            $query->execute();
            $res[] = $query->fetchAll();
        }

        $total = array_sum($res);
        return $res;
    }

    public function bookedOptionList($id)
    {
        //Renvoi les options liées à une réservation

        $pdo = $this->dbConnect();
        $query = $pdo->prepare("SELECT cost FROM total WHERE id_reservations = :id");
        $query->bindValue(':id', $id);
        $query->execute();
        $result = $query->fetchAll();

        $i = 0;
        foreach ($result as $cost) {
            (int)$cost = $cost['cost'];
            if (isset($cost)) {
                $i = $i + $cost;
            }
        }
        return $i;
    }

    public function calculateTotal($array)
    {
    }

    public function createOption($name, $price)
    {
        //Create a new service in the DB
        $this->_name = $name;
        $this->_price = $price;
        //Connection to the DB
        $pdo = $this->dbConnect();
        //PDO query preparation & execution
        $query = $pdo->prepare("INSERT INTO prestations (nom_prestation,cout_prestation) VALUES (:name,:price)");
        $query->bindValue('name', $name, PDO::PARAM_STR);
        $query->bindValue('price', $price, PDO::PARAM_INT);
        $insertIsOk = $query->execute();
        if ($insertIsOk != true) {
            echo 'Data NOT inserted in DB, please check !! <br />';
        }
    }

    public function optionList()
    {
        $pdo = $this->dbConnect();
        $query = $pdo->prepare("SELECT * FROM prestations");
        $query->execute();
        $result = $query->fetchAll();
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

        //var_dump($result);
    }


    public function update($id, $newName, $newPrice)
    {
        //Call DB connection
        $pdo = $this->dbConnect();
        //Update SQL request
        $query = $pdo->prepare("UPDATE prestations SET nom_prestation=:newPrestaName,cout_prestation=:newPrestaCost WHERE id_prestation=:id");
        $query->bindValue('newPrestaName', $newName, PDO::PARAM_STR);
        $query->bindValue(':newPrestaCost', $newPrice, PDO::PARAM_INT);
        $query->bindValue(':id', $id, PDO::PARAM_STR);
        $query->execute();
        return $query;
    }

    public function priceCalcul($day)
    {
        //Calcule le prix à payer par l'utilisateur en fonction des options choisies et
        //de la durée de son séjour

    }
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

    //GETTER
    public function setName($name)
    {
        //Check if the option name is a string
        if (is_string($name)) {
            $this->_name = $name;
        }
    }

    public function setLogin($price)
    {
        //Check if the login is a string
        if (is_int($price)) {
            $this->_login = $price;
        }
    }

    //SETTER
    public function price()
    {
        return $this->_price;
    }

    public function name()
    {
        return $this->_name;
    }
}
