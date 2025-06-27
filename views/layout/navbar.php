<nav></nav>
    <ul>
        <li><a href="/">Accueil</a></li>
        <li><a href="/login">Connexion</a></li>
        <li><a href="/profil">Profil</a></li>
        <?php if (isset($_SESSION['token'])) : ?>
            <li><a href="/logout">Déconnexion</a></li>
        <?php endif; ?>
    </ul>
</nav>