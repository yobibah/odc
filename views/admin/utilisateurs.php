<?php require_once VIEW_PATH.'layout/header.php'; ?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Liste des utilisateurs</h2>
        <form class="form-inline" method="get" action="">
            <input class="form-control mr-2" type="search" name="q" placeholder="Filtrer par nom, téléphone..." aria-label="Filtre">
            <button class="btn btn-outline-primary" type="submit">Filtrer</button>
        </form>
        <a href="/admin/utilisateurs/ajouter" class="btn btn-primary ml-3">Créer un utilisateur</a>
    </div>
    <table class="table table-striped table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Téléphone</th>
                <th>Rôle</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data['utilisateurs'] as $utilisateur): ?>
            <tr>
                <td><?= htmlspecialchars($utilisateur['nom']) ?></td>
                <td><?= htmlspecialchars($utilisateur['prenom']) ?></td>
                <td><?= htmlspecialchars($utilisateur['telephone']) ?></td>
                <td><?= htmlspecialchars($utilisateur['role']) ?></td>
                <td>
                    <a href="/admin/utilisateurs/modifier/<?= $utilisateur['id'] ?>" class="btn btn-sm btn-warning">Modifier</a>
                    <a href="/admin/utilisateurs/supprimer/<?= $utilisateur['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer cet utilisateur ?');">Supprimer</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require_once VIEW_PATH.'layout/footer.php'; ?>