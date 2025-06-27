<?php require_once VIEW_PATH.'layout/header.php'; ?>

<div class="container mt-4">
    <h2 class="mb-4">Mon dossier médical</h2>
    <div class="card mb-4">
        <div class="card-header">Historique des consultations et traitements</div>
        <div class="card-body p-0">
            <table class="table table-striped table-bordered mb-0">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Médecin</th>
                        <th>Motif</th>
                        <th>Diagnostic</th>
                        <th>Traitement</th>
                        <th>Ordonnance</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data['consultations'] as $consultation): ?>
                    <tr>
                        <td><?= htmlspecialchars($consultation->getDate()) ?></td>
                        <td><?= htmlspecialchars($consultation->getMedecin()) ?></td>
                        <td><?= htmlspecialchars($consultation->getMotif()) ?></td>
                        <td><?= htmlspecialchars($consultation->getDiagnostic()) ?></td>
                        <td><?= htmlspecialchars($consultation->getTraitement()) ?></td>
                        <td><a href="/patient/ordonnance/voir/<?= htmlspecialchars($consultation->getId()) ?>" class="btn btn-sm btn-info">Voir</a></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once VIEW_PATH.'layout/footer.php'; ?>