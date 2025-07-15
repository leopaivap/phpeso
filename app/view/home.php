<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>PhPeso - Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="public/css/style.css" />
    <link rel="stylesheet" type="text/css" href="public/css/how-it-works.css" />
    <link rel="stylesheet" type="text/css" href="public/css/user-feedback.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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

        <section id="user-feedback-section">
            <div class="section-header">
                <h2>O que dizem<br>nossos clientes <span></span></h2>
                <p>Confira os feedbacks de usuários reais e veja como nosso método faz a diferença.</p>
            </div>

            <div class="user-feedback-list">
                <div class="user-feedback-card">
                    <div class="user-feedback-card-circle">
                        <img src="public/assets/juliana.webp" alt="Imagem de perfil do usuário Arielce Junior.">
                    </div>
                    <h3>Juliana Machado</h3>
                    <div class="d-flex">
                        <?php
                        for ($i = 0; $i < 5; $i++) {
                            echo "<i class='fa-solid fa-star'></i>";
                        }
                        ?>
                    </div>
                    <p>"Acompanhamento de qualidade e ensino claro me mantiveram focada e em progresso."</p>
                </div>

                <div class="user-feedback-card">
                    <div class="user-feedback-card-circle">
                        <img src="public/assets/arielce.webp" alt="Imagem de perfil do usuário Arielce Junior.">
                    </div>
                    <h3>Arielce Junior</h3>
                    <div class="d-flex">
                        <?php
                        for ($i = 0; $i < 5; $i++) {
                            if ($i === 4) {
                                echo "<i class='fa-regular fa-star'></i>";
                                continue;
                            }
                            echo "<i class='fa-solid fa-star'></i>";
                        }
                        ?>
                    </div>
                    <p>"Suporte rápido e plataforma intuitiva tornaram minha jornada mais fácil e eficiente."</p>
                </div>
                <div class="user-feedback-card">
                    <div class="user-feedback-card-circle">
                        <img src="public/assets/gustavo.webp" alt="Imagem de perfil do usuário Gustavo Luiz.">
                    </div>
                    <h3>Gustavo Luiz</h3>
                    <div class="d-flex">
                        <?php
                        for ($i = 0; $i < 5; $i++) {
                            echo "<i class='fa-solid fa-star'></i>";
                        }
                        ?>
                    </div>
                    <p>"Treinos organizados e professores atenciosos me ajudaram a evoluir com clareza."</p>
                </div>
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