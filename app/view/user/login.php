<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <title>Login - PhPeso</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>public/css/style.css" />
</head>

<body>
  <?php include_once __DIR__ . '/../templates/navbar.php'; ?>
  <main class="container d-flex align-items-center justify-content-center" style="min-height: 80vh">
    <div class="w-100" style="max-width: 400px">
      <h2 class="mb-4 text-center">Login</h2>
      <?php if (isset($_SESSION['login_error'])) {
        echo '<div class="alert alert-danger">' . $_SESSION['login_error'] . '</div>';
        unset($_SESSION['login_error']);
      } ?>
      <?php if (isset($_SESSION['success_message'])) {
        echo '<div class="alert alert-success">' . $_SESSION['success_message'] . '</div>';
        unset($_SESSION['success_message']);
      } ?>
      <form action="<?= BASE_URL ?>index.php?controller=user&action=login" method="POST">
        <div class="mb-3"><label for="username" class="form-label">Usuário</label><input type="text"
            class="form-control" id="username" name="username" required /></div>
        <div class="mb-3">
          <label for="password" class="form-label">Senha</label>
          <div class="input-group">
            <input type="password" class="form-control" id="password" name="password" required />
            <span class="input-group-text" data-toggle-password="password" style="cursor: pointer;">
              <i class="fas fa-eye"></i>
            </span>
          </div>
        </div>
        <button type="submit" class="btn btn-dark w-100">Entrar no Sistema</button>
      </form>
      <p class="mt-3 text-center">Não possui uma conta? <a
          href="<?= BASE_URL ?>index.php?controller=user&action=showRegister">Cadastre-se aqui</a>.</p>
    </div>
  </main>
  <?php include_once __DIR__ . '/../templates/footer.php'; ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="<?= BASE_URL ?>public/js/login_register.js"></script>
</body>

</html>