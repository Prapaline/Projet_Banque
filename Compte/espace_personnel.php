<?php
session_start();
if (!isset($_SESSION['clientId'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace Personnel</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Bienvenue, <?php echo $_SESSION['prenom'] . ' ' . $_SESSION['nom']; ?>!</h1>
        
        <div class="mt-3">
            <button class="btn btn-primary" onclick="window.location.href='liste_comptes.php'">Liste des comptes</button>
            <button class="btn btn-success" onclick="window.location.href='depot.php'">Déposer de l'argent</button>
            <button class="btn btn-success" onclick="window.location.href='retrait.php'">Retirer de l'argent</button>
            <button class="btn btn-info" onclick="window.location.href='virement.php'">Faire un virement</button>
            <button class="btn btn-warning" onclick="window.location.href='creer_compte.php'">Créer un compte</button>
            <button class="btn btn-danger" onclick="window.location.href='deconnexion.php'">Déconnexion</button>
        </div>
    </div>
</body>
</html>