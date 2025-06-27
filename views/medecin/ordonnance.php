<?php require_once VIEW_PATH.'layout/header.php'; ?>

<div class="container mt-4" id="ordonnance-print">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Ordonnance médicale</h2>
        <button class="btn btn-outline-secondary d-print-none" onclick="window.print()">Imprimer</button>
    </div>
    <div class="row mb-3">
        <div class="col-md-6">
            <strong>Patient :</strong> <?= htmlspecialchars($data['patient']->getPrenom()) ?> <?= htmlspecialchars($data['patient']->getNom()) ?><br>
            <strong>Date de naissance :</strong> <?= htmlspecialchars($data['patient']->getDateNaissance()) ?><br>
            <strong>Téléphone :</strong> <?= htmlspecialchars($data['patient']->getTelephone()) ?>
        </div>
        <div class="col-md-6 text-right">
            <strong>Médecin :</strong> Dr. <?= htmlspecialchars($data['medecin']->getNom()) ?> <?= htmlspecialchars($data['medecin']->getPrenom()) ?><br>
            <strong>Spécialité :</strong> <?= htmlspecialchars($data['medecin']->getSpecialite()) ?><br>
            <strong>Date :</strong> <?= htmlspecialchars($data['ordonnance']->getDate()) ?><br>
            <strong>N° ordonnance :</strong> <?= htmlspecialchars($data['ordonnance']->getNumero()) ?>
        </div>
    </div>
    <hr>
    <h5>Médicaments prescrits</h5>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nom du médicament</th>
                <th>Posologie</th>
                <th>Durée</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data['ordonnance']->getMedicaments() as $medicament): ?>
            <tr>
                <td><?= htmlspecialchars($medicament['nom']) ?></td>
                <td><?= htmlspecialchars($medicament['posologie']) ?></td>
                <td><?= htmlspecialchars($medicament['duree']) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="row mt-5">
        <div class="col-md-6"></div>
        <div class="col-md-6 text-right">
            <p><strong>Signature du médecin</strong></p>
            <br><br>
            <p>__________________________</p>
        </div>
    </div>
</div>

<?php require_once VIEW_PATH.'layout/footer.php'; ?>