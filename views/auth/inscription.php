  <?php require_once VIEW_PATH.'/layout/header.php'; ?>
  <div class="register-container">
      <h2>Inscription</h2>
      <?php if (isset($_SESSION['msg'])) : ?>
          <div class="error-message"> <?= htmlspecialchars($_SESSION['msg']);unset($_SESSION['msg']); ?> </div>
      <?php endif; ?>
      <form action="/register" method="post">
          <div class="form-group">
              <label for="nom">Nom :</label>
              <input type="text" id="nom" name="nom" required>
          </div>
          <div class="form-group">
              <label for="prenom">Prénom :</label>
              <input type="text" id="prenom" name="prenom" required>
          </div>
          <div class="form-group">
            <label for="telephone">Téléphone :</label>
            <input type="text" id="telephone" name="telephone" required>
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
  <?php require_once VIEW_PATH.'/layout/footer.php'; ?>