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
                            // Prendiamo solo i primi 2 o 3 per il box laterale
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
                                <a href="annunci.php" class="btn btn-dark btn-sm w-100">Pubblica ora</a>
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
                        <a href="annunci.php" class="btn btn-success fw-bold">+ Nuovo Annuncio</a>
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
                                                <button class="btn btn-sm btn-outline-danger">Elimina</button>
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