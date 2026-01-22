<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm border-0 p-4">
                <h2 class="fw-bold mb-3 text-center">Recupero Password</h2>
                <p class="text-muted text-center mb-4">Inserisci la tua email. Ti invieremo un link per impostare una nuova password.</p>
                
                <form action="invia_recupero.php" method="POST">
                    <div class="mb-3">
                        <label for="email" class="form-label fw-bold">Email di registrazione</label>
                        <input type="email" id="email" name="email" class="form-control" placeholder="esempio@mail.it" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 fw-bold py-2">Invia link di recupero</button>
                </form>
                <div class="text-center mt-3">
                    <a href="login.php" class="small text-decoration-none">Torna al Login</a>
                </div>
            </div>
        </div>
    </div>
</div>