<?php
require "db.php";

$melding = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $brukernavn = trim($_POST["brukernavn"] ?? "");
    $fornavn = trim($_POST["fornavn"] ?? "");
    $etternavn = trim($_POST["etternavn"] ?? "");
    $klassekode = trim($_POST["klassekode"] ?? "");

    if (
        $brukernavn === "" || $fornavn === "" ||
        $etternavn === "" || $klassekode === ""
    ) {
        $melding = "Du må fylle ut alle feltene.";
    } elseif (
        mb_strlen($brukernavn) > 7 ||
        mb_strlen($fornavn) > 50 ||
        mb_strlen($etternavn) > 50 ||
        mb_strlen($klassekode) > 5
    ) {
        $melding = "Et eller flere felt inneholder for mange tegn.";
    } else {
        try {
            $sql = "INSERT INTO student
                    (brukernavn, fornavn, etternavn, klassekode)
                    VALUES (?, ?, ?, ?)";

            $sporring = $db->prepare($sql);
            $sporring->bind_param(
                "ssss",
                $brukernavn,
                $fornavn,
                $etternavn,
                $klassekode
            );
            $sporring->execute();

            $melding = "Studenten er registrert!";
        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() === 1062) {
                $melding = "Brukernavnet finnes allerede. Velg et annet.";
            } elseif ($e->getCode() === 1452) {
                $melding = "Klassen finnes ikke. Velg en gyldig klasse.";
            } else {
                $melding = "Kunne ikke registrere studenten.";
            }
        }
    }
}

$resultat = $db->query("SELECT * FROM klasse ORDER BY klassekode");
$klasser = $resultat->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="nb">
<head>
    <meta charset="UTF-8">
    <title>Registrer student</title>
</head>
<body>
    <h1>Registrer student</h1>

    <p><?= htmlspecialchars($melding, ENT_QUOTES, "UTF-8") ?></p>

    <?php if (empty($klasser)): ?>
        <p>Du må registrere en klasse før du kan registrere studenter.</p>
        <p><a href="registrer-klasse.php">Registrer klasse</a></p>
    <?php else: ?>
        <form method="post">
            <p>
                <label for="brukernavn">Brukernavn:</label><br>
                <input type="text" id="brukernavn" name="brukernavn"
                       maxlength="7" required>
            </p>

            <p>
                <label for="fornavn">Fornavn:</label><br>
                <input type="text" id="fornavn" name="fornavn"
                       maxlength="50" required>
            </p>

            <p>
                <label for="etternavn">Etternavn:</label><br>
                <input type="text" id="etternavn" name="etternavn"
                       maxlength="50" required>
            </p>

            <p>
                <label for="klassekode">Klasse:</label><br>
                <select id="klassekode" name="klassekode" required>
                    <option value="">Velg klasse</option>

                    <?php foreach ($klasser as $klasse): ?>
                        <option value="<?= htmlspecialchars(
                            $klasse["klassekode"], ENT_QUOTES, "UTF-8"
                        ) ?>">
                            <?= htmlspecialchars(
                                $klasse["klassekode"] . " – " .
                                $klasse["klassenavn"],
                                ENT_QUOTES,
                                "UTF-8"
                            ) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </p>

            <button type="submit">Registrer student</button>
        </form>
    <?php endif; ?>

    <p><a href="index.php">Tilbake til menyen</a></p>
</body>
</html>