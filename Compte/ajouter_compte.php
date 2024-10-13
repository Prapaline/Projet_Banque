<?php
session_start();
if (!isset($_SESSION['clientId'])) {
    header("Location: index.php");
    exit();
}

require 'db_connect.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $solde = $_POST['solde'];
    $typeDeCompte = $_POST['typeDeCompte'];
    $clientId = $_SESSION['clientId']; 
    $numeroCompte = $_POST['numeroCompte'];

    $query = "INSERT INTO comptebancaire (numeroCompte, solde, typeDeCompte, clientId) 
              VALUES (:numeroCompte, :solde, :typeDeCompte, :clientId)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([
        'numeroCompte' => $numeroCompte,
        'solde' => $solde,
        'typeDeCompte' => $typeDeCompte,
        'clientId' => $clientId
    ]);

    if ($stmt) {
        echo "Le compte bancaire a été créé avec succès.";
        header("Location: espace_personnel.php");
        exit();
    } else {
        echo "Erreur lors de la création du compte bancaire.";
    }
}
?>