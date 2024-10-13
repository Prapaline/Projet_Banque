<?php
session_start();
if (!isset($_SESSION['clientId'])) {
    header("Location: index.php");
    exit();
}

require 'db_connect.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $montantRetrait = $_POST['montantRetrait'];
    $compteId = $_POST['compteId']; 

    $query = "SELECT solde FROM comptebancaire WHERE compteId = :compteId";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['compteId' => $compteId]);
    $compte = $stmt->fetch();

    if ($compte) {
        $soldeActuel = $compte['solde'];

        if ($montantRetrait > $soldeActuel) {
            echo "Erreur : Le montant à retirer dépasse le solde actuel de " . htmlspecialchars($soldeActuel) . " €.";
        } else {
            $query = "UPDATE comptebancaire SET solde = solde - :montantRetrait WHERE compteId = :compteId";
            $stmt = $pdo->prepare($query);
            $stmt->execute([
                'montantRetrait' => $montantRetrait,
                'compteId' => $compteId
            ]);

            if ($stmt) {
                echo "Le retrait de " . htmlspecialchars($montantRetrait) . " € a été effectué avec succès.";
                header("Location: espace_personnel.php");
                exit();
            } else {
                echo "Erreur lors du retrait d'argent.";
            }
        }
    } else {
        echo "Erreur : Compte introuvable.";
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
    <title>Retrait d'Argent</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Retrait d'Argent</h2>
        <form method="POST" action="retrait.php">
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
                <label for="montantRetrait">Montant à Retirer</label>
                <input type="number" class="form-control" id="montantRetrait" name="montantRetrait" placeholder="Montant" min="10" required>
            </div>
            <button type="submit" class="btn btn-primary">Retirer de l'argent</button>
        </form>
        <button class="btn btn-secondary mt-3" onclick="window.location.href='espace_personnel.php'">Retour à l'Espace Personnel</button>
    </div>
</body>
</html>