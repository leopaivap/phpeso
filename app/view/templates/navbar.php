<nav class="navbar navbar-expand-lg navbar-dark bg-dark px-3">
    <a class="navbar-brand text-orange" href="<?= BASE_URL ?>index.php">PhPeso</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navLinks">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navLinks">
        <ul class="navbar-nav ms-auto">
            <?php if (isset($_SESSION['user_loggedin']) && $_SESSION['user_loggedin'] === true): ?>
                <li class="nav-item"><span class="nav-link text-warning">Olá,
                        <?= htmlspecialchars($_SESSION['user_firstname']) ?>!</span></li>
                <li class="nav-item"><a class="nav-link"
                        href="<?= BASE_URL ?>index.php?controller=workout&action=list">Treinos</a>
                </li>
                <li class="nav-item"><a class="nav-link"
                        href="<?= BASE_URL ?>index.php?controller=exercise&action=list">Exercícios</a></li>
                <li class="nav-item"><a class="nav-link"
                        href="<?= BASE_URL ?>index.php?controller=user&action=logout">Logout</a>
                </li>
            <?php else: ?>
                <li class="nav-item"><a class="nav-link"
                        href="<?= BASE_URL ?>index.php?controller=user&action=showLogin">Login</a></li>
                <li class="nav-item"><a class="nav-link"
                        href="<?= BASE_URL ?>index.php?controller=user&action=showRegister">Registrar</a></li>
            <?php endif; ?>
        </ul>
    </div>
</nav>