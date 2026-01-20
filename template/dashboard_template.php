<div class="container my-5">
    <?php if(!isset($_SESSION["id_casa"]) || is_null($_SESSION["id_casa"])): ?>
        <div class="row">
            <div class="col-12 text-center py-5">
                <div class="card shadow-sm border-0 p-5">
                    <div class="display-1 mb-3">🏠</div>
                    <h2 class="fw-bold">Non sei all’interno di nessuna abitazione</h2>
                    <p class="text-muted">Per gestire spese e turni devi prima unirti a una casa o crearne una.</p>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-center mt-4">
                        <a href="annunci.php" class="btn btn-primary btn-lg fw-bold">Vai ad ANNUNCI</a>
                        <a href="profilo.php" class="btn btn-outline-dark btn-lg fw-bold">Cerca Codice Invito</a>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="fw-bold text-dark">Bentornato, <?php echo $templateParams["utente"]["nome"]; ?>! 👋</h2>
                <p class="text-muted">Ecco cosa succede nella tua casa oggi.</p>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body">
                        <h5 class="fw-bold mb-4">📢 I miei annunci</h5>
                        <?php if(count($templateParams["miei_annunci"]) > 0): ?>
                            <?php 
                            $anteprima = array_slice($templateParams["miei_annunci"], 0, 3);
                            foreach($anteprima as $annuncio): 
                            ?>
                                <div class="mb-3 pb-2 border-bottom">
                                    <h6 class="fw-bold mb-0 small"><?php echo $annuncio['titolo']; ?></h6>
                                    <div class="d-flex justify-content-between small">
                                        <span class="text-muted"><?php echo $annuncio['luogo']; ?></span>
                                        <span class="fw-bold text-success"><?php echo $annuncio['prezzo']; ?>€</span>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                            <a href="annunci.php" class="btn btn-outline-dark btn-sm w-100 mt-2">Gestisci annunci</a>
                        <?php else: ?>
                            <div class="text-center py-3">
                                <p class="small text-muted">Non hai ancora pubblicato nulla.</p>
                                <button type="button" class="btn btn-dark btn-sm w-100" data-bs-toggle="modal" data-bs-target="#modalNuovoAnnuncio">Pubblica ora</button>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body">
                        <h5 class="fw-bold mb-4">💸 Spese Recenti</h5>
                        <ul class="list-group list-group-flush mb-3">
                            <?php foreach($templateParams["spese_recenti"] as $spesa): ?>
                                <li class="list-group-item px-0 border-0 d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="fw-bold small"><?php echo $spesa['descrizione']; ?></div>
                                        <div class="text-muted" style="font-size: 0.75rem;">Inserita da <?php echo $spesa['nome_autore']; ?></div>
                                    </div>
                                    <span class="text-danger fw-bold">-<?php echo number_format($spesa['importo'], 2); ?>€</span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                        <a href="casa.php" class="btn btn-dark btn-sm w-100 mt-auto">Vedi tutte</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card shadow-sm border-0 h-100 bg-light">
                    <div class="card-body text-center">
                        <h5 class="fw-bold mb-4 text-start">🧹 Turno Pulizie</h5>
                        <div class="py-4">
                            <div class="display-6 mb-2">🧴</div>
                            <h6 class="fw-bold mb-1">Questa settimana tocca a:</h6>
                            <h4 class="text-primary fw-bold">
                                <?php echo $templateParams["prossimo_turno"]["nome"] ?? "Nessuno assegnato"; ?>
                            </h4>
                            <p class="small text-muted italic">Zona: <?php echo $templateParams["prossimo_turno"]["compito"] ?? "Generale"; ?></p>
                        </div>
                        <a href="casa.php#turni" class="btn btn-outline-dark btn-sm w-100">Gestisci turni</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-12">
                <div class="card shadow-sm border-0 p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="fw-bold mb-0">I miei annunci personali</h4>
                        
                        <button type="button" class="btn btn-success fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#modalNuovoAnnuncio">
                            + Nuovo Annuncio
                        </button>
                    </div>
                    
                    <?php if(count($templateParams["miei_annunci"]) > 0): ?>
                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead>
                                    <tr>
                                        <th>Titolo</th>
                                        <th>Città</th>
                                        <th>Prezzo</th>
                                        <th>Azioni</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($templateParams["miei_annunci"] as $annuncio): ?>
                                        <tr>
                                            <td class="fw-bold"><?php echo $annuncio["titolo"]; ?></td>
                                            <td><?php echo $annuncio["luogo"]; ?></td>
                                            <td><span class="badge bg-light text-dark"><?php echo $annuncio["prezzo"]; ?>€</span></td>
                                            <td>
                                                <a href="processa_annuncio.php?azione=elimina&id=<?php echo $annuncio['id_annuncio']; ?>" 
                                                   class="btn btn-sm btn-outline-danger" 
                                                   onclick="return confirm('Sei sicuro di voler eliminare questo annuncio?')">Elimina</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <p class="text-muted">Non hai ancora creato annunci. I tuoi futuri annunci appariranno qui.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<div class="modal fade" id="modalNuovoAnnuncio" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold" id="modalLabel">📢 Pubblica nuovo annuncio</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="processa_annuncio.php" method="POST">
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Titolo dell'annuncio</label>
                        <input type="text" name="titolo" class="form-control" placeholder="Esempio: Stanza singola in centro" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Descrizione dettagliata</label>
                        <textarea name="descrizione" class="form-control" rows="4" placeholder="Descrivi la casa, i coinquilini..." required></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Prezzo mensile (€)</label>
                            <input type="number" name="prezzo" step="0.01" class="form-control" placeholder="0.00" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Città / Zona</label>
                            <input type="text" name="luogo" class="form-control" placeholder="Esempio: Cesena" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
                    <button type="submit" class="btn btn-primary px-4 fw-bold">Pubblica ora</button>
                </div>
            </form>
        </div>
    </div>
</div>