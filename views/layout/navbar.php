<nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
    <a class="navbar-brand" href="/">MedInfo Burkina</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item"><a class="nav-link" href="/">Accueil</a></li>
            <?php if (!isset($_SESSION['token'])) : ?>
                <li class="nav-item"><a class="nav-link" href="/login">Connexion</a></li>
            <?php else : ?>
                <?php if (!empty($_SESSION['admin'])) : ?>
                    <li class="nav-item"><a class="nav-link" href="/admin/dashboard">Admin</a></li>
                    <li class="nav-item"><a class="nav-link" href="/admin/utilisateurs">Utilisateurs</a></li>
                    <li class="nav-item"><a class="nav-link" href="/admin/medecins">Médecins</a></li>
                    <li class="nav-item"><a class="nav-link" href="/admin/patients">Patients</a></li>
                <?php elseif (!empty($_SESSION['medecin'])) : ?>
                    <li class="nav-item"><a class="nav-link" href="/medecin/dashboard">Tableau de bord</a></li>
                    <li class="nav-item"><a class="nav-link" href="/medecin/rdv">Mes RDV</a></li>
                <?php elseif (!empty($_SESSION['patient'])) : ?>
                    <li class="nav-item"><a class="nav-link" href="/patient/dashboard">Tableau de bord</a></li>
                    <li class="nav-item"><a class="nav-link" href="/patient/mes_rdv">Mes RDV</a></li>
                    <li class="nav-item"><a class="nav-link" href="/patient/mon_dossier">Mon dossier</a></li>
                <?php endif; ?>
                <li class="nav-item"><a class="nav-link" href="/logout">Déconnexion</a></li>
            <?php endif; ?>
        </ul>
    </div>
</nav>