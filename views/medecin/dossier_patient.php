<?php require_once VIEW_PATH.'layout/header.php'; ?>

<div class="container mt-4">
    <h2 class="mb-4">Dossier médical du patient</h2>
    <!-- Infos générales du patient -->
    <div class="card mb-4">
        <div class="card-header">Informations générales</div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4"><strong>Nom :</strong> <?= $data['patient']->getNom() ?? 'Inconnu'; ?></div>
                <div class="col-md-4"><strong>Prénom :</strong> <?= $data['patient']->getPrenom() ?? 'Inconnu'; ?></div>
                <div class="col-md-4"><strong>Date de naissance :</strong> <?= $data['patient']->getDateNaissance() ?? 'Inconnue'; ?></div>
            </div>
            <div class="row mt-2">
                <div class="col-md-4"><strong>Sexe :</strong> <?= $data['patient']->getSexe() ?? 'Inconnu'; ?></div>
                <div class="col-md-4"><strong>Téléphone :</strong> <?= $data['patient']->getTelephone() ?? 'Inconnu'; ?></div>
                <div class="col-md-4"><strong>Adresse :</strong> <?= $data['patient']->getAdresse() ?? 'Inconnue'; ?></div>
            </div>
        </div>
    </div>

    <!-- Liste des consultations -->
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Consultations</span>
            <a href="/medecin/consultation/ajouter/{id_patient}" class="btn btn-primary btn-sm">Ajouter une consultation</a>
        </div>
        <div class="card-body p-0">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Motif</th>
                        <th>Médecin</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data['consultations'] as $consultation): ?>
                    <tr>
                        <td><?= htmlspecialchars($consultation['date']) ?></td>
                        <td><?= htmlspecialchars($consultation['motif']) ?></td>
                        <td><?= htmlspecialchars($consultation['medecin']) ?></td>
                        <td><a href="/medecin/consultation/voir/<?= $consultation['id'] ?>" class="btn btn-sm btn-info">Voir</a></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Liste des documents médicaux -->
    <div class="card mb-4">
        <div class="card-header">Documents médicaux</div>
        <div class="card-body p-0">
            <table class="table mb-0">
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
                        <td><?= htmlspecialchars($document['nom']) ?></td>
                        <td><?= htmlspecialchars($document['type']) ?></td>
                        <td><?= htmlspecialchars($document['date']) ?></td>
                        <td><a href="/medecin/document/telecharger/<?= $document['id'] ?>" class="btn btn-sm btn-success">Télécharger</a></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once VIEW_PATH.'layout/footer.php'; ?>