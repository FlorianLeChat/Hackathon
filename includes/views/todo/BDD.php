<?php

    function getPDO() {
        $host = 'localhost';
        $db   = 'hackathon';
        $user = 'root';
        $pass = '';
        $charset = 'utf8';
        
        $dsn = "mysql:host=$host;dbname=$db;charset=$charset;port=3307";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        try {
            return new PDO($dsn, $user, $pass, $options);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    $pdo = getPDO();

?>
