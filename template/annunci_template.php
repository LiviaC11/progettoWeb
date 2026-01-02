    <main class="container my-4">
        <h2 class="mb-4 text-center">Annunci Disponibili</h2>

        <section class="filters mb-4">
            <div class="card card-body shadow-sm">
                <form class="row g-3">
                    <div class="col-md-4">
                        <input type="text" class="form-control" placeholder="Cerca città o zona...">
                    </div>
                    <div class="col-md-4">
                        <select class="form-select">
                            <option selected>Budget max...</option>
                            <option value="1">Sotto 300€</option>
                            <option value="2">300€ - 500€</option>
                            <option value="3">Oltre 500€</option>
                        </select>
                    </div>
                    <div class="col-md-4 d-flex align-items-center flex-wrap gap-2">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="tag1">
                            <label class="form-check-label" for="tag1">#AnimaliAmmessi</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="tag2">
                            <label class="form-check-label" for="tag2">#NoFumatori</label>
                        </div>
                    </div>
                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-dark w-100">Filtra Risultati</button>
                    </div>
                </form>
            </div>
        </section>

        <section class="row g-4">
    <?php foreach($templateParams["annunci"] as $annuncio): ?>
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card h-100 shadow-sm">
                <img src="https://via.placeholder.com/400x250" class="card-img-top" alt="<?php echo $annuncio['titolo']; ?>">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h5 class="card-title"><?php echo $annuncio['titolo']; ?></h5>
                        <span class="badge bg-success"><?php echo $annuncio['prezzo']; ?>€/mese</span>
                    </div>
                    <p class="card-text text-muted small"><?php echo $annuncio['descrizione']; ?></p>
                    
                    <button class="btn btn-outline-primary w-100" data-bs-toggle="modal" data-bs-target="#modal-<?php echo $annuncio['id_annuncio']; ?>">
                        Contattaci!!
                    </button>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal-<?php echo $annuncio['id_annuncio']; ?>" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Candidatura per: <?php echo $annuncio['titolo']; ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="risposta.php" enctype="multipart/form-data">
                            <input type="hidden" name="id_annuncio" value="<?php echo $annuncio['id_annuncio']; ?>">
                            <div class="mb-3">
                                <label class="form-label">Nome Completo</label>
                                <input type="text" name="nome" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Parlaci di te</label>
                                <textarea name="messaggio" class="form-control" rows="3"></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Carica una tua foto</label>
                                <input type="file" name="foto" class="form-control">
                            </div>
                            <button type="submit" class="btn btn-success w-100">Invia Candidatura</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</section>