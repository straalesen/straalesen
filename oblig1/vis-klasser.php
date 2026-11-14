<?php
require "db.php";

$resultat = $db->query("SELECT * FROM klasse ORDER BY klassekode");
$klasser = $resultat->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="nb">
<head>
    <meta charset="UTF-8">
    <title>Alle klasser</title>
</head>
<body>
    <h1>Alle klasser</h1>

    <?php if (empty($klasser)): ?>
        <p>Ingen klasser er registrert.</p>
    <?php else: ?>
        <table border="1">
            <tr>
                <th>Klassekode</th>
                <th>Klassenavn</th>
                <th>Studiumkode</th>
            </tr>

            <?php foreach ($klasser as $klasse): ?>
                <tr>
                    <td><?= htmlspecialchars($klasse["klassekode"]) ?></td>
                    <td><?= htmlspecialchars($klasse["klassenavn"]) ?></td>
                    <td><?= htmlspecialchars($klasse["studiumkode"]) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>

    <p><a href="index.php">Tilbake til menyen</a></p>
</body>
</html>