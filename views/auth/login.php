 <?php require_once __DIR__ . '/../layout/header.php'; ?>
 <div class="login-container">
        <h2>Connexion</h2>
        <?php if (isset($_SESSION['msg'])) : ?>
            <div class="error-message"> <?= htmlspecialchars($_SESSION['msg']);unset($_SESSION['msg']); ?> </div>
        <?php endif; ?>
        <form action="/login" method="post">
            <div class="form-group">
                <label for="username">Nom d'utilisateur :</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="mdp">Mot de passe :</label>
                <input type="password" id="mdp" name="mdp" required>
            </div>
            <button type="submit">Se connecter</button>
        </form>
        <p>Pas encore de compte ? <a href="/register">Inscrivez-vous</a></p>
    </div>