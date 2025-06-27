<?php require_once VIEW_PATH.'layout/header.php'; ?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Liste des patients</h2>
        <form class="form-inline" method="get" action="">
            <input class="form-control mr-2" type="search" name="q" placeholder="Rechercher un patient..." aria-label="Recherche">
            <button class="btn btn-outline-primary" type="submit">Rechercher</button>
        </form>
    </div>
    <table class="table table-striped table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Téléphone</th>
                <th>Date de naissance</th>
                <th>Sexe</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data['patients'] as $patient): ?>
            <tr>
                <td><?= htmlspecialchars($patient['nom']) ?></td>
                <td><?= htmlspecialchars($patient['prenom']) ?></td>
                <td><?= htmlspecialchars($patient['telephone']) ?></td>
                <td><?= htmlspecialchars($patient['date_naissance']) ?></td>
                <td><?= htmlspecialchars($patient['sexe']) ?></td>
                <td>
                    <a href="/admin/patients/dossier/<?= $patient['id'] ?>" class="btn btn-sm btn-info">Voir dossier</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <!-- Pagination (exemple statique) -->
    <nav aria-label="Pagination patients">
        <ul class="pagination justify-content-center">
            <li class="page-item disabled"><a class="page-link" href="#">Précédent</a></li>
            <li class="page-item active"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item"><a class="page-link" href="#">Suivant</a></li>
        </ul>
    </nav>
</div>

<?php require_once VIEW_PATH.'layout/footer.php'; ?>