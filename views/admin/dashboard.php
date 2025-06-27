<?php 
require_once VIEW_PATH.'layout/header.php';
?>

<div class="container mt-4">
    <h1 class="mb-4">Tableau de bord Administrateur</h1>
    <div class="row mb-4">
        <!-- Statistiques -->
        <div class="col-md-4">
            <div class="card text-white bg-primary mb-3">
                <div class="card-header">Patients</div>
                <div class="card-body">
                    <h5 class="card-title">Nombre de patients</h5>
                    <p class="card-text display-4"><?=$data['nb_patients'] ?? 0 ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-success mb-3">
                <div class="card-header">Médecins</div>
                <div class="card-body">
                    <h5 class="card-title">Nombre de médecins</h5>
                    <p class="card-text display-4"><?=$data['nb_medecins'] ?? 0 ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-info mb-3">
                <div class="card-header">Consultations</div>
                <div class="card-body">
                    <h5 class="card-title">Consultations totales</h5>
                    <p class="card-text display-4"><?=$data['nb_consultations'] ?? 0 ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Accès rapide -->
    <div class="row">
        <div class="col-md-3 mb-3">
            <a href="/admin-utilisateurs" class="btn btn-outline-primary btn-block">Gestion des utilisateurs</a>
        </div>
        <div class="col-md-3 mb-3">
            <a href="/admin-medecins" class="btn btn-outline-success btn-block">Gestion des médecins</a>
        </div>
        <div class="col-md-3 mb-3">
            <a href="/admin-patients" class="btn btn-outline-info btn-block">Gestion des patients</a>
        </div>
        <div class="col-md-3 mb-3">
            <a href="/admin-consultations" class="btn btn-outline-secondary btn-block">Gestion des consultations</a>
        </div>
    </div>
</div>

<?php require_once VIEW_PATH.'layout/footer.php'; ?>