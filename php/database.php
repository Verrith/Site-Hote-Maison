<?php
class Database {
    private $host = "localhost";
    private $dbname = "hote_maison_donnee";
    private $user = "root";
    private $pass = "";

    public function getConnection() {
        try {
            $pdo = new PDO(
                "mysql:host=".$this->host.";dbname=".$this->dbname.";charset=utf8",
                $this->user,
                $this->pass
            );
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;

        } catch (PDOException $e) {
            die("Erreur DB: " . $e->getMessage());
        }
    }
}
// LCC
?>