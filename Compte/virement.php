<?php
session_start();
if (!isset($_SESSION['clientId'])) {
    header("Location: index.php");
    exit();
}

require 'db_connect.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $compteSourceId = $_POST['compteSourceId'];
    $compteDestId = $_POST['compteDestId'];
    $montantVirement = $_POST['montantVirement'];

    $query = "SELECT solde FROM comptebancaire WHERE compteId = :compteSourceId";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['compteSourceId' => $compteSourceId]);
    $compteSource = $stmt->fetch();

    if ($compteSource && $compteSource['solde'] >= $montantVirement) {
        $query = "SELECT * FROM comptebancaire WHERE compteId = :compteDestId";
        $stmt = $pdo->prepare($query);
        $stmt->execute(['compteDestId' => $compteDestId]);
        $compteDest = $stmt->fetch();

        if ($compteDest) {
            $pdo->beginTransaction();

            $query = "UPDATE comptebancaire SET solde = solde - :montant WHERE compteId = :compteSourceId";
            $stmt = $pdo->prepare($query);
            $stmt->execute(['montant' => $montantVirement, 'compteSourceId' => $compteSourceId]);

            $query = "UPDATE comptebancaire SET solde = solde + :montant WHERE compteId = :compteDestId";
            $stmt = $pdo->prepare($query);
            $stmt->execute(['montant' => $montantVirement, 'compteDestId' => $compteDestId]);

            $pdo->commit();

            echo "Le virement de " . htmlspecialchars($montantVirement) . " € a été effectué avec succès.";
            header("Location: espace_personnel.php");
            exit();
        } else {
            echo "Erreur : Compte destinataire introuvable.";
        }
    } else {
        echo "Erreur : Solde insuffisant pour ce virement.";
    }
}

$clientId = $_SESSION['clientId'];
$query = "SELECT compteId, numeroCompte, solde FROM comptebancaire WHERE clientId = :clientId";
$stmt = $pdo->prepare($query);
$stmt->execute(['clientId' => $clientId]);
$comptesSource = $stmt->fetchAll(PDO::FETCH_ASSOC);

$query = "SELECT compteId, numeroCompte FROM comptebancaire WHERE clientId != :clientId";
$stmt = $pdo->prepare($query);
$stmt->execute(['clientId' => $clientId]);
$comptesDest = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Effectuer un Virement</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Effectuer un Virement</h2>
        <form method="POST" action="virement.php">
            <div class="form-group">
                <label for="compteSourceId">Choisir votre compte</label>
                <select class="form-control" id="compteSourceId" name="compteSourceId" required>
                    <?php foreach ($comptesSource as $compte): ?>
                        <option value="<?php echo htmlspecialchars($compte['compteId']); ?>">
                            <?php echo htmlspecialchars($compte['numeroCompte']); ?> (Solde : <?php echo htmlspecialchars($compte['solde']); ?> €)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="compteDestId">Choisir un compte destinataire</label>
                <select class="form-control" id="compteDestId" name="compteDestId" required>
                    <?php foreach ($comptesDest as $compte): ?>
                        <option value="<?php echo htmlspecialchars($compte['compteId']); ?>">
                            <?php echo htmlspecialchars($compte['numeroCompte']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="montantVirement">Montant du virement</label>
                <input type="number" class="form-control" id="montantVirement" name="montantVirement" placeholder="Montant" min="1" required>
            </div>
            <button type="submit" class="btn btn-primary">Effectuer le virement</button>
        </form>
        <button class="btn btn-secondary mt-3" onclick="window.location.href='espace_personnel.php'">Retour à l'Espace Personnel</button>
    </div>
</body>
</html>