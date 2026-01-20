<div class="container my-5">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold">Ciao, <?php echo $templateParams["utente"]["nome"]; ?>! 👋</h2>
            <p class="text-muted">Ecco cosa succede nella tua casa oggi.</p>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <h5 class="fw-bold mb-4">🏆 Classifica Pulizie</h5>
                    <?php foreach($templateParams["classifica"] as $index => $user): ?>
                        <div class="d-flex align-items-center mb-3">
                            <span class="fw-bold me-3 text-secondary">#<?php echo $index + 1; ?></span>
                            <img src="<?php echo UPLOAD_DIR . ($user['foto_profilo'] ?? 'default_avatar.png'); ?>" 
                                 class="rounded-circle me-2" style="width: 35px; height: 35px; object-fit: cover;">
                            <div class="flex-grow-1">
                                <span class="small fw-bold"><?php echo $user['nome']; ?></span>
                            </div>
                            <span class="badge bg-dark rounded-pill"><?php echo $user['punti']; ?> pt</span>
                        </div>
                    <?php endforeach; ?>
                    <div class="mt-4 pt-3 border-top text-center">
                        <p class="small text-muted mb-2">Hai fatto la tua parte?</p>
                        <a href="logica_punti.php?azione=pulizia" class="btn btn-outline-primary btn-sm fw-bold w-100">
                            ✨ Segna come fatto (+10pt)
                        </a>
                    </div>
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
</div>