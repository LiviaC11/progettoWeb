<div class="container my-5">
    <div class="text-center mb-5">
        <h2 class="fw-bold">Annunci Disponibili</h2>
        <p class="text-muted">Trova la tua prossima casa o il coinquilino ideale in pochi click.</p>
    </div>

    <!-- SEZIONE FILTRI -->
    <section class="filters mb-5">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-3">🔍 Filtra la ricerca</h5>
                <form id="form-filtri" class="row g-3" onsubmit="return false;">
                    <div class="col-12 mb-2">
                        <label for="filtro-testo" class="visually-hidden">Cosa cerchi?</label>
                        <input type="text" id="filtro-testo" class="form-control" placeholder="Cosa cerchi?" ...>
                    </div>
                    <div class="col-md-6">
                        <label for="filtro-dove" class="form-label small fw-bold">Dove</label>
                        <input type="text" id="filtro-dove" class="form-control" placeholder="Cerca città">
                    </div>
                    <div class="col-md-6">
                        <label for="filtro-prezzo" class="form-label small fw-bold">Prezzo</label>
                        <select id="filtro-prezzo" class="form-select">
                            <option value="all" selected>Tutti i prezzi</option>
                            <option value="1">Sotto 300€</option>
                            <option value="2">300€ - 500€</option>
                            <option value="3">Oltre 500€</option>
                        </select>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- LISTA ANNUNCI DINAMICA -->
    <section class="row g-4" id="container-annunci">
        <?php foreach($templateParams["annunci"] as $annuncio): 
            $percorsoImmagine = !empty($annuncio['immagine']) ? htmlspecialchars($annuncio['immagine']) : 'img/nophoto.png';
        ?>
            
            <div class="col-12 col-md-6 col-lg-4 annuncio-item" 
                 data-titolo="<?php echo strtolower(htmlspecialchars($annuncio['titolo'] . ' ' . $annuncio['descrizione'])); ?>" 
                 data-prezzo="<?php echo $annuncio['prezzo']; ?>"
                 data-luogo="<?php echo strtolower(htmlspecialchars($annuncio['luogo'])); ?>">
                 
                <div class="card h-100 shadow-sm border-0 overflow-hidden d-flex flex-column"> <!-- /*d-flex flex-column */LIVIA -->
                    <img src="<?php echo $percorsoImmagine; ?>" class="card-img-top" alt="Foto alloggio" style="height: 220px; object-fit: cover;">
                    <div class="card-body p-4 d-flex flex-column">  <!-- /*d-flex flex-column */LIVIA -->
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h5 class="fw-bold mb-0 text-truncate" style="max-width: 70%;"><?php echo htmlspecialchars($annuncio['titolo']); ?></h5> <!-- /*text-truncate" style="max-width: 70%;" */LIVIA -->  
                            <span class="badge bg-success px-3 py-2"><?php echo number_format($annuncio['prezzo'], 2); ?>€</span>
                        </div>
                        <div class="text-muted small mb-2">
                            <i class="bi bi-geo-alt-fill text-danger"></i> <?php echo htmlspecialchars($annuncio['luogo']); ?>
                        </div>
                        <p class="card-text text-muted small mb-4" style="display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; min-height: 4.5em;"> <!--<p class="card-text text-muted small mb-4 text-truncate-2">  PRIMA C'ERA QUESTO-->
                            <?php echo htmlspecialchars($annuncio['descrizione']); ?>
                        </p>
                        <button class="btn btn-outline-dark w-100 fw-bold" data-bs-toggle="modal" data-bs-target="#modal-<?php echo $annuncio['id_annuncio']; ?>">
                            Visualizza e Candidati
                        </button>
                    </div>
                </div>
            </div>

            <!-- MODALE DETTAGLIO E FORM CANDIDATURA -->
            <div class="modal fade" id="modal-<?php echo $annuncio['id_annuncio']; ?>" tabindex="-1" aria-labelledby="modal-title-<?php echo $annuncio['id_annuncio']; ?>" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content border-0 shadow-lg">
                        <div class="modal-header border-0 pb-0">
                            <h4 class="fw-bold modal-title" id="modal-title-<?php echo $annuncio['id_annuncio']; ?>"> <?php echo htmlspecialchars($annuncio['titolo']); ?></h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body p-4">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <img src="<?php echo $percorsoImmagine; ?>" class="img-fluid rounded shadow-sm mb-3" alt="Dettaglio alloggio">
                                    <div class="d-flex gap-2">
                                        <span class="badge bg-light text-dark border"><?php echo number_format($annuncio['prezzo'], 2); ?>€ / mese</span>
                                        <span class="badge bg-light text-dark border"><?php echo htmlspecialchars($annuncio['luogo']); ?></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <h5 class="fw-bold">Descrizione</h5>
                                    <p class="text-muted"><?php echo nl2br(htmlspecialchars($annuncio['descrizione'])); ?></p>
                                </div>
                            </div>
                            <hr class="my-4">
                            <h5 class="fw-bold mb-3"><i class="bi bi-send-fill text-primary"></i> Invia la tua candidatura</h5>
                            
                            <!-- IL FORM CHE ABBIAMO COLLEGATO -->
                            <form method="POST" action="risposta.php" enctype="multipart/form-data">
                                <!-- Passiamo l'ID dell'annuncio nascosto-->
                                <input type="hidden" name="id_annuncio" value="<?php echo $annuncio['id_annuncio']; ?>">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="nome-<?php echo $annuncio['id_annuncio']; ?>" class="form-label fw-bold small">Tuo Nome</label>
                                        <input type="text" id="nome-<?php echo $annuncio['id_annuncio']; ?>" name="nome" class="form-control" placeholder="Come ti chiami?" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="email-<?php echo $annuncio['id_annuncio']; ?>" class="form-label fw-bold small">Tua Email</label>
                                        <input type="email" id="email-<?php echo $annuncio['id_annuncio']; ?>" name="email" class="form-control" placeholder="latua@email.it" required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="messaggio-<?php echo $annuncio['id_annuncio']; ?>" class="form-label fw-bold small">Parlaci di te</label>
                                    <textarea name="messaggio" id="messaggio-<?php echo $annuncio['id_annuncio']; ?>" class="form-control" rows="3" placeholder="Perché vuoi proprio questa casa?" required></textarea>
                                </div>
                                <div class="mb-4">
                                    <label for="foto-<?php echo $annuncio['id_annuncio']; ?>" class="form-label fw-bold small">Allega una tua foto</label>
                                    <input type="file" id="foto-<?php echo $annuncio['id_annuncio']; ?>" name="foto" class="form-control" accept="image/*">
                                    <div class="form-text small">Così i coinquilini sanno chi sei! ✨</div>
                                </div>
                                <button type="submit" class="btn btn-success w-100 fw-bold py-2 shadow-sm">Invia Candidatura 💅</button>
                            </form>
                            <hr class="my-4">
<div class="d-flex justify-content-between align-items-center">
    <p class="small text-muted mb-0">Qualcosa non va? Aiutaci a mantenere la community sicura.</p>
    <button class="btn btn-sm btn-outline-danger" type="button" data-bs-toggle="collapse" data-bs-target="#report-<?php echo $annuncio['id_annuncio']; ?>">
        Segnala Annuncio 🚩
    </button>
</div>

<div class="collapse mt-3" id="report-<?php echo $annuncio['id_annuncio']; ?>">
    <div class="card card-body border-danger bg-light">
        <form action="invia_segnalazione.php" method="POST">
            <input type="hidden" name="id_annuncio" value="<?php echo $annuncio['id_annuncio']; ?>">
            <input type="hidden" name="id_utente_segnalato" value="<?php echo $annuncio['id_utente']; ?>"> 
            
            <div class="mb-3">
                <label for="motivo-<?php echo $annuncio['id_annuncio']; ?>" class="form-label fw-bold small">Perché stai segnalando questo annuncio?</label>
                <select id="motivo-<?php echo $annuncio['id_annuncio']; ?>" name="motivo" class="form-select form-select-sm" required>
                    <option value="" selected disabled>Scegli un motivo...</option>
                    <option value="spam">Spam o Truffa</option>
                    <option value="inappropriato">Contenuto Inappropriato</option>
                    <option value="falso">Informazioni False</option>
                    <option value="altro">Altro...</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="desc-<?php echo $annuncio['id_annuncio']; ?>" class="visually-hidden">Dettagli segnalazione</label>
                <textarea id="desc-<?php echo $annuncio['id_annuncio']; ?>" name="descrizione" class="form-control form-control-sm" rows="2" placeholder="Aggiungi dettagli (opzionale)"></textarea>
            </div>
            <button type="submit" class="btn btn-danger btn-sm w-100 shadow-sm">Invia Segnalazione 💅</button>
        </form>
    </div>
</div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </section>
</div>