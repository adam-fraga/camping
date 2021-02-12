<?php

class Staff
{
    //ATTRIBUTES
    //private $_id; todo not useful for now
    private $_login;

    //METHODS

    public function userList()
    {
        $pdo = $this->dbConnect();
        $query = $pdo->prepare("SELECT * FROM utilisateurs WHERE staff IS NULL");
        $query->execute();
        $result = $query->fetchAll();
        return $result;
    }

    public function staffList()
    {
        $pdo = $this->dbConnect();
        $query = $pdo->prepare("SELECT * FROM utilisateurs WHERE staff IS NOT NULL");
        $query->execute();
        $result = $query->fetchAll();
        return $result;
    }

    public function addAdmin($login)
    {
        $this->_login = $login;
        $staff = 1;
        $pdo = $this->dbConnect();
        $query = $pdo->prepare("UPDATE utilisateurs SET staff=:staff WHERE login=:login");
        $query->bindValue(':staff', $staff, PDO::PARAM_BOOL);
        $query->bindValue(':login', $login, PDO::PARAM_STR);
        $query->execute();
        return $query;
    }

    public function removeAdmin($login)
    {
        $this->_login = $login;
        $pdo = $this->dbConnect();
        $query = $pdo->prepare("UPDATE utilisateurs SET staff = NULL WHERE login=:login");
        $query->bindValue(':login', $login, PDO::PARAM_STR);
        $query->execute();
        return $query;
    }

    //todo eventList

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

    public function setId($id)
    {
        //The user id will always be an integer
        $this->_id = (int)$id;
    }
}
