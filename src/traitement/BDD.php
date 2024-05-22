<?php

class BDD {

    private string $servername = "localhost";
    private string $username = "root";
    private string $password = "";
    private $pdo;
    private string $currentQuery;
    
    public function connect() {
        try {
            $this->pdo = new PDO("mysql:host=$this->servername;dbname=stockvc", $this->username, $this->password);
            $this ->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            print("Connecté à la base de données\n");
            print nl2br("\n");
        }
        catch(Exception $e) {
            die("Impossible de se connecter à la base de données\n" .$e->getMessage());
        }
    }

    public function disconnect() {
        $this->pdo = null;
    }

    /** Getters/Setters
     */
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













}

?>