<div class="container my-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold m-0">💸 Spese Casa</h2>
       <button class="btn btn-primary rounded-circle shadow" data-bs-toggle="modal" data-bs-target="#addSpesa" style="width: 50px; height: 50px;">
    <i class="bi bi-plus-lg" aria-hidden="true"></i>
    <span class="visually-hidden">Aggiungi nuova spesa</span>
</button>
    </div>

   <?php foreach($templateParams["spese"] as $spesa): ?>
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div>
                    <h5 class="fw-bold mb-1 text-dark"><?php echo $spesa["descrizione"]; ?></h5>
                    <p class="text-muted small mb-0">
                        Pagato da: <strong><?php echo $spesa["nome"]; ?></strong> 
                        il <?php echo date("d/m/Y", strtotime($spesa["data_spesa"])); ?>
                    </p>
                </div>
                <div class="text-end">
                    <span class="h5 fw-bold text-success d-block mb-1">
                        € <?php echo number_format($spesa["importo"], 2); ?>
                    </span>
                    <a href="spese.php?azione=elimina&id=<?php echo $spesa['id_spesa']; ?>" 
                       class="text-decoration-none small text-danger" 
                       onclick="return confirm('Eliminare questa spesa?')">
                       Elimina 🗑️
                    </a>
                </div>
            </div>

            <div class="border-top pt-3 mt-2">
                <p class="small fw-bold text-dark text-uppercase mb-2" style="font-size: 0.7rem;">Divisione quote:</p>
                <div class="row g-2">
                    <?php 
                    // Calcolo la quota singola (importo / numero persone totali della casa)
                    $quota_singola = $spesa["importo"] / $templateParams["num_persone"]; 
                    
                    foreach($templateParams["coinquilini"] as $coinquilino): 
                    ?>
                        <div class="col-6 col-md-4">
                            <div class="p-2 bg-light rounded-2 border-start border-primary border-3">
                                <div class="small fw-bold text-truncate"><?php echo $coinquilino["nome"]; ?></div>
                                <div class="small fw-bold text-primary-emphasis">€ <?php echo number_format($quota_singola, 2); ?></div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
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
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Chiudi"></button>
            </div>
            <div class="modal-body">
                <label for="new-desc" class="visually-hidden">Descrizione spesa</label>
                <input type="text" id="new-desc" name="descrizione" class="form-control mb-3" placeholder="Cosa hai comprato?" required>
                <label for="new-amount" class="visually-hidden">Importo</label>
                <input type="number" id="new-amount" name="importo" step="0.01" class="form-control mb-3" placeholder="Importo (€)" required>
                <label for="new-date" class="visually-hidden">Data</label>
                <input type="date" id="new-date" name="data" class="form-control mb-3" value="<?php echo date('Y-m-d'); ?>" required>
            </div>
            <div class="modal-footer border-0">
                <button type="submit" class="btn btn-primary w-100 fw-bold py-2">Salva</button>
            </div>
        </form>
    </div>
</div>