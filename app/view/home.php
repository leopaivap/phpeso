<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>PhPeso - Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="public/css/style.css" />
    <link rel="stylesheet" type="text/css" href="public/css/how-it-works.css" />
</head>

<body class="bg-white text-dark">
    <?php include_once __DIR__ . '/templates/navbar.php'; ?>

    <main class="container mt-5">
        <section class="row align-items-center">
            <div class="col-md-6">
                <h1 class="display-4 text-orange">PhPeso</h1>
                <p class="lead">
                    Gerencie seus treinos de academia com facilidade! Visualize,
                    adicione e acompanhe seus treinos e exercícios de forma simples.
                </p>
            </div>
            <div class="col-md-6 text-center">
                <img src="public/assets/home.jpg" alt="Imagem academia" class="img-fluid rounded" />
            </div>
        </section>
        <section id="how-it-works-section">
            <div class="section-header">
                <h2>Como funciona? <span></span></h2>
                <p>Avalie, treine com propósito e acompanhe sua evolução de forma prática e contínua.</p>
            </div>
            <div class="how-it-works-cards">
                <div class="how-it-works-card">
                    <h3>Realize Avaliações Físicas</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Amet, rerum? Alias harum iure esse quo.</p>
                </div>
                <div class="how-it-works-card">
                    <h3>Crie Treinos Personalizados</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Amet, rerum? Alias harum iure esse quo.</p>
                </div>
                <div class="how-it-works-card">
                    <h3>Acompanhe sua evolução</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Amet, rerum? Alias harum iure esse quo.</p>
                </div>
            </div>
            <div class="how-it-works-cta">
                <span class="hiw-cta">Saiba Mais</span>
            </div>
        </section>

        <section class="mt-5">
            <h2 class="h4">Treinos Recentes</h2>
            <ul class="list-group mt-3">
                <li class="list-group-item">
                    <a href="#" class="text-decoration-none text-dark">Treino Peito - 10/04/2025</a>
                </li>
                <li class="list-group-item">
                    <a href="#" class="text-decoration-none text-dark">Treino Pernas - 08/04/2025</a>
                </li>
                <li class="list-group-item">
                    <a href="#" class="text-decoration-none text-dark">Treino Costas - 05/04/2025</a>
                </li>
            </ul>
        </section>
    </main>

    <?php include_once __DIR__ . '/templates/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>