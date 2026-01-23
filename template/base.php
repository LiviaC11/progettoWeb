<!DOCTYPE html>
<html lang="it"> <!-- Lang attribute obbligatorio -->
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="CoHappy - Gestione coinquilini, spese e turni pulizie per studenti universitari.">
        
        <title><?php echo isset($templateParams["titolo"]) ? $templateParams["titolo"] : "CoHappy"; ?></title>

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
            xintegrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        
        <!-- Bootstrap Icons -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        
        <link rel="stylesheet" href="css/style.css">
    </head>

<body class="bg-white d-flex flex-column min-vh-100">
    <!-- Header semantico -->
    <header>
        <nav class="navbar navbar-expand-lg bg-dark sticky-top navbar-dark" aria-label="Navigazione principale">
            <div class="container-fluid">
                <a class="navbar-brand fw-bold" href="index.php"><span aria-hidden="true">🏠</span> CoHappy</a>
                
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link <?php isActive("index.php") ?>" 
                               <?php echo (basename($_SERVER['PHP_SELF']) == 'index.php') ? 'aria-current="page"' : ''; ?> 
                               href="index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php isActive("annunci.php") ?>" 
                               <?php echo (basename($_SERVER['PHP_SELF']) == 'annunci.php') ? 'aria-current="page"' : ''; ?>
                               href="annunci.php">Annunci</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php isActive("contatti.php") ?>" 
                               <?php echo (basename($_SERVER['PHP_SELF']) == 'contatti.php') ? 'aria-current="page"' : ''; ?>
                               href="contatti.php">Contatti</a>
                        </li>
                    </ul>
                    <div class="d-flex align-items-center">
                        <?php if(isset($_SESSION["id_utente"])): ?>
                            <a href="dashboard.php" class="text-white me-3 small text-decoration-none px-2 py-1 rounded" aria-label="Vai alla tua dashboard personale">Ciao, <strong><?php echo htmlspecialchars($_SESSION["nome"]); ?></strong></a>
                            <a href="logout.php" class="btn btn-outline-light btn-sm fw-bold">Logout</a>
                        <?php else: ?>
                            <a href="login.php" class="btn btn-light text-primary fw-bold text-black">Login</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <main class="flex-grow-1">
    <?php
        if(isset($templateParams["nome"])){
            require($templateParams["nome"]);
        }
    ?>
    </main>

    <!-- Footer semantico e FISSO -->
    <footer class="bg-dark text-white text-center py-3 fixed-bottom">
        <div class="container">
            <p class="mb-0">&copy; 2026 CoHappy - Progetto Tecnologie Web</p>
        </div>
    </footer>

    <?php if(!isCookieAccepted()): ?>
    <div id="cookie-banner" class="alert alert-dark text-center mb-0 shadow-lg" role="alert">
        <div class="container d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
            <span>
                🍪 Questo sito utilizza cookie tecnici per migliorare la tua esperienza. 
                Chiudendo questo banner o cliccando su "Accetta", acconsenti al loro utilizzo.
            </span>
            <div class="d-flex gap-2">
                <button type="button" id="accept-cookies" class="btn btn-sm btn-warning fw-bold text-dark">Accetta</button>            </div>
        </div>
    </div>
    <?php endif; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/cookie.js"></script>

    <?php if(basename($_SERVER['PHP_SELF']) == 'annunci.php'): ?>
        <script src="js/annunci.js"></script>
    <?php endif; ?>
</body>
</html>