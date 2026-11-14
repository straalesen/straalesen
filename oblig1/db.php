<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$vert = getenv("DB_HOST");
$database = getenv("DB_DATABASE");
$bruker = getenv("DB_USER");
$passord = getenv("DB_PASSWORD");

if (!$vert || !$database || !$bruker || $passord === false) {
    exit("Databaseinnstillingene mangler på serveren.");
}

try {
    $db = new mysqli($vert, $bruker, $passord, $database);
    $db->set_charset("utf8mb4");
} catch (mysqli_sql_exception $e) {
    exit("Kunne ikke koble til databasen.");
}