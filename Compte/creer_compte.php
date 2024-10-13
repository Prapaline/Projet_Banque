<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un compte bancaire</title>
    <link rel="stylesheet" href="path/to/bootstrap.css">
    <style>
        .error {
            color: red;
            font-size: 0.9em;
        }
    </style>
    <script>
        function validateFieldOnBlur(event) {
            var input = event.target;
            var errorId = input.id + "Error";
            var isValid = true;

            if (input.id === "numeroCompte" && (input.value.length < 5 || input.value.length > 15)) {
                document.getElementById("numeroCompteError").textContent = "Le numéro de compte doit contenir entre 5 et 15 caractères.";
                isValid = false;
            }

            if (input.id === "solde" && (input.value < 10 || input.value > 2000)) {
                document.getElementById("soldeError").textContent = "Le solde doit être compris entre 10 et 2000.";
                isValid = false;
            }

            if (input.id === "typeDeCompte" && (input.value !== "Courant" && input.value !== "Epargne" && input.value !== "Entreprise")) {
                document.getElementById("typeDeCompteError").textContent = "Le type de compte doit être 'Courant', 'Épargne', ou 'Entreprise'.";
                isValid = false;
            }

            if (isValid) {
                document.getElementById(errorId).textContent = "";
            }
        }

        function validateForm() {
            let isValid = true;

            document.querySelectorAll(".error").forEach(function (el) {
                el.textContent = "";
            });

            var numeroCompte = document.getElementById("numeroCompte").value;
            if (numeroCompte.length < 5 || numeroCompte.length > 15) {
                document.getElementById("numeroCompteError").textContent = "Le numéro de compte doit contenir entre 5 et 15 caractères.";
                isValid = false;
            }

            var solde = document.getElementById("solde").value;
            if (solde < 10 || solde > 2000) {
                document.getElementById("soldeError").textContent = "Le solde doit être compris entre 10 et 2000.";
                isValid = false;
            }

            var typeDeCompte = document.getElementById("typeDeCompte").value;
            if (typeDeCompte !== "Courant" && typeDeCompte !== "Epargne" && typeDeCompte !== "Entreprise") {
                document.getElementById("typeDeCompteError").textContent = "Le type de compte doit être 'Courant', 'Épargne', ou 'Entreprise'.";
                isValid = false;
            }

            return isValid;
        }

        window.onload = function () {
            document.getElementById("numeroCompte").addEventListener("blur", validateFieldOnBlur);
            document.getElementById("solde").addEventListener("blur", validateFieldOnBlur);
            document.getElementById("typeDeCompte").addEventListener("blur", validateFieldOnBlur);
            document.getElementById("password").addEventListener("blur", validateFieldOnBlur);
        };
    </script>
</head>
<body>
    <div class="container">
        <h2>Créer un compte bancaire</h2>
        <form method="POST" action="ajouter_compte.php" onsubmit="return validateForm()">
            <div class="form-group">
                <label for="numeroCompte">Numéro de compte</label>
                <input type="text" class="form-control" id="numeroCompte" name="numeroCompte" placeholder="Numéro de compte" required>
                <span class="error" id="numeroCompteError"></span>
            </div>
            <div class="form-group">
                <label for="solde">Solde initial</label>
                <input type="number" class="form-control" id="solde" name="solde" placeholder="Solde initial" min="10" max="2000" required>
                <span class="error" id="soldeError"></span> 
            </div>
            <div class="form-group">
                <label for="typeDeCompte">Type de compte</label>
                <select class="form-control" id="typeDeCompte" name="typeDeCompte" required>
                    <option value="Courant">Courant</option>
                    <option value="Epargne">Épargne</option>
                    <option value="Entreprise">Entreprise</option>
                </select>
                <span class="error" id="typeDeCompteError"></span> 
            </div>
            <button type="submit" class="btn btn-primary">Créer compte</button>
        </form>
    </div>
</body>
</html>