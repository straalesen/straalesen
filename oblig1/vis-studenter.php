<?php
require "db.php";

$resultat = $db->query(
    "SELECT * FROM student ORDER BY etternavn, fornavn, brukernavn"
);
$studenter = $resultat->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="nb">
<head>
    <meta charset="UTF-8">
    <title>Alle studenter</title>
</head>
<body>
    <h1>Alle studenter</h1>

    <?php if (empty($studenter)): ?>
        <p>Ingen studenter er registrert.</p>
    <?php else: ?>
        <table border="1">
            <tr>
                <th>Brukernavn</th>
                <th>Fornavn</th>
                <th>Etternavn</th>
                <th>Klassekode</th>
            </tr>

            <?php foreach ($studenter as $student): ?>
                <tr>
                    <td><?= htmlspecialchars($student["brukernavn"]) ?></td>
                    <td><?= htmlspecialchars($student["fornavn"]) ?></td>
                    <td><?= htmlspecialchars($student["etternavn"]) ?></td>
                    <td><?= htmlspecialchars($student["klassekode"]) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>

    <p><a href="/app/sosta8553-straalesen/oblig1/index.php">Tilbake til menyen</a></p>
</body>
</html>