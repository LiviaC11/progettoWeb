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
                                        <?php echo $Utente["nome"]?> <?php echo $Utente["cognome"]?>
                                    </td>
                                    <td class="align-middle"><?php echo $Utente["email"]?></td>
                                    <td class="align-middle"><?php echo $Utente["ruolo"]?></td>
                                    <td class="text-end px-3 align-middle">
                                        <button type="button" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-pencil"></i> Edit
                                        </button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div> </div>
            </div>

            <div class="col-md-6 h-100 mt-1">
                <div class="card shadow-sm border-0 h-100 d-flex flex-column">
                    <div class="card-header bg-white border-0 pt-3 px-3 flex-shrink-0">
                        <h3 class="card-title m-0">Segnalazioni:</h3>
                    </div>
            <!-- ... (codice precedente del contenitore) ... -->
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
                                    <!-- Titolo dell'annuncio segnalato -->
                                <td class="px-3 align-middle py-4" style="white-space: normal; word-wrap: break-word; max-width: 200px;">
                                    <?php echo $segnalazione["titolo_annuncio"]; ?>
                                </td>
                                    
                                    <!-- Email dell'autore della segnalazione -->
                                <td class="align-middle py-4" style="white-space: normal; word-wrap: break-word; max-width: 200px;">
                                    <?php echo $segnalazione["email_autore"]; ?>
                                </td>
                                    
                                    <!-- Data della segnalazione (formattata) -->
                                <td class="align-middle py-4" style="white-space: normal; word-wrap: break-word; max-width: 200px;">
                                    <?php echo date("d/m/Y", strtotime($segnalazione["data_segnalazione"])); ?>
                                </td>
                                    
                                    <!-- Motivo della segnalazione -->
                                <td class="align-middle py-4" style="white-space: normal; word-wrap: break-word; max-width: 200px;">
                                    <?php echo $segnalazione["motivo"]; ?>
                                </td>
                                    
                                    <!-- Azioni (Bottone Edit/Risolvi) -->
                                <td class="text-end px-3 align-middle">
                                    <button type="button" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-pencil"></i> Visualizza
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