<?php
require "db.php";

$melding = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $klassekode = trim($_POST["klassekode"] ?? "");

    if ($klassekode === "") {
        $melding = "Du må velge en klasse.";
    } else {
        try {
            $sporring = $db->prepare(
                "DELETE FROM klasse WHERE klassekode = ?"
            );
            $sporring->bind_param("s", $klassekode);
            $sporring->execute();

            if ($sporring->affected_rows > 0) {
                $melding = "Klassen er slettet.";
            } else {
                $melding = "Klassen finnes ikke lenger.";
            }
        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() === 1451) {
                $melding = "Klassen kan ikke slettes fordi den har studenter.";
            } else {
                $melding = "Kunne ikke slette klassen.";
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
    <title>Slett klasse</title>
</head>
<body>
    <h1>Slett klasse</h1>

    <p><?= htmlspecialchars($melding, ENT_QUOTES, "UTF-8") ?></p>

    <?php if (empty($klasser)): ?>
        <p>Ingen klasser å slette.</p>
    <?php else: ?>
        <form method="post"
              onsubmit="return confirm('Er du sikker på at du vil slette klassen?');">
            <p>
                <label for="klassekode">Velg klasse:</label><br>
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

            <button type="submit">Slett klasse</button>
        </form>
    <?php endif; ?>

    <p><a href="/app/sosta8553-straalesen/oblig1/index.php">Tilbake til menyen</a></p>
</body>
</html>