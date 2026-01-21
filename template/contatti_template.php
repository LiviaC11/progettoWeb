<div class="container my-5">
    <div class="text-center mb-5">
        <h2 class="fw-bold">Hai bisogno di aiuto?</h2>
        <p class="text-muted">Siamo qui per risolvere i tuoi problemi di convivenza (o tecnici)!</p>
    </div>

    <div class="row g-5">
        
        <!-- COLONNA SINISTRA: Info e FAQ -->
        <div class="col-md-5">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body p-4">
                    <h4 class="mb-3">📍 Dove siamo</h4>
                    <p class="mb-1"><strong>Campus Universitario</strong></p>
                    <p class="text-muted">Via dell'Università 123, Bologna</p>
                    
                    <h4 class="mt-4 mb-3">📞 Contatti </h4>
                    <p class="mb-1">📧 <a href="mailto:support@cohappy.it" class="text-decoration-none">support@cohappy.it</a></p>
                    <p class="mb-0">📱 +39 051 1234567 (Lun-Ven, 9-18)</p>
                </div>
            </div>

            <!-- FAQ Accordion -->
            <h4 class="mb-3">Domande Frequenti</h4>
            <div class="accordion shadow-sm" id="faqAccordion">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                            Come resetto la password?
                        </button>
                    </h2>
                    <div id="faq1" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body small">
                            Vai nella pagina di Login e clicca su "Password dimenticata". Ti invieremo un link via email.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                            Posso cancellare un annuncio?
                        </button>
                    </h2>
                    <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body small">
                            Sì, vai nella tua dashboard personale e clicca sull'icona del cestino accanto al tuo annuncio.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- COLONNA DESTRA: Form di Contatto -->
        <div class="col-md-7">
            <div class="card shadow-lg border-0">
                <div class="card-body p-5">
                    <h3 class="mb-4">Scrivici un messaggio</h3>
                    <form action="#" method="POST">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="nome" class="form-label">Nome</label>
                                <input type="text" class="form-control" id="nome" required>
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" required>
                            </div>
                            <div class="col-12">
                                <label for="oggetto" class="form-label">Oggetto</label>
                                <select class="form-select" id="oggetto">
                                    <option selected>Seleziona un motivo...</option>
                                    <option value="1">Segnalazione Bug</option>
                                    <option value="2">Problema con un Utente</option>
                                    <option value="3">Informazioni Generali</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label for="messaggio" class="form-label">Messaggio</label>
                                <textarea class="form-control" id="messaggio" rows="5" required></textarea>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-dark w-100 py-2 fw-bold">Invia Messaggio</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>