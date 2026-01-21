<section class="pb-3 px-3 bg-light h-100">
    <div class="row h-100">
        <div class="col-md-12 h-100">
            <div class="card shadow-sm border-0 h-100 d-flex flex-column">
                
                <!-- Header Card -->
                <div class="card-header bg-white border-0 pt-3 px-3 flex-shrink-0 d-flex justify-content-between align-items-center">
                    <h3 class="card-title m-0">Gestione Utenti</h3>
                    <span class="badge bg-primary rounded-pill">
                        <?php echo count($templateParams["utenti"]); ?> Iscritti
                    </span>
                </div>

                <!-- Corpo Card con Tabella Scorrevole -->
                <div class="card-body p-0 overflow-auto flex-grow-1" style="min-height: 0;">
                    <table class="table table-hover table-striped mb-0">
                        <!-- Header Tabella Fisso -->
                        <thead class="table-light" style="position: sticky; top: 0; z-index: 10;">
                            <tr>
                                <th class="px-3">Utente</th>
                                <th>Email</th>
                                <th>Ruolo</th>
                                <th>Iscritto il</th>
                                <th class="text-end px-3">Azioni</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($templateParams["utenti"] as $utente): ?>
                            <tr>
                                <!-- Nome e Avatar -->
                                <td class="px-3 align-middle py-3">
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle bg-secondary text-white d-flex justify-content-center align-items-center me-3" style="width: 40px; height: 40px; font-weight: bold; font-size: 1.2rem;">
                                            <?php echo strtoupper(substr($utente['nome'], 0, 1)); ?>
                                        </div>
                                        <div>
                                            <span class="fw-bold d-block"><?php echo $utente['nome'] . " " . $utente['cognome']; ?></span>
                                            <!-- Se vuoi mostrare l'ID per debug, scommenta sotto -->
                                            <!-- <small class="text-muted">ID: <?php echo $utente['id_utente']; ?></small> -->
                                        </div>
                                    </div>
                                </td>
                                
                                <!-- Email -->
                                <td class="align-middle text-muted">
                                    <?php echo $utente['email']; ?>
                                </td>
                                
                                <!-- Ruolo con Badge -->
                                <td class="align-middle">
                                    <?php 
                                        $badgeColor = match($utente['ruolo']) {
                                            'super_admin' => 'bg-dark',
                                            'admin_casa'  => 'bg-warning text-dark',
                                            default       => 'bg-info text-white'
                                        };
                                        
                                        // Formattiamo il ruolo per renderlo leggibile (es. admin_casa -> Admin Casa)
                                        $ruoloLeggibile = ucwords(str_replace('_', ' ', $utente['ruolo']));
                                    ?>
                                    <span class="badge <?php echo $badgeColor; ?> rounded-pill px-3 py-2">
                                        <?php echo $ruoloLeggibile; ?>
                                    </span>
                                </td>

                                <!-- Data Iscrizione -->
                                <td class="align-middle text-muted small">
                                    <?php 
                                        // Gestisce il caso in cui la data non ci sia (utenti vecchi)
                                        echo !empty($utente['data_iscrizione']) ? date("d/m/Y", strtotime($utente['data_iscrizione'])) : '<span class="text-muted fst-italic">-</span>'; 
                                    ?>
                                </td>
                                
                                <!-- Azioni: Ban -->
                                <td class="text-end px-3 align-middle">
                                    <!-- Non mostrare il tasto Ban per i Super Admin (non puoi bannarti da sola!) -->
                                    <?php if($utente['ruolo'] != 'super_admin'): ?>
                                    <form action="processa-segnalazione.php" method="POST" class="d-inline">
                                        <!-- Usiamo l'azione specifica per il ban diretto -->
                                        <input type="hidden" name="azione" value="ban_utente_diretto">
                                        <input type="hidden" name="id_utente" value="<?php echo $utente['id_utente']; ?>">
                                        
                                        <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('⚠️ ATTENZIONE ⚠️\n\nStai per eliminare definitivamente <?php echo $utente['nome']; ?>.\n\nVerranno cancellati anche:\n- I suoi annunci\n- Le sue candidature\n- Le sue spese\n\nSei sicura di voler procedere?');">
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
    </div>
</section>