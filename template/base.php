<!DOCTYPE html>
<html lang="it">
    <head>
        <title>CoHappy - Home</title>
         <meta name="viewport" content="width=device-width, initial-scale=1" />

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="css/style.css">
    </head>

<body class="bg-white d-flex flex-column min-vh-100">
<nav class="navbar navbar-expand-lg bg-dark sticky-top navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold " href="index.php">🏠 CoHappy</a>
            <!--
                data-bs-toggle serve per dire a js di far partire l'effetto collapse
                data-bs-target invece dice quale classe prendere 
            -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav"> <!--classe per il menù a tendina-->
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link active " href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link " href="annunci.php">Annunci</a></li>
                    <li class="nav-item"><a class="nav-link " href="contatti.php">Contatti</a></li>
                </ul>
                <div class="d-flex">
                    <a href="login.php" class="btn btn-light text-primary fw-bold text-black">Login</a>
                </div>
            </div>
        </div>
    </nav>

        <main class="flex-grow-1">
    <?php
        // Qui avviene la magia: carica il file specifico (home, login, ecc)
        if(isset($templateParams["nome"])){
            require($templateParams["nome"]);
        }
    ?>
    </main>

        <footer  class="bg-dark text-white text-center py-3 mt-auto"><div class="container"> CoHappy - limited 2026</div></footer>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </body>    
</html>