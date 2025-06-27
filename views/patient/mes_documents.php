<?php require_once VIEW_PATH.'layout/header.php'; ?>

<div class="container mt-4">
    <h2 class="mb-4">Mes documents médicaux</h2>
    <div class="card mb-4">
        <div class="card-header">Liste de mes documents</div>
        <div class="card-body p-0">
            <table class="table table-striped table-bordered mb-0">
                <thead>
                    <tr>
                        <th>Nom du document</th>
                        <th>Type</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data['documents'] as $document): ?>
                    <tr>
                        <td><?= htmlspecialchars($document->getNom()) ?></td>
                        <td><?= htmlspecialchars($document->getType()) ?></td>
                        <td><?= htmlspecialchars($document->getDate()) ?></td>
                        <td><a href="/patient/document/telecharger/<?= htmlspecialchars($document->getId()) ?>" class="btn btn-sm btn-success">Télécharger</a></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once VIEW_PATH.'layout/footer.php'; ?>