<?php

class User
{
    //ATTRIBUTES
    private $_id;
    private $_login;
    private $_password;


    //METHODS
    public function register($login, $password)
    {
        //Create a new user in the DB
        $this->_login = $login;
        $this->_password = $password;
        $password = password_hash($password, PASSWORD_DEFAULT);
        //DB connection
        $pdo = $this->dbConnect();
        //PDO query preparation & execution
        $query = $pdo->prepare("INSERT INTO utilisateurs (login,password) VALUES (:login,:password)");
        $query->bindValue('login', $login, PDO::PARAM_STR);
        $query->bindValue('password', $password, PDO::PARAM_STR);
        $insertIsOk = $query->execute();
        if ($insertIsOk != true) {
            echo 'Data NOT inserted in DB, please check !! <br />';
        }
    }

    public function connect($login, $password)
    {
        //Connect the user to the DB
        $this->_login = $login;
        $this->_password = $password;
        //DB connection
        $pdo = $this->dbConnect();
        //PDO query preparation & execution
        $query = $pdo->prepare("SELECT * FROM utilisateurs WHERE login = :login");
        $query->bindValue(':login', $login);
        $query->execute();
        $result = $query->fetchAll();

        //Extract from array the password to check the hash
        if (!empty($result)) {
            foreach ($result as $item) {
            }
            //Test the password
            $passCheck = password_verify($password, $item['password']);
            if ($passCheck == true) {
                return $result; //return array
            } else {
                return false; //return false to display credentials alert
            }
        }
    }

    public function update($id, $newLogin, $newPassword)
    {
        $newPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        //Call DB connection
        $pdo = $this->dbConnect();
        //Update SQL request
        $query = $pdo->prepare("UPDATE utilisateurs SET login=:newLogin,password=:newPassword WHERE id_utilisateur=:id");
        $query->bindValue('newLogin', $newLogin, PDO::PARAM_STR);
        $query->bindValue(':newPassword', $newPassword, PDO::PARAM_STR);
        $query->bindValue(':id', $id, PDO::PARAM_STR);
        $query->execute();
        return $query;
    }

    //todo METHODS


    //     * createReservation
    //          INSERT reservation form in the DB

    //     * showAllUserReservation
    //          SELECT ALL reservations from the user using user_ID

    //     * showReservation
    //          SELECT ONE reservation from user using reservation_ID with a GET

    //     * calculatePlacePrice
    //          MULTIPLICATION between (number of days in the DateInterval from the
    //          reservation form) AND (PlacePrice) AND (CampingType) => totalPlacePrice

    //     * calculateOptionPrice
    //          ADDITION of all selected options in the reservation form => totalOptionPrice

    //     * calculateTotalPrice
    //          ADDITION between totalPlacePrice AND totalOptionPrice => bookingPriceTotal

    //     * createPriceBook
    //          INSERT in prestations DB all option and place informations and price
    //          and link it with reservation_ID

    //     * checkAllPriceBook
    //          SELECT ALL prestations from all reservation_ID AND user_ID

    //     * checkPriceBook
    //          SELECT ALL prestations from ONE reservation_ID

    //     * checkDisponibility
    //          SELECT ALL reservation BETWEEN startDate and endDate AND place
    //          IF the request return a result => NO DISPONIBILITY
    //          ELSE => DISPONIBILITY


    //     * linkReservationAndPrice
    //



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


    //SETTER
    public function login()
    {
        return $this->_login;
    }

    public function password()
    {
        return $this->_password;
    }

    public function id()
    {
        return $this->_id;
    }


    //GETTER
    public function setLogin($login)
    {
        //Check if the login is a string
        if (is_string($login)) {
            $this->_login = $login;
        }
    }

    public function setPassword($password)
    {
        //Check if the password is a string
        if (is_string($password)) {
            $this->_password = $password;
        }
    }

    public function setId($id)
    {
        //The user id will always be an integer
        $this->_id = (int)$id;
    }
}
