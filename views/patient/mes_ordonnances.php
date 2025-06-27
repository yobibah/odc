<?php require_once VIEW_PATH.'layout/header.php'; ?>

<div class="container mt-4">
    <h2 class="mb-4">Mes ordonnances</h2>
    <div class="card mb-4">
        <div class="card-header">Liste de mes ordonnances</div>
        <div class="card-body p-0">
            <table class="table table-striped table-bordered mb-0">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Médecin</th>
                        <th>Motif</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data['ordonnances'] as $ordonnance): ?>
                    <tr>
                        <td><?= htmlspecialchars($ordonnance->getDate()) ?></td>
                        <td><?= htmlspecialchars($ordonnance->getMedecin()) ?></td>
                        <td><?= htmlspecialchars($ordonnance->getMotif()) ?></td>
                        <td><a href="/patient/ordonnance/telecharger/<?= htmlspecialchars($ordonnance->getId()) ?>" class="btn btn-sm btn-success">Télécharger</a></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once VIEW_PATH.'layout/footer.php'; ?>