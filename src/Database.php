<?php
class Database {
    private $pdo = null;
    
    public function __construct($dbconfig) {
        try {
            $this->pdo = new PDO("mysql:host={$dbconfig['host']};dbname={$dbconfig['dbname']}",
                $dbconfig['user'], $dbconfig['password']);
            
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo 'Error connecting to database: ' . $e->getMessage();
        }
    }

    public function query($query, $params = []) {
        try {
            $stmt = $this->pdo->prepare($query);

            $stmt->execute($params);

            if(strncasecmp(ltrim($query), 'select', 6) === 0) {
                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

                return $rows;
            }

            return true;
        } catch(PDOException $e) {
            echo 'Error querying database: ' . $e->getMessage();
        }

        return false;
    }
}