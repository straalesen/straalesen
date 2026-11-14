<?php
require "db.php";

$melding = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $klassekode = trim($_POST["klassekode"] ?? "");
    $klassenavn = trim($_POST["klassenavn"] ?? "");
    $studiumkode = trim($_POST["studiumkode"] ?? "");

    if ($klassekode === "" || $klassenavn === "" || $studiumkode === "") {
        $melding = "Du må fylle ut alle feltene.";
    } elseif (
        mb_strlen($klassekode) > 5 ||
        mb_strlen($klassenavn) > 50 ||
        mb_strlen($studiumkode) > 50
    ) {
        $melding = "Et eller flere felt inneholder for mange tegn.";
    } else {
        try {
            $sql = "INSERT INTO klasse
                    (klassekode, klassenavn, studiumkode)
                    VALUES (?, ?, ?)";

            $sporring = $db->prepare($sql);
            $sporring->bind_param(
                "sss",
                $klassekode,
                $klassenavn,
                $studiumkode
            );
            $sporring->execute();

            $melding = "Klassen er registrert!";
        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() === 1062) {
                $melding = "Klassekoden finnes allerede. Velg en annen.";
            } else {
                $melding = "Kunne ikke registrere klassen.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="nb">
<head>
    <meta charset="UTF-8">
    <title>Registrer klasse</title>
</head>
<body>
    <h1>Registrer klasse</h1>

    <p><?= htmlspecialchars($melding, ENT_QUOTES, "UTF-8") ?></p>

    <form method="post">
        <p>
            <label for="klassekode">Klassekode:</label><br>
            <input type="text" id="klassekode" name="klassekode"
                   maxlength="5" required>
        </p>

        <p>
            <label for="klassenavn">Klassenavn:</label><br>
            <input type="text" id="klassenavn" name="klassenavn"
                   maxlength="50" required>
        </p>

        <p>
            <label for="studiumkode">Studiumkode:</label><br>
            <input type="text" id="studiumkode" name="studiumkode"
                   maxlength="50" required>
        </p>

        <button type="submit">Registrer klasse</button>
    </form>

    <p><a href="/app/sosta8553-straalesen/oblig1/index.php">Tilbake til menyen</a></p>
</body>
</html>