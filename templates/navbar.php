<?php

// Garante que a sessão seja iniciada para que possamos verificar o login
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark px-3">
    <a class="navbar-brand text-orange" href="index.php">PhPeso</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navLinks">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navLinks">
        <ul class="navbar-nav ms-auto">
            <?php if (isset($_SESSION['user_loggedin']) && $_SESSION['user_loggedin'] === true): ?>
                <li class="nav-item"><a class="nav-link" href="workouts.php">Treinos</a></li>
                <li class="nav-item"><a class="nav-link" href="exercises.php">Exercícios</a></li>
                <li class="nav-item"><span class="nav-link text-warning">Olá, <?= htmlspecialchars($_SESSION['user_username']) ?>!</span></li>
                <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
            <?php else: ?>
                <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
                <li class="nav-item"><a class="nav-link" href="register.php">Registrar</a></li>
            <?php endif; ?>
        </ul>
    </div>
</nav>
