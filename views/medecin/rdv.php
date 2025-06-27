<?php require_once VIEW_PATH.'layout/header.php'; ?>

<div class="container mt-4">
    <h2 class="mb-4">Mon planning de rendez-vous</h2>
    <table class="table table-striped table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>Date</th>
                <th>Heure</th>
                <th>Patient</th>
                <th>Motif</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data['rdvs'] as $rdv): ?>
            <tr>
                <td><?= htmlspecialchars($rdv['date']) ?></td>
                <td><?= htmlspecialchars($rdv['heure']) ?></td>
                <td><?= htmlspecialchars($rdv['patient']) ?></td>
                <td><?= htmlspecialchars($rdv['motif']) ?></td>
                <td><span class="badge badge-warning">En attente</span></td>
                <td>
                    <a href="/medecin/rdv/confirmer/<?= $rdv['id'] ?>" class="btn btn-sm btn-success">Confirmer</a>
                    <a href="/medecin/rdv/annuler/<?= $rdv['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Annuler ce rendez-vous ?');">Annuler</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require_once VIEW_PATH.'layout/footer.php'; ?>