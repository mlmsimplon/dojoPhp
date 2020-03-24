<?php

/**
 * Connexion à la base de données
 */

function getPDO() {
    try {
        $pdo = new PDO('mysql:dbname=dojoPhp;host=localhost','marie','12345');
        $pdo->exec("SET CHARACTER SET utf8");
        return $pdo;
    }catch(PDOException $e) {
        var_dump($e);
    }
}

function countDatabaseValue($connexionBDD, $key, $value) {
    $req = "SELECT * FROM Utilisateur WHERE $key = ?";
    $rowCount = $connexionBDD->prepare($req);
    $rowCount->execute(array($value));
    return $rowCount->rowCount();
}