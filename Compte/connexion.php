<?php
session_start();
require 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $mdp = $_POST['mdp'];

    $query = "SELECT * FROM client WHERE email = :email";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['email' => $email]);
    $client = $stmt->fetch();

    if ($client && password_verify($mdp, $client['mdp'])) {
        $_SESSION['clientId'] = $client['clientId'];
        $_SESSION['nom'] = $client['nom'];
        $_SESSION['prenom'] = $client['prenom'];

        header("Location: espace_personnel.php");
        exit();
    } else {
        echo "Identifiants incorrects.";
    }
}
?>