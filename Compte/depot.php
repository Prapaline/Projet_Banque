<?php
session_start();
if (!isset($_SESSION['clientId'])) {
    header("Location: index.php");
    exit();
}

require 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $montantDepot = $_POST['montantDepot'];
    $compteId = $_POST['compteId'];

    $query = "UPDATE comptebancaire SET solde = solde + :montantDepot WHERE compteId = :compteId";
    $stmt = $pdo->prepare($query);
    $stmt->execute([
        'montantDepot' => $montantDepot,
        'compteId' => $compteId
    ]);

    if ($stmt) {
        echo "Le dépôt de " . htmlspecialchars($montantDepot) . " € a été effectué avec succès.";
        header("Location: espace_personnel.php"); 
        exit();
    } else {
        echo "Erreur lors du dépôt d'argent.";
    }
}

$clientId = $_SESSION['clientId'];
$query = "SELECT compteId, numeroCompte, solde FROM comptebancaire WHERE clientId = :clientId";
$stmt = $pdo->prepare($query);
$stmt->execute(['clientId' => $clientId]);
$comptes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dépôt d'Argent</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Dépôt d'Argent</h2>
        <form method="POST" action="depot.php">
            <div class="form-group">
                <label for="compteId">Choisir un Compte</label>
                <select class="form-control" id="compteId" name="compteId" required>
                    <?php foreach ($comptes as $compte): ?>
                        <option value="<?php echo htmlspecialchars($compte['compteId']); ?>">
                            <?php echo htmlspecialchars($compte['numeroCompte']); ?> (Solde actuel : <?php echo htmlspecialchars($compte['solde']); ?> €)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="montantDepot">Montant à Déposer</label>
                <input type="number" class="form-control" id="montantDepot" name="montantDepot" placeholder="Montant" min="10" required>
            </div>
            <button type="submit" class="btn btn-primary">Déposer de l'argent</button>
        </form>
        <button class="btn btn-secondary mt-3" onclick="window.location.href='espace_personnel.php'">Retour à l'Espace Personnel</button>
    </div>
</body>
</html>