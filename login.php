<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="UTF-8" />
    <title>Login - FitCrud</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="css/style.css" />
  </head>
  <body>
    <div id="navbar"></div>

    <main
      class="container d-flex align-items-center justify-content-center"
      style="min-height: 80vh"
    >
      <div class="w-100" style="max-width: 400px">
        <h2 class="mb-4 text-center">Login</h2>
        <!-- dentro do <body> -->
        <form>
          <div class="mb-3">
            <label for="usuario" class="form-label">Usuário</label>
            <input type="text" class="form-control" id="usuario" required />
          </div>
          <div class="mb-3 position-relative">
            <label for="senha" class="form-label">Senha</label>
            <input type="password" class="form-control" id="senha" required />
            <i
              class="fa fa-eye position-absolute top-50 end-0 translate-middle-y me-3"
              data-toggle-password="senha"
              style="cursor: pointer"
            ></i>
          </div>
          <button type="submit" class="btn btn-dark w-100">
            Entrar no Sistema
          </button>
        </form>

        <p class="mt-3 text-center">
          Não possui uma conta? <a href="register.php">Cadastre-se aqui</a>.
        </p>
      </div>
    </main>

    <div id="footer"></div>
    <script src="js/navbar.js"></script>
    <script src="js/footer.js"></script>
    <script src="js/login_register.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
