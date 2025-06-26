  <?php require_once __DIR__ . '/../layout/header.php'; ?>
  <div class="register-container">
      <h2>Inscription</h2>
      <?php if (isset($_SESSION['msg'])) : ?>
          <div class="error-message"> <?= htmlspecialchars($_SESSION['msg']);unset($_SESSION['msg']); ?> </div>
      <?php endif; ?>
      <form action="/register" method="post">
          <div class="form-group">
              <label for="username">Nom d'utilisateur :</label>
              <input type="text" id="username" name="username" required>
          </div>
          <div class="form-group">
              <label for="telephone">Téléphone :</label>
              <input type="tel" id="telephone" name="telephone" required>
          </div>
          <div class="form-group">
            <label for="num_pav">Numéro de pavillon :</label>
            <input type="text" id="num_pav" name="num_pav" required>
          </div>
          <div class="form-group">
              <label for="mdp">Mot de passe :</label>
              <input type="password" id="mdp" name="mdp" required>
          </div>
          <div class="form-group">
              <label for="mdp2">Confirmer le mot de passe :</label>
              <input type="password" id="mdp2" name="mdp2" required>
          </div>
          <button type="submit">S'inscrire</button>
      </form>
      <p>Déjà un compte ? <a href="/login">Connectez-vous</a></p>
  </div>