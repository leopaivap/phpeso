<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <title>Cadastro - PhPeso</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>public/css/style.css" />
  <link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>public/css/register.css" />
</head>

<body>
  <?php include_once __DIR__ . '/../templates/navbar.php'; ?>
  <main class="container d-flex align-items-center justify-content-center" style="min-height: 80vh">
    <div class="w-100">
      <h2 class="mb-4 text-center">Criar Conta</h2>
      <?php if (isset($_SESSION['error_message'])) {
        echo '<div class="alert alert-danger">' . $_SESSION['error_message'] . '</div>';
        unset($_SESSION['error_message']);
      } ?>
      <form class="register-form" action="<?= BASE_URL ?>index.php?controller=user&action=insert" method="POST">
        <div class="userData" style="width: 100%;">
          <div class="row">
            <div class="col-md-6 mb-3"><label for="firstName" class="form-label">Nome</label><input type="text"
                class="form-control" id="firstName" name="firstName" required /></div>
            <div class="col-md-6 mb-3"><label for="lastName" class="form-label">Sobrenome</label><input type="text"
                class="form-control" id="lastName" name="lastName" required /></div>
          </div>
          <div class="mb-3"><label for="phoneNumber" class="form-label">Telefone</label><input type="text"
              class="form-control" id="phoneNumber" name="phoneNumber" required /></div>
          <div class="mb-3"><label for="gender" class="form-label">Gênero</label><select class="form-select" id="gender"
              name="gender" required>
              <option value="">Selecione...</option>
              <option value="male">Masculino</option>
              <option value="female">Feminino</option>
              <option value="other">Outro</option>
            </select></div>
          <div class="mb-3"><label for="birth_date" class="form-label">Data de Nascimento</label><input type="date"
              class="form-control" id="birth_date" name="birth_date" required /></div>
        </div>
        <div class="userLoginData">
          <div class="mb-3"><label for="username" class="form-label">Usuário</label><input type="text"
              class="form-control" id="username" name="username" required /></div>
          <div class="mb-3"><label for="email" class="form-label">Email</label><input type="email" class="form-control"
              id="email" name="email" required /></div>
          <div class="mb-3">
            <label for="password" class="form-label">Senha</label>
            <div class="input-group">
              <input type="password" class="form-control password-input-register" id="password" name="password"
                required />
              <span class="input-group-text toggle-password-register" style="cursor: pointer;">
                <i class="fas fa-eye password-icon-register"></i>
              </span>
            </div>
          </div>
          <div class="mb-3">
            <label for="confirmPassword" class="form-label">Confirmar Senha</label>
            <div class="input-group">
              <input type="password" class="form-control password-input-register" id="confirmPassword"
                name="confirmPassword" required />
              <span class="input-group-text toggle-password-register" style="cursor: pointer;">
                <i class="fas fa-eye password-icon-register"></i>
              </span>
            </div>
          </div>
          <div class="mb-3"><label for="role" class="form-label">Tipo de Conta</label><select class="form-select"
              id="role" name="role">
              <option value="client">Cliente</option>
              <option value="trainer">Treinador</option>
              <option value="admin">Administrador</option>
            </select></div>
        </div>
        <button type="submit" class="register-btn btn btn-dark w-100">Registrar</button>
      </form>
    </div>
  </main>
  <?php include_once __DIR__ . '/../templates/footer.php'; ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="<?= BASE_URL ?>public/js/login_register.js"></script>
</body>

</html>