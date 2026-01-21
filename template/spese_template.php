<div class="container my-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold m-0">💸 Spese Casa</h2>
        <button class="btn btn-primary rounded-circle shadow" data-bs-toggle="modal" data-bs-target="#addSpesa" style="width: 50px; height: 50px;">
            <i class="bi bi-plus-lg">+</i>
        </button>
    </div>

    <?php foreach($templateParams["spese"] as $spesa): ?>
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="fw-bold mb-1"><?php echo $spesa["descrizione"]; ?></h6>
                    <small class="text-muted">
                        <?php echo date("d/m", strtotime($spesa["data_spesa"])); ?> • 
                        Pagato da: <strong><?php echo $spesa["nome"]; ?></strong>
                    </small>
                </div>
                <div class="text-end">
                    <div class="fw-bold text-success mb-2">€ <?php echo number_format($spesa["importo"], 2); ?></div>
                    <a href="spese.php?azione=elimina&id=<?php echo $spesa['id_spesa']; ?>" 
                       class="text-danger p-2" onclick="return confirm('Eliminare?')">
                       🗑️
                    </a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<div class="modal fade" id="addSpesa" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form action="spese.php" method="POST" class="modal-content border-0 shadow">
            <div class="modal-header border-0">
                <h5 class="fw-bold">Aggiungi Spesa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="text" name="descrizione" class="form-control mb-3" placeholder="Cosa hai comprato?" required>
                <input type="number" name="importo" step="0.01" class="form-control mb-3" placeholder="Importo (€)" required>
                <input type="date" name="data" class="form-control mb-3" value="<?php echo date('Y-m-d'); ?>" required>
            </div>
            <div class="modal-footer border-0">
                <button type="submit" class="btn btn-primary w-100 fw-bold py-2">Salva</button>
            </div>
        </form>
    </div>
</div>