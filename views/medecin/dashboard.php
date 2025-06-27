<?php require_once VIEW_PATH.'layout/header.php'; ?>

<div class="container mt-4">
    <h2 class="mb-4">Tableau de bord Médecin</h2>
    <div class="row mb-4">
        <!-- Résumé activité -->
        <div class="col-md-4">
            <div class="card text-white bg-info mb-3">
                <div class="card-header">Résumé de l’activité</div>
                <div class="card-body">
                    <p class="card-text">Consultations aujourd'hui : <strong><?= $data['nb_consultations_jour'] ?></strong></p>
                    <p class="card-text">Patients suivis : <strong><?= $data['nb_patients_suivis'] ?></strong></p>
                    <p class="card-text">Ordonnances émises : <strong><?= $data['nb_ordonnances'] ?></strong></p>
                </div>
            </div>
        </div>
        <!-- Prochains RDV -->
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-header">Prochains rendez-vous</div>
                <div class="card-body p-0">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Heure</th>
                                <th>Patient</th>
                                <th>Motif</th>
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
                                <td><a href="/medecin/rdv/voir/<?= $rdv['id'] ?>" class="btn btn-sm btn-info">Voir</a></td>
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