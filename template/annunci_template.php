<div class="container my-5">
    <div class="text-center mb-5">
        <h2 class="fw-bold">Annunci Disponibili</h2>
        <p class="text-muted">Trova la tua prossima casa o il coinquilino ideale in pochi click.</p>
    </div>

    <section class="filters mb-5">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-3">🔍 Filtra la ricerca</h5>
                <form class="row g-3">
                    <div class="col-md-4">
                        <label  for="filtro-dove" class="form-label small fw-bold">Dove</label>
                        <input type="text" id="filtro-dove" class="form-control" placeholder="Cerca città o zona...">
                    </div>
                    <div class="col-md-4">
                        <label for="filtro-prezzo" class="form-label small fw-bold">Prezzo</label>
                        <select id="filtro-prezzo" class="form-select">
                            <option selected>Budget max...</option>
                            <option value="1">Sotto 300€</option>
                            <option value="2">300€ - 500€</option>
                            <option value="3">Oltre 500€</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small fw-bold">Preferenze</label>
                        <div class="d-flex align-items-center flex-wrap gap-3 mt-1">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="tag1">
                                <label class="form-check-label small" for="tag1">#AnimaliAmmessi</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="tag2">
                                <label class="form-check-label small" for="tag2">#NoFumatori</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mt-4">
                        <button type="submit" class="btn btn-dark w-100 py-2 fw-bold shadow-sm">Applica Filtri</button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <section class="row g-4">
        <?php foreach($templateParams["annunci"] as $annuncio): ?>
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm border-0">
                    <img src="https://via.placeholder.com/400x250" class="card-img-top" alt="<?php echo $annuncio['titolo']; ?>" style="border-top-left-radius: 0.375rem; border-top-right-radius: 0.375rem;">
                    
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h5 class="fw-bold mb-0"><?php echo $annuncio['titolo']; ?></h5>
                            <span class="badge bg-success px-3 py-2"><?php echo $annuncio['prezzo']; ?>€/mese</span>
                        </div>
                        <p class="card-text text-muted small mb-4">
                            <?php echo (strlen($annuncio['descrizione']) > 100) ? substr($annuncio['descrizione'], 0, 100).'...' : $annuncio['descrizione']; ?>
                        </p>
                        
                        <button class="btn btn-outline-dark w-100 fw-bold" data-bs-toggle="modal" data-bs-target="#modal-<?php echo $annuncio['id_annuncio']; ?>">
                            Visualizza e Candida
                        </button>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modal-<?php echo $annuncio['id_annuncio']; ?>" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content border-0 shadow-lg">
                        <div class="modal-header border-0 pb-0">
                            <h4 class="fw-bold modal-title">Invia la tua candidatura</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Chiudi finestra di candidatura"></button>
                        </div>
                        <div class="modal-body p-4">
                            <p class="text-muted small mb-4">Stai rispondendo all'annuncio: <strong><?php echo $annuncio['titolo']; ?></strong></p>
                            
                            <form method="POST" action="risposta.php" enctype="multipart/form-data">
                                <input type="hidden" name="id_annuncio" value="<?php echo $annuncio['id_annuncio']; ?>">
                                
                                <div class="mb-3">
                                    <label for="nome-<?php echo $annuncio['id_annuncio']; ?>" class="form-label fw-bold">Nome Completo</label>
                                    <input type="text" id="nome-<?php echo $annuncio['id_annuncio']; ?>" name="nome" class="form-control" placeholder="Es. Mario Rossi" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="email-<?php echo $annuncio['id_annuncio']; ?>" class="form-label fw-bold">Email</label>
                                    <input type="email" id="email-<?php echo $annuncio['id_annuncio']; ?>" name="email" class="form-control" placeholder="mario.rossi@esempio.it" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="messaggio-<?php echo $annuncio['id_annuncio']; ?>" class="form-label fw-bold">Parlaci di te</label>
                                    <textarea id="messaggio-<?php echo $annuncio['id_annuncio']; ?>" name="messaggio" class="form-control" rows="4" placeholder="Quali sono le tue abitudini? Perché dovrebbero scegliere te?" required></textarea>
                                </div>
                                
                                <div class="mb-4">
                                    <label for="foto-<?php echo $annuncio['id_annuncio']; ?>" class="form-label fw-bold">Una tua foto (Opzionale)</label>
                                    <input type="file" id="foto-<?php echo $annuncio['id_annuncio']; ?>" name="foto" class="form-control">
                                </div>
                                
                                <button type="submit" class="btn btn-success w-100 py-2 fw-bold shadow-sm">Invia Candidatura</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </section>
</div>