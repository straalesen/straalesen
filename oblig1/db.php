<?php
$vert = "127.0.0.1";
$database = "prg120_oblig1";
$bruker = "root";
$passord = "";

try {
    $db = new PDO(
        "mysql:host=$vert;dbname=$database;charset=utf8mb4",
        $bruker,
        $passord
    );

    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    exit("Kunne ikke koble til databasen.");
}