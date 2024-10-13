<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription Client</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2>Formulaire d'inscription</h2>
        <form method="POST" action="ajouter_client.php">
            <div class="form-group">
                <label for="nom">Nom</label>
                <input type="text" class="form-control" id="nom" name="nom" placeholder="Nom" required>
            </div>
            <div class="form-group">
                <label for="prenom">Prénom</label>
                <input type="text" class="form-control" id="prenom" name="prenom" placeholder="Prénom" required>
            </div>
            <div class="form-group">
                <label for="telephone">Téléphone</label>
                <input type="tel" class="form-control" id="telephone" name="telephone" placeholder="Téléphone">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
            </div>
            <div class="form-group">
                <label for="mdp">Mot de passe</label>
                <input type="password" class="form-control" id="mdp" name="mdp" placeholder="Mot de passe" required>
            </div>
            <button type="submit" class="btn btn-primary">S'inscrire</button>
        </form>
    </div>
</body>
</html>