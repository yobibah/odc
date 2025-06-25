<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tester le Paiement</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f9fb;
            padding: 2rem;
            text-align: center;
        }
        form {
            display: inline-block;
            background: #fff;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        input, button {
            padding: 0.7rem;
            width: 100%;
            margin-top: 1rem;
        }
    </style>
</head>
<body>
    <h2>Lancer une vérification de paiement</h2>
    <form action="/ipn/paiement" method="post">
        <label for="token">Token de paiement :</label>
        <input type="text" name="token" id="token" required placeholder="Entrez le token reçu">
        <button type="submit">Vérifier le paiement</button>
    </form>
</body>
</html>
