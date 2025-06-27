<?php require_once VIEW_PATH.'/layout/header.php'; ?>

<div class="container d-flex justify-content-center align-items-center" style="min-height: 70vh;">
    <div class="card shadow p-4" style="min-width:350px;max-width:450px;width:100%;">
        <h2 class="mb-4 text-center">Inscription</h2>
        <?php if (isset($_SESSION['msg'])) : ?>
            <div class="alert alert-danger text-center"> <?= htmlspecialchars($_SESSION['msg']);unset($_SESSION['msg']); ?> </div>
        <?php endif; ?>
        <form action="/register" method="post">
            <div class="form-group">
                <label for="nom">Nom</label>
                <input type="text" class="form-control" id="nom" name="nom" required>
            </div>
            <div class="form-group">
                <label for="prenom">Prénom</label>
                <input type="text" class="form-control" id="prenom" name="prenom" required>
            </div>
            <div class="form-group">
                <label for="telephone">Téléphone</label>
                <input type="text" class="form-control" id="telephone" name="telephone" required>
            </div>
            <div class="form-group">
                <label for="mdp">Mot de passe</label>
                <input type="password" class="form-control" id="mdp" name="mdp" required>
            </div>
            <div class="form-group">
                <label for="mdp2">Confirmer le mot de passe</label>
                <input type="password" class="form-control" id="mdp2" name="mdp2" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">S'inscrire</button>
        </form>
        <p class="mt-3 text-center">Déjà un compte ? <a href="/login">Connectez-vous</a></p>
    </div>
</div>

<?php require_once VIEW_PATH.'/layout/footer.php'; ?>