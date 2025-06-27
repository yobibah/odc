<?php require_once VIEW_PATH.'layout/header.php'; ?>

<div class="container mt-5">
    <div class="alert alert-danger text-center">
        <h2>Une erreur est survenue</h2>
        <p>
            <?php echo isset($error) ? htmlspecialchars($error) : "Accès refusé ou données introuvables."; ?>
        </p>
        <a href="javascript:history.back()" class="btn btn-outline-primary mt-3">Retour</a>
        <a href="/" class="btn btn-primary mt-3">Accueil</a>
    </div>
</div>

<?php require_once VIEW_PATH.'layout/footer.php'; ?>