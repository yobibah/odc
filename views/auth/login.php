<?php require_once VIEW_PATH.'/layout/header.php'; ?>

<div class="container d-flex justify-content-center align-items-center" style="min-height: 70vh;">
    <div class="card shadow p-4" style="min-width:350px;max-width:400px;width:100%;">
        <h2 class="mb-4 text-center">Connexion</h2>
        <?php if (isset($_SESSION['msg'])) : ?>
            <div class="alert alert-danger text-center"> <?= htmlspecialchars($_SESSION['msg']);unset($_SESSION['msg']); ?> </div>
        <?php endif; ?>
        <form action="/login" method="post">
            <div class="form-group">
                <label for="telephone">Téléphone</label>
                <input type="text" class="form-control" id="telephone" name="telephone" required>
            </div>
            <div class="form-group">
                <label for="mdp">Mot de passe</label>
                <input type="password" class="form-control" id="mdp" name="mdp" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Se connecter</button>
        </form>
        <p class="mt-3 text-center">Pas encore de compte ? <a href="/register">Inscrivez-vous</a></p>
    </div>
</div>

<?php require_once VIEW_PATH.'/layout/footer.php'; ?>