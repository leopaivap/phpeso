<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>PhPeso - Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>/public/css/style.css" />
</head>

<body class="bg-white text-dark">
    <?php include_once __DIR__ . '/templates/navbar.php'; ?>

    <main class="container mt-5">
        <section class="row align-items-center">
            <div class="col-md-6">
                <h1><span class="text-orange">Uma plataforma de treinos</span> pensada especialmente para<br> o seu
                    resultado!
                </h1>
                <p class="lead">
                    Acesse seus treinos, acompanhe sua evolução e receba orientações personalizadas.
                </p>
                <span class="home-cta">Cadastre-se e comece agora!</p>
            </div>
            <div class="col-md-6 text-center">
                <img src="public/assets/home.webp" alt="Imagem academia" class="img-fluid rounded" />
            </div>
        </section>

        <section id="about">
            <img src="public/assets/about.webp" alt="Imagem academia" class="img-fluid rounded col-md-6" />
            <div class="section-header col-md-6">
                <h2>Sobre<br>a academia<span></span></h2>
                <p>A phpeso é uma academia moderna com estrutura completa, treinos personalizados e acompanhamento
                    profissional. Oferecemos aulas e programas para todos os níveis, focando em saúde, bem-estar e
                    resultados reais. Aqui, você treina com motivação e faz parte de uma comunidade que evolui junta.
                </p>
            </div>
        </section>

        <section id="modalities">
            <div class="section-header">
                <h2>Nossas Modalidades<span></span></h2>
                <p>Explore nossas opções de treino.</p>
            </div>
            <div class="modalities-list">
                <div class="modalities-card">
                    <i class="fa-solid fa-dumbbell"></i>
                    <h3>Musculação</h3>
                    <p>Desenvolva força, resistência e definição muscular com treinos personalizados</p>
                </div>
                <div class="modalities-card">
                    <i class="fas fa-running"></i>
                    <h3>Ginástica</h3>
                    <p>Melhore sua flexibilidade, coordenação e condicionamento com aulas dinâmicas</p>
                </div>
                <div class="modalities-card">
                    <i class="fa-solid fa-music"></i>
                    <h3>Hit Box</h3>
                    <p>Uma combinação intensa de boxe e treino funcional para queimar calorias e aliviar o estresse</p>
                </div>
            </div>
            <div class="modalities-cta">
                <span class="btn-cta-modalities">
                    Confira Nossos Horários
                </span>
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
                    <p>Faça avaliações completas para entender seu condicionamento atual e definir metas reais com base
                        em dados precisos.</p>
                </div>
                <div class="how-it-works-card">
                    <h3>Crie Treinos Personalizados</h3>
                    <p>Monte treinos sob medida para cada aluno com base em objetivos, nível físico e histórico, tudo de
                        forma prática e organizada.</p>
                </div>
                <div class="how-it-works-card">
                    <h3>Acompanhe sua evolução</h3>
                    <p>Monitore resultados em tempo real com gráficos, relatórios e histórico de desempenho para manter
                        a motivação e ajustar estratégias.</p>
                </div>
            </div>
            <div class="how-it-works-cta">
                <span class="hiw-cta">Saiba Mais</span>
            </div>
        </section>

        <section id="free-trial-cta">
            <h2>Faça uma aula<br>
                experimental <strong>gratuita</strong></h2>
            <span class="free-trial-cta">Agende sua Aula</span>
        </section>

        <section id="user-feedback-section">
            <div class="section-header">
                <h2>O que dizem<br>nossos clientes <span></span></h2>
                <p>Confira os feedbacks de usuários reais e veja como nosso método faz a diferença.</p>
            </div>

            <div class="user-feedback-list">
                <div class="user-feedback-card">
                    <div class="user-feedback-card-circle">
                        <img src="public/assets/juliana.webp" alt="Imagem de perfil do usuário Juliana Machado.">
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

    </main>

    <?php include_once __DIR__ . '/templates/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>