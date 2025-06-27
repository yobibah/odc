<?php require_once VIEW_PATH.'layout/header.php'; ?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Liste des médecins</h2>
        <a href="/admin/medecins/ajouter" class="btn btn-primary">Ajouter un médecin</a>
    </div>
    <table class="table table-striped table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Spécialité</th>
                <th>Centre de santé</th>
                <th>Téléphone</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data['medecins'] as $medecin): ?>
            <tr>
                <td><?= htmlspecialchars($medecin['nom']) ?></td>
                <td><?= htmlspecialchars($medecin['prenom']) ?></td>
                <td><?= htmlspecialchars($medecin['specialite']) ?></td>
                <td><?= htmlspecialchars($medecin['centre_sante']) ?></td>
                <td><?= htmlspecialchars($medecin['telephone']) ?></td>
                <td>
                    <a href="/admin/medecins/modifier/<?= $medecin['id'] ?>" class="btn btn-sm btn-warning">Modifier</a>
                    <a href="/admin/medecins/supprimer/<?= $medecin['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer ce médecin ?');">Supprimer</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require_once VIEW_PATH.'layout/footer.php'; ?>