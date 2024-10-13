<?php
session_start();
if (!isset($_SESSION['clientId'])) {
    header("Location: index.php");
    exit();
}

require 'db_connect.php';

$clientId = $_SESSION['clientId'];
$query = "SELECT numeroCompte, dateOuverture, solde, typeDeCompte FROM comptebancaire WHERE clientId = :clientId";
$stmt = $pdo->prepare($query);
$stmt->execute(['clientId' => $clientId]);
$comptes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Comptes</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Liste de vos Comptes</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Numéro de Compte</th>
                    <th>Date d'Ouverture</th>
                    <th>Solde</th>
                    <th>Type de Compte</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($comptes) > 0): ?>
                    <?php foreach ($comptes as $compte): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($compte['numeroCompte']); ?></td>
                            <td><?php echo htmlspecialchars(date('d/m/Y', strtotime($compte['dateOuverture']))); ?></td>
                            <td><?php echo htmlspecialchars($compte['solde']); ?> €</td>
                            <td><?php echo htmlspecialchars($compte['typeDeCompte']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4">Aucun compte trouvé.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <button class="btn btn-primary" onclick="window.location.href='espace_personnel.php'">Retour à l'Espace Personnel</button>
    </div>
</body>
</html>