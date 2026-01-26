<div class="d-flex flex-column bg-light layout-smart">

    <div class="pt-4 px-3 pb-3 flex-shrink-0">
        <div class="row">
            <div class="col-md-4 mb-2">
                <div class="card text-center p-3 shadow-sm border-0">
                    <div class="fs-3">👨‍💻</div>
                    <div class="card-title"><h3 class="m-0"><?php echo $templateParams["numUtenti"]; ?></h3></div>
                    <div class="text-muted small">Utenti Totali</div>
                </div>
            </div>
            <div class="col-md-4 mb-2">
                <div class="card text-center p-3 shadow-sm border-0">
                    <div class="fs-3">📢</div>
                    <div class="card-title"><h3 class="m-0"><?php echo $templateParams["numAnnunciAtt"]; ?></h3></div>
                    <div class="text-muted small">Annunci Attivi</div>
                </div>
            </div>
            <div class="col-md-4 mb-2">
                <div class="card text-center p-3 shadow-sm border-0 bg-danger text-white">
                    <div class="fs-3">⚠️</div>
                    <div class="card-title"><h3 class="m-0"><?php echo $templateParams["numSegnalazioniAtt"]; ?></h3></div>
                    <div class="small">Segnalazioni</div>
                </div>
            </div>
        </div>
    </div>

    <div class="px-3 pb-3 flex-grow-1 d-flex flex-column" style="min-height: 0;">
        <div class="row h-100">
            
            <div class="col-md-6 h-100 mt-1">
                <div class="card shadow-sm border-0 h-100 d-flex flex-column">
                    <div class="card-header bg-white border-0 pt-3 px-3 flex-shrink-0">
                        <h3 class="card-title m-0">Nuovi utenti:</h3>
                    </div>
                    <div class="card-body p-0 overflow-auto tabella-smart">
                        <table class="table table-hover table-striped mb-0">
                            <thead class="table-light" style="position: sticky; top: 0; z-index: 10;">
                                <tr>
                                    <th class="px-3">Nome e Cognome</th>
                                    <th>Email</th>
                                    <th>Ruolo</th>
                                    <th class="text-end px-3">Azioni</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($templateParams["UtentiOggi"] as $Utente):?>
                                <tr>
                                    <td class="px-3 align-middle">
                                        <?php echo htmlspecialchars($Utente["nome"] . " " . $Utente["cognome"]); ?>
                                    </td>
                                    <td class="align-middle"><?php echo htmlspecialchars($Utente["email"]); ?></td>
                                    <td class="align-middle"><?php echo htmlspecialchars($Utente["ruolo"]); ?></td>
                                    <td class="text-end px-3 align-middle">
                                        <?php if($Utente['ruolo'] != 'super_admin'): ?>
                                        <form action="processa-segnalazione.php" method="POST" class="d-inline">
                                            <input type="hidden" name="azione" value="ban_utente_diretto">
                                            <input type="hidden" name="id_utente" value="<?php echo $Utente['id_utente']; ?>">
                                            
                                            <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('⚠️ ATTENZIONE ⚠️\n\nStai per eliminare definitivamente <?php echo htmlspecialchars($Utente['nome']); ?>.\n\nVerranno cancellati anche:\n- I suoi annunci\n- Le sue candidature\n- Le sue spese\n\nSei sicura di voler procedere?');">
                                                <i class="bi bi-person-x-fill"></i> Ban
                                            </button>
                                        </form>
                                        <?php else: ?>
                                            <span class="text-muted small"><i class="bi bi-shield-lock"></i> Protetto</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div> 
                </div>
            </div>

            <div class="col-md-6 h-100 mt-1">
                <div class="card shadow-sm border-0 h-100 d-flex flex-column">
                    <div class="card-header bg-white border-0 pt-3 px-3 flex-shrink-0">
                        <h3 class="card-title m-0">Segnalazioni:</h3>
                    </div>
                    <div class="card-body p-0 overflow-auto tabella-smart">
                        <table class="table table-hover table-striped mb-0">
                            <thead class="table-light" style="position: sticky; top: 0; z-index: 10;">
                                <tr>
                                    <th class="px-3">Titolo</th>
                                    <th>Autore</th>
                                    <th>Data</th>
                                    <th>Motivo</th>
                                    <th class="text-center px-3">Azioni</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($templateParams["AnnunciSegnalati"] as $segnalazione): ?>
                                <tr>
                                    <td class="px-3 align-middle py-4" style="white-space: normal; word-wrap: break-word; max-width: 200px;">
                                        <?php echo htmlspecialchars($segnalazione["titolo_annuncio"]); ?>
                                    </td>
                                    <td class="align-middle py-4" style="white-space: normal; word-wrap: break-word; max-width: 200px;">
                                        <?php echo htmlspecialchars($segnalazione["email_autore"]); ?>
                                    </td>
                                    <td class="align-middle py-4" style="white-space: normal; word-wrap: break-word; max-width: 200px;">
                                        <?php echo date("d/m/Y", strtotime($segnalazione["data_segnalazione"])); ?>
                                    </td>
                                    <td class="align-middle py-4" style="white-space: normal; word-wrap: break-word; max-width: 200px;">
                                        <?php echo htmlspecialchars($segnalazione["motivo"]); ?>
                                    </td>
                                    <td class="text-end px-3 align-middle">
                                        <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalSegnalazioneHome<?php echo $segnalazione['id_segnalazione']; ?>">
                                            <i class="bi bi-eye"></i> Visualizza
                                        </button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<?php foreach($templateParams["AnnunciSegnalati"] as $segnalazione): ?>
<div class="modal fade" id="modalSegnalazioneHome<?php echo $segnalazione['id_segnalazione']; ?>" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title fw-bold">Dettaglio Segnalazione #<?php echo $segnalazione['id_segnalazione']; ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body text-start">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="p-3 border rounded bg-light h-100">
                            <small class="text-uppercase text-muted fw-bold">Segnalato da</small>
                            <p class="mb-0 fw-bold"><?php echo htmlspecialchars($segnalazione['email_autore']); ?></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 border rounded bg-light h-100">
                            <small class="text-uppercase text-muted fw-bold">Contenuto Segnalato</small>
                            <?php if(!empty($segnalazione['titolo_annuncio'])): ?>
                                <p class="mb-0 fw-bold text-primary"><?php echo htmlspecialchars($segnalazione['titolo_annuncio']); ?></p>
                                <small class="text-muted">Creato da: <?php echo htmlspecialchars($segnalazione['email_creatore_annuncio'] ?? 'N/D'); ?></small>
                            <?php else: ?>
                                <p class="mb-0 fw-bold">Profilo Utente</p>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="alert alert-warning mb-0">
                            <strong>Motivo:</strong> <?php echo htmlspecialchars($segnalazione['motivo']); ?><br>
                            <hr>
                            <p class="mb-0 fst-italic">"<?php echo !empty($segnalazione['descrizione']) ? htmlspecialchars($segnalazione['descrizione']) : 'Nessuna descrizione extra.'; ?>"</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer bg-light justify-content-between">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Chiudi</button>
                
                <div class="d-flex gap-2">
                    <form action="processa-segnalazione.php" method="POST">
                        <input type="hidden" name="id_segnalazione" value="<?php echo $segnalazione['id_segnalazione']; ?>">
                        <input type="hidden" name="azione" value="annulla_segnalazione">
                        <button type="submit" class="btn btn-success" title="Chiudi segnalazione">
                            <i class="bi bi-check-lg"></i> Ignora
                        </button>
                    </form>

                    <?php if(!empty($segnalazione['id_annuncio_segnalato'])): ?>
                        <form action="processa-segnalazione.php" method="POST">
                            <input type="hidden" name="id_segnalazione" value="<?php echo $segnalazione['id_segnalazione']; ?>">
                            <input type="hidden" name="id_annuncio" value="<?php echo $segnalazione['id_annuncio_segnalato']; ?>">
                            <input type="hidden" name="azione" value="elimina_annuncio">
                            <button type="submit" class="btn btn-warning text-dark" onclick="return confirm('Sei sicuro di voler eliminare questo annuncio?');">
                                <i class="bi bi-trash"></i> Elimina
                            </button>
                        </form>

                        <form action="processa-segnalazione.php" method="POST">
                            <input type="hidden" name="id_segnalazione" value="<?php echo $segnalazione['id_segnalazione']; ?>">
                            <input type="hidden" name="id_annuncio" value="<?php echo $segnalazione['id_annuncio_segnalato']; ?>">
                            <input type="hidden" name="id_utente" value="<?php echo $segnalazione['id_creatore_annuncio'] ?? ''; ?>">
                            <input type="hidden" name="azione" value="ban_utente">
                            <button type="submit" class="btn btn-danger" onclick="return confirm('ATTENZIONE: Elimini l\'annuncio e BANNI l\'utente per sempre. Confermi?');">
                                <i class="bi bi-person-x-fill"></i> Ban & Del
                            </button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>