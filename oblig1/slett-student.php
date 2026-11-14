<?php
require "db.php";

$melding = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $brukernavn = trim($_POST["brukernavn"] ?? "");

    if ($brukernavn === "") {
        $melding = "Du må velge en student.";
    } else {
        try {
            $sporring = $db->prepare(
                "DELETE FROM student WHERE brukernavn = ?"
            );
            $sporring->execute([$brukernavn]);

            if ($sporring->rowCount() > 0) {
                $melding = "Studenten er slettet.";
            } else {
                $melding = "Studenten finnes ikke lenger.";
            }
        } catch (PDOException $e) {
            $melding = "Kunne ikke slette studenten.";
        }
    }
}

$sporring = $db->query(
    "SELECT * FROM student ORDER BY etternavn, fornavn, brukernavn"
);
$studenter = $sporring->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="nb">
<head>
    <meta charset="UTF-8">
    <title>Slett student</title>
</head>
<body>
    <h1>Slett student</h1>

    <p><?= htmlspecialchars($melding, ENT_QUOTES, "UTF-8") ?></p>

    <?php if (empty($studenter)): ?>
        <p>Ingen studenter å slette.</p>
    <?php else: ?>
        <form method="post"
              onsubmit="return confirm('Er du sikker på at du vil slette studenten?');">
            <p>
                <label for="brukernavn">Velg student:</label><br>
                <select id="brukernavn" name="brukernavn" required>
                    <option value="">Velg student</option>

                    <?php foreach ($studenter as $student): ?>
                        <option value="<?= htmlspecialchars(
                            $student["brukernavn"], ENT_QUOTES, "UTF-8"
                        ) ?>">
                            <?= htmlspecialchars(
                                $student["brukernavn"] . " – " .
                                $student["fornavn"] . " " .
                                $student["etternavn"],
                                ENT_QUOTES,
                                "UTF-8"
                            ) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </p>

            <button type="submit">Slett student</button>
        </form>
    <?php endif; ?>

    <p><a href="index.php">Tilbake til menyen</a></p>
</body>
</html>