<?php
header("Content-Type: text/plain; charset=utf-8");

echo "PDO MySQL: " . (extension_loaded("pdo_mysql") ? "Ja" : "Nei") . "\n";
echo "mbstring: " . (extension_loaded("mbstring") ? "Ja" : "Nei") . "\n";

echo "\nNavn på tilgjengelige databaseinnstillinger:\n";

foreach (getenv() as $navn => $verdi) {
    if (preg_match('/DB|MYSQL|DATABASE/i', $navn)) {
        echo $navn . "\n";
    }
}