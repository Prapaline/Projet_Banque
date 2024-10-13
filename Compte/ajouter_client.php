<?php
require 'db_connect.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = htmlspecialchars($_POST['nom']);
    $prenom = htmlspecialchars($_POST['prenom']);
    $telephone = htmlspecialchars($_POST['telephone']);
    $email = htmlspecialchars($_POST['email']);
    $mdp = password_hash($_POST['mdp'], PASSWORD_BCRYPT); 

    $sql = "INSERT INTO client (nom, prenom, telephone, email, mdp) 
            VALUES (:nom, :prenom, :telephone, :email, :mdp)";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':nom' => $nom,
            ':prenom' => $prenom,
            ':telephone' => $telephone,
            ':email' => $email,
            ':mdp' => $mdp
        ]);
        echo "Inscription réussie !";
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}
?>