<section class="pb-3 px-3 bg-light h-100">
    <div class="row h-100">
        <div class="col-md-12 h-100">
            <div class="card shadow-sm border-0 h-100 d-flex flex-column">
                
                <!-- Header Card -->
                <div class="card-header bg-white border-0 pt-3 px-3 flex-shrink-0 d-flex justify-content-between align-items-center">
                    <h3 class="card-title m-0">Gestione Segnalazioni</h3>
                    <span class="badge bg-danger rounded-pill">
                        <?php echo count($templateParams["AnnunciSegnalati"]); ?> Da Gestire
                    </span>
                </div>

                <!-- Corpo Card con Tabella -->
                <div class="card-body p-0 overflow-auto flex-grow-1" style="min-height: 0;">
                    <table class="table table-hover table-striped mb-0">
                        <thead class="table-light" style="position: sticky; top: 0; z-index: 10;">
                            <tr>
                                <th class="px-3">Oggetto</th>
                                <th>Segnalato da</th>
                                <th>Data</th>
                                <th>Motivo</th>
                                <th class="text-end px-3">Azioni</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($templateParams["AnnunciSegnalati"] as $segnalazione): ?>
                            <tr>
                                <!-- Oggetto Segnalato -->
                                <td class="px-3 align-middle">
                                    <?php 
                                        if(!empty($segnalazione["titolo_annuncio"])){
                                            echo '<span class="fw-bold text-primary"><i class="bi bi-card-text"></i> ' . $segnalazione["titolo_annuncio"] . '</span>';
                                        } else {
                                            echo '<span class="fw-bold text-muted"><i class="bi bi-person"></i> Utente Generico</span>';
                                        }
                                    ?>
                                </td>
                                
                                <!-- Chi ha segnalato -->
                                <td class="align-middle">
                                    <?php echo $segnalazione["email_autore"]; ?>
                                </td>
                                
                                <!-- Data -->
                                <td class="align-middle">
                                    <?php echo date("d/m/Y H:i", strtotime($segnalazione["data_segnalazione"])); ?>
                                </td>
                                
                                <!-- Motivo -->
                                <td class="align-middle">
                                    <span class="badge bg-warning text-dark"><?php echo $segnalazione["motivo"]; ?></span>
                                </td>
                                
                                <!-- Bottone Visualizza Modale -->
                                <td class="text-end px-3 align-middle">
                                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalSegnalazione<?php echo $segnalazione['id_segnalazione']; ?>">
                                        Visualizza
                                    </button>
                                </td>
                            </tr>

                            <!-- MODALE POP-UP -->
                            <div class="modal fade" id="modalSegnalazione<?php echo $segnalazione['id_segnalazione']; ?>" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header bg-light">
                                            <h5 class="modal-title fw-bold">Gestione Segnalazione #<?php echo $segnalazione['id_segnalazione']; ?></h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        
                                        <div class="modal-body">
                                            <div class="row g-3">
                                                <!-- Dettagli Segnalazione -->
                                                <div class="col-md-6">
                                                    <div class="p-3 border rounded bg-light h-100">
                                                        <small class="text-uppercase text-muted fw-bold">Segnalato da</small>
                                                        <p class="mb-0 fw-bold"><?php echo $segnalazione['email_autore']; ?></p>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="p-3 border rounded bg-light h-100">
                                                        <small class="text-uppercase text-muted fw-bold">Contenuto Segnalato</small>
                                                        <?php if(!empty($segnalazione['titolo_annuncio'])): ?>
                                                            <p class="mb-0 fw-bold text-primary"><?php echo $segnalazione['titolo_annuncio']; ?></p>
                                                            <small class="text-muted">Creato da: <?php echo $segnalazione['email_creatore_annuncio'] ?? 'N/D'; ?></small>
                                                        <?php else: ?>
                                                            <p class="mb-0 fw-bold">Profilo Utente</p>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="alert alert-warning mb-0">
                                                        <strong>Motivo:</strong> <?php echo $segnalazione['motivo']; ?><br>
                                                        <hr>
                                                        <p class="mb-0 fst-italic">"<?php echo !empty($segnalazione['descrizione']) ? $segnalazione['descrizione'] : 'Nessuna descrizione extra.'; ?>"</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- FOOTER CON LE AZIONI RICHIESTE -->
                                        <div class="modal-footer bg-light justify-content-between">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Chiudi</button>
                                            
                                            <div class="d-flex gap-2">
                                                
                                                <!-- 1. IGNORA E RISOLVI (Verde) -->
                                                <form action="processa-segnalazione.php" method="POST">
                                                    <input type="hidden" name="id_segnalazione" value="<?php echo $segnalazione['id_segnalazione']; ?>">
                                                    <input type="hidden" name="azione" value="annulla_segnalazione">
                                                    <button type="submit" class="btn btn-success" title="Mantieni tutto e chiudi segnalazione">
                                                        <i class="bi bi-check-lg"></i> Ignora e Risolvi
                                                    </button>
                                                </form>

                                                <?php if(!empty($segnalazione['id_annuncio_segnalato'])): ?>
                                                    <!-- 2. RIMUOVI ANNUNCIO (Giallo) -->
                                                    <form action="processa-segnalazione.php" method="POST">
                                                        <input type="hidden" name="id_segnalazione" value="<?php echo $segnalazione['id_segnalazione']; ?>">
                                                        <input type="hidden" name="id_annuncio" value="<?php echo $segnalazione['id_annuncio_segnalato']; ?>">
                                                        <input type="hidden" name="azione" value="elimina_annuncio">
                                                        <button type="submit" class="btn btn-warning text-dark" onclick="return confirm('Sei sicuro di voler eliminare questo annuncio?');">
                                                            <i class="bi bi-trash"></i> Rimuovi Annuncio
                                                        </button>
                                                    </form>

                                                    <!-- 3. RIMUOVI ANNUNCIO E BANNA UTENTE (Rosso) -->
                                                    <form action="processa-segnalazione.php" method="POST">
                                                        <input type="hidden" name="id_segnalazione" value="<?php echo $segnalazione['id_segnalazione']; ?>">
                                                        <input type="hidden" name="id_annuncio" value="<?php echo $segnalazione['id_annuncio_segnalato']; ?>">
                                                        <!-- Nota: id_creatore_annuncio deve essere presente nella query del DB -->
                                                        <input type="hidden" name="id_utente" value="<?php echo $segnalazione['id_creatore_annuncio'] ?? ''; ?>">
                                                        <input type="hidden" name="azione" value="ban_utente">
                                                        <button type="submit" class="btn btn-danger" onclick="return confirm('ATTENZIONE: Elimini l\'annuncio e BANNI l\'utente per sempre. Confermi?');">
                                                            <i class="bi bi-person-x-fill"></i> Rimuovi & Banna
                                                        </button>
                                                    </form>
                                                <?php endif; ?>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>