<?php require_once VIEW_PATH.'layout/header.php'; ?>

<div class="container mt-4">
    <h2 class="mb-4">Mon tableau de bord</h2>
    <div class="row mb-4">
        <!-- Notifications -->
        <div class="col-md-5">
            <div class="card mb-3">
                <div class="card-header bg-info text-white">Notifications</div>
                <ul class="list-group list-group-flush">
                    <?php foreach ($data['notifications'] as $notification): ?>
                    <li class="list-group-item"><?= htmlspecialchars($notification) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <!-- Derniers rendez-vous -->
        <div class="col-md-7">
            <div class="card mb-3">
                <div class="card-header">Derniers rendez-vous</div>
                <div class="card-body p-0">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Heure</th>
                                <th>Médecin</th>
                                <th>Motif</th>
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
                                <td><a href="/patient/rdv/voir/<?= htmlspecialchars($rdv->getId()) ?>" class="btn btn-sm btn-info">Détails</a></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once VIEW_PATH.'layout/footer.php'; ?>