<div class="container my-5">
    <?php if(!isset($_SESSION["id_casa"]) || is_null($_SESSION["id_casa"])): ?>
        <!-- SEZIONE UTENTE SENZA CASA -->
        <div class="row justify-content-center">
            <div class="col-md-8 text-center py-5">
                <div class="card shadow-sm border-0 p-5">
                    <div class="display-1 mb-3">🏠</div>
                    <h2 class="fw-bold">Benvenuto su CoHappy!</h2>
                    <p class="text-muted">Per gestire spese e turni, inserisci il codice invito della tua casa o cercane una negli annunci.</p>
                    
                    <?php if(isset($templateParams["errore_casa"])): ?>
                        <div class="alert alert-danger mt-3"><?php echo $templateParams["errore_casa"]; ?></div>
                    <?php endif; ?>

                    <form action="dashboard.php" method="POST" class="mt-4">
                        <input type="hidden" name="azione" value="unisciti_casa">
                        <div class="input-group mb-3 mx-auto" style="max-width: 450px;">
                            <label for="codice_invito" class="visually-hidden">Codice Invito</label>
                            <input type="text" id="codice_invito" name="codice_invito" class="form-control form-control-lg" placeholder="Codice Invito (es. CH-1234)" required>
                            <button class="btn btn-primary btn-lg fw-bold" type="submit">Unisciti</button>
                        </div>
                    </form>

                    <div class="mt-4">
                        <p class="small text-muted">Oppure</p>
                        <a href="annunci.php" class="btn btn-outline-dark fw-bold">Sfoglia Annunci</a>
                    </div>
                </div>
            </div>
        </div>

    <?php else: ?>
        <!-- SEZIONE DASHBOARD ATTIVA -->
        <div class="row mb-4 align-items-center">
            <div class="col-md-8">
                <h2 class="fw-bold text-dark">Bentornata/o, <?php echo $templateParams["utente"]["nome"]; ?>! 👋</h2>
                <p class="text-muted mb-0">
                    Ecco cosa succede nella 
                    <a href="#" class="fw-bold text-primary text-decoration-none" data-bs-toggle="modal" data-bs-target="#modalCodiceInvito">
                        tua casa 🏠
                    </a> oggi.
                </p>
            </div>
            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                <a href="dashboard.php?azione=abbandona" 
                   class="btn btn-outline-danger fw-bold shadow-sm" 
                   onclick="return confirm('Sei sicuro di voler lasciare questa casa? Non vedrai più spese e turni.')">
                    🚪 Abbandona Casa
                </a>
            </div>
        </div>

        <div class="row g-4">
            <!-- Card Annunci Personali -->
            <div class="col-lg-4">
                <div class="card shadow-sm border-0 h-100 bg-light">
                    <div class="card-body d-flex flex-column">
                        <h5 class="fw-bold mb-4 text-dark">📢 I miei annunci</h5>

                        <?php if(count($templateParams["miei_annunci"]) > 0): ?>
                            <?php 
                            $anteprima = array_slice($templateParams["miei_annunci"], 0, 3);
                            foreach($anteprima as $annuncio): 
                            ?>
                                <div class="mb-3 pb-2 border-bottom">
                                    <h6 class="fw-bold mb-0 small"><?php echo htmlspecialchars($annuncio['titolo']); ?></h6>
                                    <div class="d-flex justify-content-between small">
                                        <span class="text-muted"><?php echo htmlspecialchars($annuncio['luogo']); ?></span>
                                        <span class="fw-bold text-success"><?php echo number_format($annuncio['prezzo'], 2); ?>€</span>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                            <a href="miei_annunci.php" class="btn btn-outline-dark btn-sm w-100 mt-auto">Vedi tutte</a>
                        <?php else: ?>
                            <div class="text-center flex-grow-1 d-flex flex-column justify-content-center">
                                <p class="small text-muted mb-0">Non ci sono annunci attivi.</p>
                                <?php if($templateParams["utente"]["ruolo"] === "admin_casa"): ?>
                                    <button type="button" class="btn btn-outline-dark btn-sm w-100 mt-auto" data-bs-toggle="modal" data-bs-target="#modalNuovoAnnuncio">Pubblica ora</button>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Card Spese -->
            <div class="col-lg-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body d-flex flex-column">
                        <h5 class="fw-bold mb-4">💸 Spese Recenti</h5>
                        <ul class="list-group list-group-flush mb-3">
                            <?php if(!empty($templateParams["spese_recenti"])): ?>
                                <?php foreach($templateParams["spese_recenti"] as $spesa): ?>
                                    <li class="list-group-item px-0 border-0 d-flex justify-content-between align-items-center">
                                        <div>
                                            <div class="fw-bold small"><?php echo htmlspecialchars($spesa['descrizione']); ?></div>
                                            <div class="text-muted" style="font-size: 0.75rem;">Inserita da <?php echo htmlspecialchars($spesa['nome_autore']); ?></div>
                                        </div>
                                        <span class="text-danger fw-bold">-<?php echo number_format($spesa['importo'], 2); ?>€</span>
                                    </li>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p class="text-muted small">Nessuna spesa recente.</p>
                            <?php endif; ?>
                        </ul>
                        <a href="spese.php" class="btn btn-outline-dark btn-sm w-100 mt-auto">Vedi tutte</a>
                    </div>
                </div>
            </div>

            <!-- Card Pulizie -->
            <div class="col-lg-4">
                <div class="card shadow-sm border-0 h-100 bg-light">
                    <div class="card-body text-center d-flex flex-column">
                        <h5 class="fw-bold mb-4 text-start">🧹 Turno Pulizie</h5>
                        <div class="py-4">
                            <div class="display-6 mb-2">🧴</div>
                            <h6 class="fw-bold mb-1">Questa settimana tocca a:</h6>
                            <h4 class="text-primary fw-bold">
                                <?php echo htmlspecialchars($templateParams["prossimo_turno"]["nome"] ?? "Nessuno assegnato"); ?>
                            </h4>
                            <p class="small text-muted">Zona: <?php echo htmlspecialchars($templateParams["prossimo_turno"]["compito"] ?? "Generale"); ?></p>
                        </div>
                        <a href="pulizie.php" class="btn btn-outline-dark btn-sm w-100 mt-auto">Gestisci turni</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- SEZIONE TABELLA GESTIONE ANNUNCI -->
        <div class="row mt-5">
            <div class="col-12">
                <div class="card shadow-sm border-0 p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="fw-bold mb-0">Gestione Annunci Casa</h4>
                        <?php if($templateParams["utente"]["ruolo"] === "admin_casa"): ?>
                            <button type="button" class="btn btn-success fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#modalNuovoAnnuncio">
                                + Nuovo Annuncio
                            </button>
                        <?php endif; ?>
                    </div>
                    
                    <?php if(count($templateParams["miei_annunci"]) > 0): ?>
                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead>
                                    <tr>
                                        <th>Foto</th>
                                        <th>Titolo</th>
                                        <th>Città</th>
                                        <th>Prezzo</th>
                                        <?php if($templateParams["utente"]["ruolo"] === "admin_casa"): ?>
                                            <th class="text-end">Azioni</th>
                                        <?php endif; ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($templateParams["miei_annunci"] as $annuncio): ?>
                                        <tr>
                                            <!-- ANTEPRIMA FOTO AGGIUNTA -->
                                            <td>
                                                <img src="<?php echo !empty($annuncio['immagine']) ? htmlspecialchars($annuncio['immagine']) : 'img/nophoto.png'; ?>" 
                                                     alt="" class="rounded border shadow-sm" 
                                                     style="width: 50px; height: 50px; object-fit: cover;">
                                            </td>
                                            <td class="fw-bold"><?php echo htmlspecialchars($annuncio["titolo"]); ?></td>
                                            <td><?php echo htmlspecialchars($annuncio["luogo"]); ?></td>
                                            <td><span class="badge bg-light text-dark"><?php echo number_format($annuncio["prezzo"], 2); ?>€</span></td>
                                            <?php if($templateParams["utente"]["ruolo"] === "admin_casa"): ?>
                                                <td class="text-end">
                                                    <div class="d-flex justify-content-end gap-2">
                                                        <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalModificaAnnuncio<?php echo $annuncio['id_annuncio']; ?>">
                                                            <i class="bi bi-pencil"></i> Modifica
                                                        </button>
                                                        <a href="processa_annuncio.php?azione=elimina&id=<?php echo $annuncio['id_annuncio']; ?>" 
                                                           class="btn btn-sm btn-outline-danger" 
                                                           onclick="return confirm('Sei sicuro di voler eliminare questo annuncio?')">
                                                            <i class="bi bi-trash"></i> Elimina
                                                        </a>
                                                    </div>
                                                </td>
                                            <?php endif; ?>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <p class="text-muted">Non ci sono annunci creati per questa abitazione.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<!-- MODALI -->
<?php if(isset($_SESSION["id_casa"])): ?>
    
    <!-- MODALE NUOVO ANNUNCIO -->
    <div class="modal fade" id="modalNuovoAnnuncio" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title fw-bold">📢 Pubblica nuovo annuncio</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="processa_annuncio.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="azione" value="inserisci">
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label for="titolo" class="form-label fw-bold">Titolo dell'annuncio</label>
                            <input type="text" id="titolo" name="titolo" class="form-control" placeholder="Esempio: Stanza singola in centro" required>
                        </div>
                        <div class="mb-3">
                            <label for="descrizione_appartamento" class="form-label fw-bold">Descrizione dettagliata</label>
                            <textarea name="descrizione" id="descrizione_appartamento" class="form-control" rows="4" placeholder="Descrivi la casa..." required></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="mensilità" class="form-label fw-bold">Prezzo mensile (€)</label>
                                <input type="number" id="mensilità" name="prezzo" step="0.01" class="form-control" placeholder="0.00" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="luogo" class="form-label fw-bold">Città / Zona</label>
                                <input type="text" id="luogo" name="luogo" class="form-control" placeholder="Esempio: Cesena" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="foto_alloggio" class="form-label fw-bold">Foto dell'alloggio</label>
                            <input type="file" id="foto_alloggio" name="immagine" class="form-control" accept="image/*">
                            <div class="form-text">Se non carichi nulla, verrà usata la foto predefinita.</div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Annulla">Annulla</button>
                        <button type="submit" class="btn btn-primary px-4 fw-bold">Pubblica ora</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODALI MODIFICA -->
    <?php foreach($templateParams["miei_annunci"] as $annuncio): ?>
        <div class="modal fade" id="modalModificaAnnuncio<?php echo $annuncio['id_annuncio']; ?>" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content border-0 shadow-lg">
                    <div class="modal-header bg-warning text-dark">
                        <h5 class="modal-title fw-bold">✏️ Modifica Annuncio</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="processa_annuncio.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="azione" value="modifica">
                        <input type="hidden" name="id_annuncio" value="<?php echo $annuncio['id_annuncio']; ?>">
                        <div class="modal-body p-4 text-start">
                            <div class="mb-3">
                                <label for="titolo_<?php echo $annuncio['id_annuncio']; ?>" class="form-label fw-bold" >Titolo dell'annuncio</label>
                                <input type="text" id="titolo_<?php echo $annuncio['id_annuncio']; ?>" name="titolo" class="form-control" value="<?php echo htmlspecialchars($annuncio['titolo']); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="desc_<?php echo $annuncio['id_annuncio']; ?>" class="form-label fw-bold">Descrizione dettagliata</label>
                                <textarea name="descrizione" id="desc_<?php echo $annuncio['id_annuncio']; ?>" class="form-control" rows="4" required><?php echo htmlspecialchars($annuncio['descrizione']); ?></textarea>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="prezzo_<?php echo $annuncio['id_annuncio']; ?>" class="form-label fw-bold">Prezzo mensile (€)</label>
                                    <input type="number" name="prezzo" step="0.01" id="prezzo_<?php echo $annuncio['id_annuncio']; ?>" class="form-control" value="<?php echo $annuncio['prezzo']; ?>" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="luogo_<?php echo $annuncio['id_annuncio']; ?>" class="form-label fw-bold">Città / Zona</label>
                                    <input type="text" id="luogo_<?php echo $annuncio['id_annuncio']; ?>" name="luogo" class="form-control" value="<?php echo htmlspecialchars($annuncio['luogo']); ?>" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="img_<?php echo $annuncio['id_annuncio']; ?>" class="form-label fw-bold">Cambia foto (opzionale)</label>
                                <input type="file" id="img_<?php echo $annuncio['id_annuncio']; ?>" name="immagine" class="form-control" accept="image/*">
                                <div class="form-text">Carica una nuova foto per sostituire quella attuale.</div>
                            </div>
                        </div>
                        <div class="modal-footer bg-light">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Annulla">Annulla</button>
                            <button type="submit" class="btn btn-warning fw-bold px-4" aria-label="Salva modifiche">Salva Modifiche</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php endforeach; ?>

    <!-- MODALE CODICE INVITO -->
    <div class="modal fade" id="modalCodiceInvito" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content border-0 shadow-lg text-center">
                <div class="modal-header border-0 pb-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="display-6 mb-3">🏠</div>
                    <h5 class="fw-bold mb-2">Codice della Casa</h5>
                    <div class="bg-light p-3 rounded-3 border border-primary border-dashed d-flex flex-column gap-2">
                    <span class="h4 fw-bold text-primary mb-0">
                        <?php echo $templateParams["utente"]["codice_invito"] ?? "CH-NON-DISP"; ?>
                    </span>
                    
                    <button type="button" 
                            class="btn btn-sm btn-link text-decoration-none btn-copy-code" 
                            data-code="<?php echo $templateParams["utente"]["codice_invito"]; ?>"
                            onclick="copyToClipboard()">
                        <i class="bi bi-clipboard"></i> Copia codice
                    </button>
                </div>
                </div>
            </div>
        </div>
    </div>

<?php endif; ?>