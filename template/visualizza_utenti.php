<section class="pb-3 px-3 bg-light h-100">
    <div class="row h-100">
        <div class="col-md-12 h-100">
            <div class="card shadow-sm border-0 h-100 d-flex flex-column">
                
                <!-- Header Card -->
                <div class="card-header bg-white border-0 pt-3 px-3 flex-shrink-0 d-flex justify-content-between align-items-center">
                    <h2 class="card-title m-0 h3">Gestione Utenti</h2> <!-- h3 per gerarchia corretta -->
                    <span class="badge bg-primary rounded-pill">
                        <?php echo count($templateParams["utenti"]); ?> Iscritti
                    </span>
                </div>

                <!-- Corpo Card con Tabella Scorrevole -->
                <div class="card-body p-0 overflow-auto flex-grow-1" style="min-height: 0;">
                    <!-- Aggiunto caption per accessibilità (slide 4_html_tabelle) -->
                    <table class="table table-hover table-striped mb-0" summary="Tabella contenente la lista degli utenti registrati con dettagli su ruolo e azioni disponibili">
                        <caption class="visually-hidden">Lista degli utenti registrati alla piattaforma</caption>
                        
                        <!-- Header Tabella Fisso -->
                        <thead class="table-light" style="position: sticky; top: 0; z-index: 10;">
                            <tr>
                                <!-- Aggiunto scope="col" per accessibilità (slide 13_accessibilità) -->
                                <th scope="col" class="px-3">Utente</th>
                                <th scope="col">Email</th>
                                <th scope="col">Ruolo</th>
                                <th scope="col">Iscritto il</th>
                                <th scope="col" class="text-end px-3">Azioni</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($templateParams["utenti"] as $utente): ?>
                            <tr>
                                <!-- Nome e Avatar -->
                                <td class="px-3 align-middle py-3">
                                    <div class="d-flex align-items-center">
                                        <!-- aria-hidden per elementi puramente decorativi -->
                                        <div class="rounded-circle bg-secondary text-white d-flex justify-content-center align-items-center me-3" aria-hidden="true" style="width: 40px; height: 40px; font-weight: bold; font-size: 1.2rem;">
                                            <?php echo strtoupper(substr($utente['nome'], 0, 1)); ?>
                                        </div>
                                        <div>
                                            <span class="fw-bold d-block"><?php echo $utente['nome'] . " " . $utente['cognome']; ?></span>
                                        </div>
                                    </div>
                                </td>
                                
                                <!-- Email -->
                                <td class="align-middle text-muted">
                                    <a href="mailto:<?php echo $utente['email']; ?>" class="text-decoration-none text-muted"><?php echo $utente['email']; ?></a>
                                </td>
                                
                                <!-- Ruolo con Badge -->
                                <td class="align-middle">
                                    <?php 
                                        $badgeColor = match($utente['ruolo']) {
                                            'super_admin' => 'bg-dark',
                                            'admin_casa'  => 'bg-warning text-dark',
                                            default       => 'bg-primary'
                                        };
                                        $ruoloLeggibile = ucwords(str_replace('_', ' ', $utente['ruolo']));
                                    ?>
                                    <span class="badge <?php echo $badgeColor; ?> rounded-pill px-3 py-2">
                                        <?php echo $ruoloLeggibile; ?>
                                    </span>
                                </td>

                                <!-- Data Iscrizione -->
                                <td class="align-middle text-muted small">
                                    <time datetime="<?php echo !empty($utente['data_iscrizione']) ? $utente['data_iscrizione'] : ''; ?>">
                                        <?php echo !empty($utente['data_iscrizione']) ? date("d/m/Y", strtotime($utente['data_iscrizione'])) : '-'; ?>
                                    </time>
                                </td>
                                
                                <!-- Azioni: Ban -->
                                <td class="text-end px-3 align-middle">
                                    <?php if($utente['ruolo'] != 'super_admin'): ?>
                                    <form action="processa-segnalazione.php" method="POST" class="d-inline">
                                        <input type="hidden" name="azione" value="ban_utente_diretto">
                                        <input type="hidden" name="id_utente" value="<?php echo $utente['id_utente']; ?>">
                                        
                                        <button type="submit" class="btn btn-outline-danger btn-sm" aria-label="Banna utente <?php echo $utente['nome']; ?>" onclick="return confirm('⚠️ ATTENZIONE ⚠️\n\nStai per eliminare definitivamente <?php echo $utente['nome']; ?>.\n\nVerranno cancellati anche:\n- I suoi annunci\n- Le sue candidature\n- Le sue spese\n\nSei sicura di voler procedere?');">
                                            <i class="bi bi-person-x-fill" aria-hidden="true"></i> Ban
                                        </button>
                                    </form>
                                    <?php else: ?>
                                        <span class="text-muted small"><i class="bi bi-shield-lock" aria-hidden="true"></i> Protetto</span>
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