<?php require_once VIEW_PATH.'layout/header.php'; ?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Mes rendez-vous</h2>
        <a href="/patient/rdv/demander" class="btn btn-primary">Demander un rendez-vous</a>
    </div>
    <div class="card mb-4">
        <div class="card-header">Liste de mes rendez-vous</div>
        <div class="card-body p-0">
            <table class="table table-striped table-bordered mb-0">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Heure</th>
                        <th>Médecin</th>
                        <th>Motif</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data['rendezvous'] as $rdv): ?>
                    <tr>
                        <td><?= htmlspecialchars($rdv->getDate()) ?></td>
                        <td><?= htmlspecialchars($rdv->getHeure()) ?></td>
                        <td><?= htmlspecialchars($rdv->getMedecin()) ?></td>
                        <td><?= htmlspecialchars($rdv->getMotif()) ?></td>
                        <td><span class="badge badge-warning">À venir</span></td>
                        <td><a href="/patient/rdv/voir/<?= htmlspecialchars($rdv->getId()) ?>" class="btn btn-sm btn-info">Détails</a></td>
                    </tr>
                    <tr>
                        <td><?= htmlspecialchars($rdv->getDate()) ?></td>
                        <td><?= htmlspecialchars($rdv->getHeure()) ?></td>
                        <td><?= htmlspecialchars($rdv->getMedecin()) ?></td>
                        <td><?= htmlspecialchars($rdv->getMotif()) ?></td>
                        <td><span class="badge badge-secondary">Passé</span></td>
                        <td><a href="/patient/rdv/voir/<?= htmlspecialchars($rdv->getId()) ?>" class="btn btn-sm btn-info">Détails</a></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once VIEW_PATH.'layout/footer.php'; ?>