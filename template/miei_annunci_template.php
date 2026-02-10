<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold">📢 I Miei Annunci</h2>
            <p class="text-muted small">Gestisci i tuoi post e scopri chi vuole diventare il tuo nuovo coinquilino!</p>
        </div>
        <a href="dashboard.php" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Torna alla Dashboard
        </a>
    </div>

    <?php if(empty($templateParams["annunci"])): ?>
        <div class="card border-0 shadow-sm p-5 text-center">
            <div class="display-1 mb-3">📭</div>
            <h4 class="text-muted">Ancora nulla? Pubblica qualcosa di iconico!</h4>
            <div class="mt-3">
                <a href="dashboard.php" class="btn btn-primary fw-bold">Crea Annuncio</a>
            </div>
        </div>
    <?php else: ?>
        <div class="row g-4">
            <?php foreach($templateParams["annunci"] as $annuncio): 
                $is_active = (int)$annuncio['isActive'];
                $statusBadge = $is_active ? 'bg-success' : 'bg-dark';
                $statusText = $is_active ? 'Online' : 'Nascosto';
                $numCandidature = isset($annuncio['candidature']) ? count($annuncio['candidature']) : 0;
            ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm overflow-hidden <?php echo $is_active ? '' : 'annuncio-nascosto'; ?>">
                        <div class="position-relative">
                            <!-- FIX: Uso 'immagine' o 'foto' in base a cosa arriva dal DB, con fallback -->
                            <?php $imgSrc = !empty($annuncio['immagine']) ? $annuncio['immagine'] : (!empty($annuncio['foto']) ? $annuncio['foto'] : 'img/nophoto.png'); ?>
                            <img src="<?php echo htmlspecialchars($imgSrc); ?>" 
                                 class="card-img-top" alt="" style="height: 200px; object-fit: cover;">
                            <span class="badge <?php echo $statusBadge; ?> position-absolute top-0 end-0 m-3 shadow-sm px-3 py-2">
                                <?php echo $statusText; ?>
                            </span>
                        </div>
                        
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start <?php echo $is_active ? 'mb-2' : 'mb-0'; ?>">
                                <h5 class="card-title fw-bold mb-0 text-truncate"><?php echo htmlspecialchars($annuncio['titolo']); ?></h5>
                                <span class="text-primary fw-bold"><?php echo number_format($annuncio['prezzo'], 2); ?>€</span>
                            </div>
                            <?php if($is_active): ?> 
                                <p class="text-muted small mb-3"><i class="bi bi-geo-alt"></i> <?php echo htmlspecialchars($annuncio['luogo']); ?></p>
                                <button class="btn btn-dark w-100 mb-3 fw-bold position-relative" data-bs-toggle="modal" data-bs-target="#modalCandidature<?php echo $annuncio['id_annuncio']; ?>">
                                    <i class="bi bi-people-fill"></i> Vedi Candidature 
                                    <?php if($numCandidature > 0): ?>
                                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"><?php echo $numCandidature; ?></span>
                                    <?php endif; ?>
                                </button>
                            <?php endif; ?>
                        </div>

                        <div class="card-footer bg-white border-top-0 pb-3 px-3">
                            <div class="d-grid gap-2">
                                <?php if($is_active): ?>
                                    <div class="row g-2">
                                        <div class="col-6">
                                            <button class="btn btn-sm btn-outline-primary w-100" data-bs-toggle="modal" data-bs-target="#modalModifica<?php echo $annuncio['id_annuncio']; ?>">
                                                <i class="bi bi-pencil"></i> Modifica
                                            </button>
                                        </div>
                                        <div class="col-6">
                                            <a href="processa_annuncio.php?azione=elimina&id=<?php echo $annuncio['id_annuncio']; ?>" class="btn btn-sm btn-outline-danger w-100" onclick="return confirm('Sicura di voler eliminare?')"><i class="bi bi-trash"></i> Elimina</a>
                                        </div>
                                    </div>
                                    <a href="processa_annuncio.php?azione=disattiva&id=<?php echo $annuncio['id_annuncio']; ?>" class="btn btn-sm btn-warning w-100 fw-bold">Nascondi</a>
                                <?php else: ?>
                                    <a href="processa_annuncio.php?azione=attiva&id=<?php echo $annuncio['id_annuncio']; ?>" class="btn btn-sm btn-success w-100 fw-bold">Mostra</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- MODALE MODIFICA (Ora riempito e funzionante) -->
                <div class="modal fade" id="modalModifica<?php echo $annuncio['id_annuncio']; ?>" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content border-0 shadow">
                            <form action="processa_annuncio.php" method="POST" enctype="multipart/form-data">
                                <div class="modal-header border-0 pb-0">
                                    <h5 class="modal-title fw-bold">Modifica Annuncio</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Chiudi"></button>
                                </div>
                                <div class="modal-body">
                                    <!-- Input nascosti fondamentali -->
                                    <input type="hidden" name="action" value="modifica">
                                    <input type="hidden" name="id_annuncio" value="<?php echo $annuncio['id_annuncio']; ?>">

                                    <div class="mb-3">
                                        <label class="form-label small fw-bold text-uppercase text-muted">Titolo</label>
                                        <input type="text" class="form-control" name="titolo" value="<?php echo htmlspecialchars($annuncio['titolo']); ?>" required>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label small fw-bold text-uppercase text-muted">Descrizione</label>
                                        <textarea class="form-control" name="descrizione" rows="4" required><?php echo htmlspecialchars($annuncio['descrizione']); ?></textarea>
                                    </div>

                                    <div class="row">
                                        <div class="col-6 mb-3">
                                            <label class="form-label small fw-bold text-uppercase text-muted">Prezzo (€)</label>
                                            <input type="number" step="0.01" class="form-control" name="prezzo" value="<?php echo $annuncio['prezzo']; ?>" required>
                                        </div>
                                        <div class="col-6 mb-3">
                                            <label class="form-label small fw-bold text-uppercase text-muted">Luogo</label>
                                            <input type="text" class="form-control" name="luogo" value="<?php echo htmlspecialchars($annuncio['luogo']); ?>" required>
                                        </div>
                                    </div>
                                    
                                    <!-- Anteprima immagine attuale -->
                                    <div class="mb-3 p-3 bg-light rounded">
                                        <label class="form-label small fw-bold text-uppercase text-muted d-block">Foto Attuale</label>
                                        <?php $imgSrcModal = !empty($annuncio['immagine']) ? $annuncio['immagine'] : (!empty($annuncio['foto']) ? $annuncio['foto'] : 'img/nophoto.png'); ?>
                                        <img src="<?php echo htmlspecialchars($imgSrcModal); ?>" alt="Attuale" class="img-thumbnail" style="max-height: 100px;">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label small fw-bold text-uppercase text-muted">Cambia Foto (Opzionale)</label>
                                        <input type="file" class="form-control" name="foto">
                                    </div>
                                </div>
                                <div class="modal-footer border-0 pt-0">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Annulla</button>
                                    <button type="submit" class="btn btn-primary fw-bold px-4">Salva Modifiche</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- MODALE CANDIDATURE -->
                <div class="modal fade" id="modalCandidature<?php echo $annuncio['id_annuncio']; ?>" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content border-0 shadow-lg">
                            <div class="modal-header bg-dark text-white">
                                <h5 class="modal-title fw-bold">💌 Candidature per: <?php echo htmlspecialchars($annuncio['titolo']); ?></h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body p-4 bg-light">
                                <?php if(empty($annuncio['candidature'])): ?>
                                    <div class="text-center py-5">
                                        <p class="text-muted">Ancora nessuno si è fatto avanti. Aspettiamo i pezzi grossi! 💅</p>
                                    </div>
                                <?php else: ?>
                                    <div class="row g-3">
                                        <?php foreach($annuncio['candidature'] as $candidatura): ?>
                                            <div class="col-12">
                                                <div class="card border-0 shadow-sm p-3">
                                                    <div class="d-flex align-items-center mb-3">
                                                        <img src="<?php echo !empty($candidatura['foto']) ? htmlspecialchars($candidatura['foto']) : 'img/nophoto.png'; ?>" 
                                                             class="rounded-circle border me-3" style="width: 60px; height: 60px; object-fit: cover;" alt="">
                                                        <div>
                                                            <h6 class="fw-bold mb-0"><?php echo htmlspecialchars($candidatura['nome']); ?></h6>
                                                            <small class="text-muted"><i class="bi bi-envelope"></i> <?php echo htmlspecialchars($candidatura['email']); ?></small>
                                                        </div>
                                                        <div class="ms-auto">
                                                            <span class="badge bg-light text-muted border small"><?php echo date("d/m/Y", strtotime($candidatura['data_invio'])); ?></span>
                                                        </div>
                                                    </div>
                                                    <div class="bg-light p-3 rounded">
                                                        <p class="mb-0 small italic">"<?php echo nl2br(htmlspecialchars($candidatura['messaggio'])); ?>"</p>
                                                    </div>
                                                    <div class="mt-2 text-end">
                                                        <a href="mailto:<?php echo $candidatura['email']; ?>" class="btn btn-sm btn-primary fw-bold">Rispondi subito 💅</a>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="modal-footer bg-white">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Chiudi</button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>