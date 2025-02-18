<?php

class BDD {

    private string $servername = "localhost";
    //gestion -> root
    private string $username = "root";
    //Gestion35500* -> ""
    private string $password = "";
    private $pdo;
    private string $currentQuery;
    //dbname=STOCK
    public function connect(): string {
        try {
            $this->pdo = new PDO("mysql:host=$this->servername;dbname=stockvc", $this->username, $this->password);
            $this ->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return ("Connecté à la base de données | ");
        }
        catch(Exception $e) {
            return ("Impossible de se connecter à la base de données: " .$e->getMessage().print nl2br("\n"));
        }
    }

    public function disconnect() {
        $this->pdo = null;
    }

    /** Getters/Setters **/
    public function getServerName(): string {
        return $this->servername;
    }

    public function getUserName(): string {
        return $this->username;
    }

    public function getPassword(): string {
        return $this->password;
    }

    public function getCurrentQuery(): string {
        return $this->currentQuery;
    }

    public function getPdo(): PDO {
        return $this->pdo;
    }

    public function setCurrentQuery(string $query) {
        $this->currentQuery = $query;
    }

    public function query(string $query) {
        $this->pdo->query($query);
    }
}

?>