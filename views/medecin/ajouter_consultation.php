<?php require_once VIEW_PATH.'layout/header.php'; ?>

<div class="container mt-4">
    <h2 class="mb-4">Nouvelle consultation</h2>
    <form method="post" action="" id="form-consultation">
        <div class="form-group">
            <label for="motif">Motif de la consultation</label>
            <input type="text" class="form-control" id="motif" name="motif" required>
        </div>
        <div class="form-group">
            <label for="diagnostic">Diagnostic</label>
            <textarea class="form-control" id="diagnostic" name="diagnostic" rows="2" required></textarea>
        </div>
        <div class="form-group">
            <label for="traitement">Traitement</label>
            <textarea class="form-control" id="traitement" name="traitement" rows="2" required></textarea>
        </div>
        <div class="form-group">
            <label for="notes">Notes complémentaires</label>
            <textarea class="form-control" id="notes" name="notes" rows="2"></textarea>
        </div>
        <hr>
        <h5>Médicaments à prescrire</h5>
        <div id="medicaments-list">
            <div class="form-row align-items-end mb-2">
                <div class="col">
                    <label>Nom</label>
                    <input type="text" name="medicaments[0][nom]" class="form-control" required>
                </div>
                <div class="col">
                    <label>Posologie</label>
                    <input type="text" name="medicaments[0][posologie]" class="form-control" required>
                </div>
                <div class="col">
                    <label>Durée</label>
                    <input type="text" name="medicaments[0][duree]" class="form-control" required>
                </div>
                <div class="col-auto">
                    <button type="button" class="btn btn-danger btn-remove-medicament" onclick="this.closest('.form-row').remove()">&times;</button>
                </div>
            </div>
        </div>
        <button type="button" class="btn btn-secondary mb-3" id="add-medicament">Ajouter un médicament</button>
        <br>
        <button type="submit" class="btn btn-primary">Enregistrer la consultation et générer l'ordonnance</button>
    </form>
</div>

<script>
let medicamentIndex = 1;
document.getElementById('add-medicament').onclick = function() {
    const list = document.getElementById('medicaments-list');
    const row = document.createElement('div');
    row.className = 'form-row align-items-end mb-2';
    row.innerHTML = `
        <div class="col">
            <label>Nom</label>
            <input type="text" name="medicaments[${medicamentIndex}][nom]" class="form-control" required>
        </div>
        <div class="col">
            <label>Posologie</label>
            <input type="text" name="medicaments[${medicamentIndex}][posologie]" class="form-control" required>
        </div>
        <div class="col">
            <label>Durée</label>
            <input type="text" name="medicaments[${medicamentIndex}][duree]" class="form-control" required>
        </div>
        <div class="col-auto">
            <button type="button" class="btn btn-danger btn-remove-medicament" onclick="this.closest('.form-row').remove()">&times;</button>
        </div>
    `;
    list.appendChild(row);
    medicamentIndex++;
};
</script>

<?php require_once VIEW_PATH.'layout/footer.php'; ?>