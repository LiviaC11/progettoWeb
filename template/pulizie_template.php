<div class="container my-5">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold"><i class="bi bi-bucket-fill text-primary"></i> Gestione Turni Pulizie</h2>
            <p class="text-muted">Organizza le faccende domestiche senza litigare!</p>
        </div>
        <a href="dashboard.php" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Torna alla Dashboard
        </a>
    </div>

    <div class="row g-4">
        
        <!-- COLONNA SINISTRA: FORM DI INSERIMENTO -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0 bg-light">
                <div class="card-header bg-white border-0 pt-3">
                    <h5 class="fw-bold m-0">📅 Nuovo Turno</h5>
                </div>
                <div class="card-body">
                    <form action="pulizie.php" method="POST">
                        <input type="hidden" name="azione" value="add_pulizia">
                        
                        <div class="mb-3">
                            <label for="duty" class="form-label fw-bold small text-uppercase text-muted">Cosa c'è da fare?</label>
                            <input type="text" id="duty"  name="compito" class="form-control" placeholder="Es. Pulire il bagno, Buttare il vetro..." required>
                        </div>

                        <div class="mb-3">
                            <label for="scadenza" class="form-label fw-bold small text-uppercase text-muted">Data Scadenza</label>
                            <input type="date" id="scadenza" name="data_scadenza" class="form-control" min="<?php echo date('Y-m-d'); ?>" required>
                        </div>

                        <div class="mb-4">
                            <label for="assegnato_a" class="form-label fw-bold small text-uppercase text-muted">Chi lo fa?</label>
                            <select name="assegnato_a" id="assegnato_a" class="form-select" required>
                                <option value="" selected disabled>Scegli coinquilino...</option>
                                <?php foreach($templateParams["coinquilini"] as $coinquilino): ?>
                                    <option value="<?php echo $coinquilino['id_utente']; ?>">
                                        <?php echo $coinquilino['nome'] . " " . $coinquilino['cognome']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary fw-bold shadow-sm">
                                <i class="bi bi-plus-lg"></i> Assegna Turno
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- COLONNA DESTRA: LISTA TURNI -->
        <div class="col-md-8">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white border-0 pt-3">
                    <h5 class="fw-bold m-0">Programma del Mese</h5>
                </div>
                <div class="card-body p-0">
                    <?php if(empty($templateParams["turni"])): ?>
                        <div class="text-center py-5">
                            <div class="display-1 text-muted opacity-25">✨</div>
                            <p class="text-muted">Nessun turno programmato.<br>Godetevi il pulito (finché dura)!</p>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light sticky-top">
                                    <tr>
                                        <th class="ps-4">Data</th>
                                        <th>Compito</th>
                                        <th>Assegnato a</th>
                                        <th>Stato</th>
                                        <th class="text-end pe-4">Azioni</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($templateParams["turni"] as $turno): 
                                        $data = new DateTime($turno['data_scadenza']);
                                        $oggi = new DateTime();
                                        
                                        // Verifichiamo se esiste 'completato' (che vale 1), altrimenti controlliamo 'stato'
                                        $valore_stato = 0;
                                        if(isset($turno['completato'])){
                                            $valore_stato = $turno['completato'];
                                        } elseif(isset($turno['stato'])){
                                            $valore_stato = $turno['stato'];
                                        }
                                        
                                        // Se è 1 è fatto, altrimenti è da fare
                                        $fatto = ($valore_stato == 1);
                                        
                                        // È scaduto se la data è passata e non è stato fatto
                                        $scaduto = ($data < $oggi && !$fatto);
                                    ?>
                                    <tr class="<?php echo $fatto ? 'bg-light text-muted' : ''; ?>">
                                        <!-- Data -->
                                        <td class="ps-4">
                                            <div class="d-flex align-items-center">
                                                <div class="text-center border rounded p-1 me-2 bg-white" style="width: 45px;">
                                                    <span class="d-block small fw-bold text-uppercase" style="font-size: 0.6rem;"><?php echo $data->format('M'); ?></span>
                                                    <span class="d-block fw-bold lh-1"><?php echo $data->format('d'); ?></span>
                                                </div>
                                                <?php if($scaduto): ?>
                                                    <span class="badge bg-danger ms-2">SCADUTO</span>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                        
                                        <!-- Compito -->
                                        <td>
                                            <span class="fw-bold <?php echo $fatto ? 'text-decoration-line-through' : ''; ?>">
                                                <?php echo htmlspecialchars($turno['compito']); ?>
                                            </span>
                                        </td>

                                        <!-- Assegnato -->
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="rounded-circle bg-secondary text-white d-flex justify-content-center align-items-center me-2" style="width: 30px; height: 30px; font-size: 0.8rem;">
                                                    <?php echo strtoupper(substr($turno['nome'], 0, 1)); ?>
                                                </div>
                                                <span class="small"><?php echo htmlspecialchars($turno['nome']); ?></span>
                                            </div>
                                        </td>

                                        <!-- Stato (Testo Esplicito) -->
                                        <td>
                                            <?php if($fatto): ?>
                                                <span class="text-success fw-bold small">Completato</span>
                                            <?php else: ?>
                                                <span class="text-warning-emphasis fw-bold small">Da fare</span>
                                            <?php endif; ?>
                                        </td>

                                        <!-- Azioni -->
                                        <td class="text-end pe-4">
                                            <?php if($fatto): ?>
                                                <!-- Se è già fatto, mostriamo solo il badge verde -->
                                                <span class="badge bg-success rounded-pill px-3 py-2">
                                                    <i class="bi bi-check-lg"></i> Fatto
                                                </span>
                                            <?php else: ?>
                                                <!-- Se è da fare, mostriamo il form col bottone -->
                                                <form action="pulizie.php" method="POST" class="d-inline">
                                                    <input type="hidden" name="azione" value="completa_pulizia">
                                                    <input type="hidden" name="id_turno" value="<?php echo $turno['id_turno']; ?>">
                                                    <button type="submit" class="btn btn-sm btn-outline-success" title="Segna come completato">
                                                        <i class="bi bi-check2-circle"></i> Segna Fatto
                                                    </button>
                                                </form>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    </div>
</div>